<?php

namespace Drupal\facets\Widget;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Plugin\PluginBase;
use Drupal\facets\FacetInterface;
use Drupal\facets\Result\Result;
use Drupal\facets\Result\ResultInterface;

/**
 * A base class for widgets that implements most of the boilerplate.
 */
abstract class WidgetPluginBase extends PluginBase implements WidgetPluginInterface {

  /**
   * Show the amount of results next to the result.
   *
   * @var bool
   */
  protected $showNumbers;

  /**
   * The facet the widget is being built for.
   *
   * @var \Drupal\facets\FacetInterface
   */
  protected $facet;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->setConfiguration($configuration);
  }

  /**
   * {@inheritdoc}
   */
  public function build(FacetInterface $facet) {
    $this->facet = $facet;

    $items = array_map(function (Result $result) use ($facet) {
      if (empty($result->getUrl())) {
        return $this->buildResultItem($result);
      }

      return $this->buildListItems($facet, $result);
    }, $facet->getResults());

    $widget = $facet->getWidget();

    $urlProcessorManager = \Drupal::service('plugin.manager.facets.url_processor');
    /** @var \Drupal\facets\UrlProcessor\UrlProcessorInterface $url_processor */
    $url_processor = $urlProcessorManager->createInstance($facet->getFacetSourceConfig()->getUrlProcessorName(), ['facet' => $facet]);

    return [
      '#theme' => $this->getFacetItemListThemeHook($facet),
      '#facet' => $facet,
      '#items' => $items,
      '#attributes' => [
        'data-drupal-facet-filter-key' => $url_processor->getFilterKey(),
        'data-drupal-facet-id' => $facet->id(),
        'data-drupal-facet-alias' => $facet->getUrlAlias(),
        'class' => [$facet->getActiveItems() ? 'facet-active' : 'facet-inactive'],
      ],
      '#context' => !empty($widget['type']) ? ['list_style' => $widget['type']] : [],
    ];
  }

  /**
   * Provides a full array of possible theme functions to try for a given hook.
   *
   * This allows the following template suggestions:
   *  - facets-item-list--WIDGET_TYPE--FACET_ID
   *  - facets-item-list--WIDGET_TYPE
   *  - facets-item-list.
   *
   * @param \Drupal\facets\FacetInterface $facet
   *   The facet whose output is being generated.
   *
   * @return string
   *   A theme hook name with suggestions, suitable for the #theme property.
   */
  protected function getFacetItemListThemeHook(FacetInterface $facet) {
    $type = $facet->getWidget()['type'] ?? 'std';
    return 'facets_item_list__' . $type . '__' . $facet->id();
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['show_numbers' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = NestedArray::mergeDeep(
      $this->defaultConfiguration(),
      $configuration
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function getQueryType() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FacetInterface $facet) {
    $form['show_numbers'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show the amount of results'),
      '#default_value' => $this->getConfiguration()['show_numbers'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    return [];
  }

  /**
   * Builds a renderable array of result items.
   *
   * @param \Drupal\facets\FacetInterface $facet
   *   The facet we need to build.
   * @param \Drupal\facets\Result\ResultInterface $result
   *   A result item.
   *
   * @return array
   *   A renderable array of the result.
   */
  protected function buildListItems(FacetInterface $facet, ResultInterface $result) {
    $classes = ['facet-item'];
    $items = $this->prepareLink($result);

    $children = $result->getChildren();
    // Check if we need to expand this result.
    if ($children && ($this->facet->getExpandHierarchy() || $result->isActive() || $result->hasActiveChildren())) {

      $child_items = [];
      $classes[] = 'facet-item--expanded';
      foreach ($children as $child) {
        $child_items[] = $this->buildListItems($facet, $child);
      }

      $items['children'] = [
        '#theme' => $this->getFacetItemListThemeHook($facet),
        '#items' => $child_items,
      ];

      if ($result->hasActiveChildren()) {
        $classes[] = 'facet-item--active-trail';
      }

    }
    else {
      if ($children) {
        $classes[] = 'facet-item--collapsed';
      }
    }

    if ($result->isActive()) {
      $items['#attributes']['class'][] = 'is-active';
    }

    $urlProcessorManager = \Drupal::service('plugin.manager.facets.url_processor');
    /** @var \Drupal\facets\UrlProcessor\UrlProcessorInterface $url_processor */
    $url_processor = $urlProcessorManager->createInstance($facet->getFacetSourceConfig()->getUrlProcessorName(), ['facet' => $facet]);

    $items['#wrapper_attributes'] = ['class' => $classes];
    $items['#attributes']['data-drupal-facet-item-id'] = Html::getClass($facet->getUrlAlias() . '-' . strtr($result->getRawValue(), ' \'\"', '---'));
    $items['#attributes']['data-drupal-facet-item-value'] = $result->getRawValue();
    $items['#attributes']['data-drupal-facet-item-count'] = $result->getCount();
    $items['#attributes']['data-drupal-facet-filter-value'] = $facet->getUrlAlias() . $url_processor->getSeparator() . $result->getRawValue();

    if ($facet->getShowOnlyOneResult()) {
      $items['#attributes']['data-drupal-facet-single-selection-group'] = Html::getClass($facet->getUrlAlias());
    }

    return $items;
  }

  /**
   * Returns the text or link for an item.
   *
   * @param \Drupal\facets\Result\ResultInterface $result
   *   A result item.
   *
   * @return array
   *   The item as a render array.
   */
  protected function prepareLink(ResultInterface $result) {
    $item = $this->buildResultItem($result);

    if (!is_null($result->getUrl())) {
      $item = (new Link($item, $result->getUrl()))->toRenderable();
    }

    return $item;
  }

  /**
   * Builds a facet result item.
   *
   * @param \Drupal\facets\Result\ResultInterface $result
   *   The result item.
   *
   * @return array
   *   The facet result item as a render array.
   */
  protected function buildResultItem(ResultInterface $result) {
    $count = $result->getCount();
    return [
      '#theme' => 'facets_result_item',
      '#is_active' => $result->isActive(),
      '#value' => $result->getDisplayValue(),
      '#show_count' => $this->getConfiguration()['show_numbers'] && ($count !== NULL),
      '#count' => $count,
      '#facet' => $result->getFacet(),
      '#raw_value' => $result->getRawValue(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isPropertyRequired($name, $type) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsFacet(FacetInterface $facet) {
    return TRUE;
  }

}
