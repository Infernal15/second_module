<?php

namespace Drupal\abyss\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Form controller for Book entity edit forms.
 *
 * @ingroup abyss
 */
class BookEntityForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   *
  */
  protected $is_save;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->is_save = false;
    /* @var \Drupal\abyss\Entity\BookEntity $entity */
    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result"></div>',
    ];

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);

    $actions['submit'] += [
      '#ajax' => [
        'callback' => '::sendForm',
        'event' => 'click',
      ],
    ];

    $actions['submit']['#validate'][] = '::validating';

    return $actions;
  }

  /**
   * {@inheritdoc}
   * Sequential form validation function.
   * Completes its execution when an error is found.
   * The error is further output thanks to the sendForm function.
   */
  public function validating(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $form_state->clearErrors();
    $len = mb_strlen($form_state->getValue('name')[0]['value']);
    if ($len < 2 || $len > 100) {
      if ($len < 2) {
        $form_state->setErrorByName('name', $this->t('The name is too short.'));
      }
      else {
        $form_state->setErrorByName('name', $this->t('The name is too long.'));
      }
      return;
    }

    if (!\Drupal::service('email.validator')->isValid($form_state->getValue('email')[0]['value'])) {
      $form_state->setErrorByName('email', $this->t('Invalid email.'));
      return;
    }

    $phone = $form_state->getValue('phone')[0]['value'];
    $phone = str_replace(' ', '', $phone);
    $phone = str_replace('+', '', $phone);
    $phone = str_replace('-', '', $phone);
    $phone = str_replace('(', '', $phone);
    $phone = str_replace(')', '', $phone);
    $phone = str_replace('[', '', $phone);
    $phone = str_replace(']', '', $phone);
    $phone = str_replace('{', '', $phone);
    $phone = str_replace('}', '', $phone);

    if (!preg_match('/^\d[\d\(\)\ -]{4,10}\d$/', $phone)) {
      $phone_size = mb_strlen($phone);
      if ($phone_size < 12) {
        $form_state->setErrorByName('phone', $this->t('Phone number is too short.'));
      }
      elseif ($phone_size > 12) {
        $form_state->setErrorByName('phone', $this->t('Phone number is too long.'));
      }
      else {
        $form_state->setErrorByName('phone', $this->t('Phone is incorrect.'));
      }
      return;
    }
    else {
      $form_state->setValue('phone'[0]['value'], $phone);
    }

    $len = mb_strlen($form_state->getValue('response')[0]['value']);
    if ($len === 0) {
      $form_state->setErrorByName('response', $this->t('Response is require.'));
    }
  }

  /**
   * Callback for AjaxForm.
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *
   *
   *   {@inheritdoc}
   *   Displays information about the save status.
   */
  public function sendForm(array &$form, FormStateInterface &$form_state): AjaxResponse {
    $response = new AjaxResponse();
    if ($this->is_save === FALSE) {

      foreach ($form_state->getErrors() as $error) {
        $response->addCommand(new MessageCommand($error, '.result', ['type' => 'error']));
      }
      $form_state->clearErrors();
    }
    else {
      $form_state->setRedirect('entity.book_entity.page');
      $url = Url::fromRoute('entity.book_entity.page');
      $command = new RedirectCommand($url->toString());
      $response->addCommand($command);
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Book entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Book entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.book_entity.page');
    $this->is_save = TRUE;
  }

}
