<?php

namespace Drupal\bonnie\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Bonnie edit forms.
 *
 * @ingroup bonnie
 */
class BonnieForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

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
    /** @var \Drupal\bonnie\Entity\Bonnie $entity */
    $form = parent::buildForm($form, $form_state);
    $form['system_messages'] = [
      '#markup' => '<div id="form-valid-message"></div>',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    $element['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#submit' => ['::submitForm', '::save'],
      '#ajax' => [
        'callback' => '::save',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
        ],
      ],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (!$form_state->getValue('name')[0]['value']
      || empty($form_state->getValue('name')[0]['value'])
    ) {
      $response->addCommand(new MessageCommand($this->t('Enter name.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (strlen($form_state->getValue('name')[0]['value']) < 2) {
      $response->addCommand(new MessageCommand($this->t('Name is too short.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (strlen($form_state->getValue('name')[0]['value']) > 100) {
      $response->addCommand(new MessageCommand($this->t('Name is too long.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (!$form_state->getValue('email')[0]['value']
      || empty($form_state->getValue('email')[0]['value'])
    ) {
      $response->addCommand(new MessageCommand($this->t('Enter email.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (!preg_match('/^[a-z_-]+@[a-z0-9.-]+\.[a-z]{2,4}$/', $form_state->getValue('email')[0]['value'])) {
      $response->addCommand(new MessageCommand($this->t('Email not valid.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (!$form_state->getValue('mobile_number')[0]['value']
      || empty($form_state->getValue('mobile_number')[0]['value'])
    ) {
      $response->addCommand(new MessageCommand($this->t('Enter mobile number.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (strlen($form_state->getValue('mobile_number')[0]['value']) < 10 || strlen($form_state->getValue('mobile_number')[0]['value']) > 10) {
      $response->addCommand(new MessageCommand($this->t('The mobile phone must contain 10 digits.'), '#form-valid-message', ['type' => 'error']));
    }
    elseif (!preg_match('/^[0-9]{10}$/', $form_state->getValue('mobile_number')[0]['value'])) {
      $response->addCommand(new MessageCommand($this->t('Mobile number not valid.'), '#form-valid-message', ['type' => 'error']));

    }
    elseif (!$form_state->getValue('message')[0]['value']
      || empty($form_state->getValue('message')[0]['value'])
    ) {
      $response->addCommand(new MessageCommand($this->t('Enter message.'), '#form-valid-message', ['type' => 'error']));
    }
    else {
      $entity = $this->entity;
      $status = parent::save($form, $form_state);
      switch ($status) {
        case SAVED_NEW:
          $response->addCommand(new MessageCommand($this->t('Saved.'), '#form-valid-message', ['type' => 'status']));
          break;

        default:
          $response->addCommand(new MessageCommand($this->t('Saved.'), '#form-valid-message', ['type' => 'status']));
      }
    }
    return $response;
  }

}
