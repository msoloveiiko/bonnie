<?php

namespace Drupal\bonnie;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Bonnie entity.
 *
 * @see \Drupal\bonnie\Entity\Bonnie.
 */
class BonnieAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bonnie\Entity\BonnieInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished bonnie entities');
        }

        return AccessResult::allowedIfHasPermission($account, 'view published bonnie entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit bonnie entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete bonnie entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add bonnie entities');
  }

}
