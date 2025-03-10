<?php

namespace Drupal\facets\Plugin\facets\processor;

use Drupal\Core\Cache\UnchangingCacheableDependencyTrait;
use Drupal\Core\Form\FormStateInterface;
use Drupal\facets\FacetInterface;
use Drupal\facets\Processor\BuildProcessorInterface;
use Drupal\facets\Processor\ProcessorPluginBase;
use Drupal\facets\FacetManager\DefaultFacetManager;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a processor that makes a facet depend on the state of another facet.
 *
 * @FacetsProcessor(
 *   id = "dependent_processor",
 *   label = @Translation("Dependent facet"),
 *   description = @Translation("Display this facet depending on the state of another facet."),
 *   stages = {
 *     "build" = 5
 *   }
 * )
 */
class DependentFacetProcessor extends ProcessorPluginBase implements BuildProcessorInterface, ContainerFactoryPluginInterface {

  use UnchangingCacheableDependencyTrait;

  /**
   * The language manager.
   *
   * @var \Drupal\facets\FacetManager\DefaultFacetManager
   */
  protected $facetsManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $facetStorage;

  /**
   * Constructs a new object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\facets\FacetManager\DefaultFacetManager $facets_manager
   *   The language manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DefaultFacetManager $facets_manager, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->facetsManager = $facets_manager;
    $this->facetStorage = $entity_type_manager->getStorage('facets_facet');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('facets.manager'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FacetInterface $current_facet) {
    $build = [];

    $config = $this->getConfiguration();

    // Loop over all defined blocks and filter them by provider, this builds an
    // array of blocks that are provided by the facets module.
    /** @var \Drupal\facets\Entity\Facet[] $facets */
    $facets = $this->facetStorage->loadMultiple();
    foreach ($facets as $facet) {
      if ($facet->getFacetSourceId() !== $current_facet->getFacetSourceId()) {
        continue;
      }

      if ($facet->id() === $current_facet->id()) {
        continue;
      }

      $build[$facet->id()]['label'] = [
        '#title' => $facet->getName(),
        '#type' => 'label',
      ];

      $build[$facet->id()]['enable'] = [
        '#title' => $this->t('Enable condition'),
        '#type' => 'checkbox',
        '#default_value' => !empty($config[$facet->id()]['enable']),
      ];

      $build[$facet->id()]['condition'] = [
        '#title' => $this->t('Condition mode'),
        '#type' => 'radios',
        '#options' => [
          'presence' => $this->t('Check whether the facet is present.'),
          'not_empty' => $this->t('Check whether the facet is selected / not empty.'),
          'values' => $this->t('Check whether the facet is set to specific values.'),
        ],
        '#default_value' => empty($config[$facet->id()]['condition']) ? NULL : $config[$facet->id()]['condition'],
        '#states' => [
          'visible' => [
            ':input[name="facet_settings[' . $this->getPluginId() . '][settings][' . $facet->id() . '][enable]"]' => ['checked' => TRUE],
          ],
        ],
      ];

      $build[$facet->id()]['values'] = [
        '#title' => $this->t('Values'),
        '#type' => 'textfield',
        '#default_value' => empty($config[$facet->id()]['values']) ? '' : $config[$facet->id()]['values'],
        '#description' => $this->t('Enter a comma-separated list of values. Example: value1, value2, value3'),
        '#states' => [
          'visible' => [
            ':input[name="facet_settings[' . $this->getPluginId() . '][settings][' . $facet->id() . '][enable]"]' => ['checked' => TRUE],
            ':input[name="facet_settings[' . $this->getPluginId() . '][settings][' . $facet->id() . '][condition]"]' => ['value' => 'values'],
          ],
        ],
      ];

      $build[$facet->id()]['negate'] = [
        '#title' => $this->t('Negate condition'),
        '#type' => 'checkbox',
        '#default_value' => !empty($config[$facet->id()]['negate']),
        '#states' => [
          'visible' => [
            ':input[name="facet_settings[' . $this->getPluginId() . '][settings][' . $facet->id() . '][enable]"]' => ['checked' => TRUE],
          ],
        ],
      ];
    }

    return parent::buildConfigurationForm($form, $form_state, $current_facet) + $build;
  }

  /**
   * {@inheritdoc}
   */
  public function build(FacetInterface $facet, array $results) {
    $conditions = $this->getConfiguration();

    foreach ($conditions as $facet_id => $condition) {
      if (empty($condition['enable'])) {
        continue;
      }
      $enabled_conditions[$facet_id] = $condition;
    }

    // Return as early as possible when there are no settings for allowed
    // facets.
    if (empty($enabled_conditions)) {
      return $results;
    }

    foreach ($enabled_conditions as $facet_id => $condition_settings) {
      /** @var \Drupal\facets\Entity\Facet $current_facet */
      $current_facet = $this->facetStorage->load($facet_id);
      $current_facet = $this->facetsManager->returnBuiltFacet($current_facet);
      $facet->addCacheableDependency($current_facet);

      if (!$this->isConditionMet($condition_settings, $current_facet)) {
        return [];
      }
    }

    return $results;
  }

  /**
   * Check if the condition for a given facet is met.
   *
   * @param array $condition_settings
   *   The condition settings for the facet to check.
   * @param \Drupal\facets\FacetInterface $facet
   *   The facet to check.
   *
   * @return bool
   *   TRUE if the condition is met.
   */
  public function isConditionMet(array $condition_settings, FacetInterface $facet) {
    $return = TRUE;

    if ($condition_settings['condition'] === 'not_empty') {
      $return = !empty($facet->getActiveItems());
    }

    if ($condition_settings['condition'] === 'values') {
      $return = FALSE;

      $values = array_map('trim', explode(',', $condition_settings['values']));
      foreach ($facet->getActiveItems() as $value) {
        if (in_array($value, $values)) {
          $return = TRUE;
          break;
        }
      }
    }

    if (!empty($condition_settings['negate'])) {
      $return = !$return;
    }

    return $return;
  }

  public function supportsFacet(FacetInterface $facet) {
    // Only support facets as entities, not e.g. facets_exposed_filters.
    return $facet->getFacetType() == 'facet_entity';
  }

}
