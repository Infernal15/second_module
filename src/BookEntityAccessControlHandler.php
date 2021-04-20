<?php

namespace Drupal\abyss;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Book entity entity.
 *
 * @see \Drupal\abyss\Entity\BookEntity.
 */
class BookEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\abyss\Entity\BookEntityInterface $entity */

    switch ($operation) {

      case 'view':
      case 'update':
      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'administer comments');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'administer comments');
  }


}
