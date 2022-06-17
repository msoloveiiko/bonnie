<?php

namespace Drupal\bonnie\Controller;

/**
 * @file
 * Contains \Drupal\bonnie\Controller\BonnieController.
 *
 * @return
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\bonnie\Entity\Bonnie;

/**
 * Provides route responses for the bonnie module.
 */
class BonnieController extends ControllerBase {

  /**
   * Returns a page.
   *
   * @return array
   *   A renderable array.
   */
  public function content() {

    // Get a renderable BonnieForm array.
    $bonnie = Bonnie::Create();
    $bonnieForm = \Drupal::service('entity.form_builder')->getForm($bonnie, 'default');
    // Get View for bonnie.
    $view = views_embed_view('bonnie');

    // Return renderable array.
    return [
      // Template name for current controller.
      '#theme' => 'bonnie_template',
      '#form' => $bonnieForm,
      '#view' => $view,
    ];
  }

}
