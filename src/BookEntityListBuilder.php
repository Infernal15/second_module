<?php

namespace Drupal\abyss;

use Drupal\abyss\Entity\BookEntity;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Book entity entities.
 *
 * @ingroup abyss
 */
class BookEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $entity = BookEntity::create();
    $user_form = \Drupal::service('entity.form_builder')->getForm($entity, 'default');

    $header['id'] = $this->t('Book entity ID');
    $header['name'] = $this->t('User name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\abyss\Entity\BookEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.book_entity.edit_form',
      ['book_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
