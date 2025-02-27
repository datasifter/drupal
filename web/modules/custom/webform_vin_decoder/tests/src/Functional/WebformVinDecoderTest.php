<?php

namespace Drupal\Tests\webform_vin_decoder\Functional;

use Drupal\Core\Url;
use Drupal\Tests\webform\Functional\WebformBrowserTestBase;

/**
 * Tests for webform vin decoder.
 *
 * @group webform_vin_decoder
 */
class WebformVinDecoderTest extends WebformBrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['webform_vin_decoder'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->user = $this->drupalCreateUser(['administer site configuration']);
    $this->drupalLogin($this->user);
  }

  /**
   * Tests that the home page loads with a 200 response.
   */
  public function testLoad() {
    $this->drupalGet(Url::fromRoute('<front>'));
    $this->assertSession()->statusCodeEquals(200);
  }


}
