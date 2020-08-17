<?php

namespace Drupal\ajax_form_submit\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Implementing a ajax form.
 */
class AjaxSubmitDemo extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_submit_demo';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['cat_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cat name'),
    ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Log cat!'),
      '#ajax' => [
        'callback' => '::logSomething',
      ],
    ];

    $form['#attached']['library'][] = 'ajax_form_submit/loggy';

    return $form;
  }

  /**
   * Setting the message in our form.
   */
  public function logSomething(array $form, FormStateInterface $form_state) {

    $response = new AjaxResponse();
    $response->addCommand(
      new InvokeCommand(NULL, 'loggy', [$form_state->getValue('cat_name')])
    );
    return $response;
  }

  /**
   * Submitting the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
