<?php

namespace Drupal\abyss\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Book entity entities.
 */
class BookEntityViewsData extends EntityViewsData {

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
