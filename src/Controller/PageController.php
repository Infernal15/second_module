<?php


namespace Drupal\abyss\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;

/**
 * Class PageController
 *
 * @package Drupal\abyss\Controller
 */
class PageController extends ControllerBase {

  /**
   * @return string[]
   *   {@inheritdoc}
   *   Performs rendering to display the form, saved information,
   *   and pager to navigate pages with broken information.
   */
  public function page() {
    $node = $this->entityTypeManager()->getStorage('book_entity')->create();

    $renderer = $this->entityFormBuilder()->getForm($node);

    $entity = \Drupal::entityTypeManager()->getStorage('book_entity');
    $query = $entity->getQuery();
    $ids = $query->condition('status', 1)
      ->sort('created', 'DESC') #sorted
      ->pager(5) #limit 5 items
      ->execute();

    $entities = $entity->loadMultiple($ids);

    $fields = [];
    $i = 0;
    foreach ($entities as $entity) {
      $fields[$i]['id'] = $entity->id();
      $fields[$i]['name'] = $entity->name->getValue()[0]['value'];
      $fields[$i]['email'] = $entity->email->getValue()[0]['value'];
      $fields[$i]['phone'] = $entity->phone->getValue()[0]['value'];
      $fields[$i]['response'] = $entity->response->getValue()[0]['value'];
      if (!is_null($entity->avatar->getValue()[0]['target_id'])) {
        $file = File::load($entity->avatar->getValue()[0]['target_id']);
        $fields[$i]['avatar'] = $file->createFileUrl();;
      }
      else {
        global $base_path;
        $fields[$i]['avatar'] = $base_path . drupal_get_path('module', 'abyss') . '/images/256.svg';
      }
      if (!is_null($entity->response_image->getValue()[0]['target_id'])) {
        $file = File::load($entity->response_image->getValue()[0]['target_id']);
        $fields[$i]['response_image'] = $file->createFileUrl();;
      }

      $i++;
    }

    // Checking user rights.
    $user = \Drupal::currentUser();
    $user_admin = $user->hasPermission('administer comments');

    // Data generation for return for Abyss Theme hook.
    $build['comment'] = [
      '#theme' => 'abyss',
      '#fields' => $fields,
      '#form' => $renderer,
      '#user' => ['admin' => $user_admin],
    ];

    $build['pager'] = [
      '#theme' => 'pager',
      '#type' => 'pager',
    ];

    return $build;
  }

}
