<?php

namespace Drupal\bonnie\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Bonnie entities.
 */
class BonnieViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
