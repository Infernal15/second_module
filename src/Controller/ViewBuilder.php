<?php


namespace Drupal\abyss\Controller;


use Drupal\Core\Entity\EntityViewBuilder;


class ViewBuilder extends EntityViewBuilder {
  public function entity_view_multiple() {
    $view_builder = \Drupal::entityTypeManager()
      ->getViewBuilder('book_entity');
    return $view_builder->viewMultiple([1,2]);
  }
}
