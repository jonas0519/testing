<?php

namespace Drupal\helloworld\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Our example form class
 */
class AddFieldAjaxForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'add_field_ajax_form';
  }

  /**
   * {@inheritdoc}
   */
  /**
 * {@inheritdoc}
 */
public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#theme'] = 'sponsorship_form';
    $form['#tree'] = true; //Make the form fields a hierachical array*

    $form['#prefix'] = '<div id="sponsorship-form-wrapper">';
    $form['#suffix'] = '</div>';

    $form['sponsor'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('You (sponsor)'),
        '#prefix' => '<div class="quick-contact__form col-xs-12 col-md-6">',
        '#suffix' => '</div>',
    ];

    /** Some fields... */

    $form['sponsor']['submit'] = [
        '#type' => 'submit',
        '#value' => t('Send'),
        '#attributes' => [
            'class' => ['btn btn-full']
        ],
        '#ajax' => array(
            'wrapper' => 'sponsorship-form-wrapper',
            'callback' => '::ajaxRebuildForm',
            'effect' => 'fade',
            'progress' => array('message' => '', 'type' => 'throbber'),
        ),
    ];

    $nb_sponsee = $form_state->get('nb_sponsee');
    $form['sponsees'] = [
        '#type' => 'container',
        '#prefix' => '<div id="sponsees-fieldset-wrapper" class="quick-contact__form col-xs-12 col-md-6">',
        '#suffix' => '</div>',
    ];

    if (empty($nb_sponsee)) {
        $nb_sponsee = 1;
        $form_state->set('nb_sponsee', $nb_sponsee);
    }

    for ($i = 0; $i < $nb_sponsee; $i++) {

        $form['sponsees'][$i]['sponsee'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('Your sponsee'),
        ];

        $form['sponsees'][$i]['sponsee']['civility'] = [
            '#prefix' => '<div class="formdetails-containHead">',
            '#type' => 'select',
            '#title' => $this->t('Civility'),
            '#options' => array(1 => $this->t('Mr'), 2 => $this->t('Miss')),
            '#size' => 1,
            '#title_display' => 'invisible',
            '#attributes' => [
                'class' => ['formDetails--civility']
            ]
        ];
        $form['sponsees'][$i]['sponsee']['firstname'] = [
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $this->t('Firstname'),
            '#placeholder' => $this->t('Firstname'),
            '#maxlength' => 64,
            '#size' => 64,
            '#title_display' => 'invisible',
        ];
        $form['sponsees'][$i]['sponsee']['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#placeholder' => $this->t('Name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#title_display' => 'invisible',
        ];
        $form['sponsees'][$i]['sponsee']['phone'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Phone'),
            '#placeholder' => $this->t('Phone'),
            '#maxlength' => 64,
            '#size' => 64,
            '#title_display' => 'invisible',
        ];
        $form['sponsees'][$i]['sponsee']['e_mail'] = [
            '#type' => 'email',
            '#title' => $this->t('E-mail'),
            '#placeholder' => $this->t('E-mail'),
            '#title_display' => 'invisible',
        ];
    }
    //If less of 3 sponsee we add the button
    if ($nb_sponsee < 3) {
        $form['sponsees']['add_sponsee'] = [
            '#type' => 'submit',
            '#prefix' => '<span class="containPlus">+</span>',
            '#attributes' => [
                'class' => ['btn-add-sponsee']
            ],
            '#value' => t('Add a sponsee'),
            '#submit' => array('::addSponcee'),
            '#ajax' => [
                'callback' => '::addSponceeCallback',
                'wrapper' => 'sponsees-fieldset-wrapper',
            ],
        ];
    }

    return $form;
}

/**
 * {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
}

/**
 * {@inheritdoc}
 */

public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->set('nb_sponsee', 1);
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }
}
/**
 * Ajax submit handler that will return the whole form structure.
 *  = callback of the complete submit of the form
 *
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 *
 * @return array
 *   The form structure.
 */
public function ajaxRebuildForm(array &$form, FormStateInterface $form_state) {
    return $form;
}

/**
 * Callback for both ajax-enabled buttons.
 *
 * Selects and returns the fieldset with the names in it.
 */
public function addSponceeCallback(array &$form, FormStateInterface $form_state) {
    return $form['sponsees'];
}

/**
 * Submit handler for the "add-one-more" button.
 *
 * Increments the max counter and causes a rebuild.
 */
public function addSponcee(array &$form, FormStateInterface $form_state) {
    $form_state->set('nb_sponsee', $form_state->get('nb_sponsee') + 1);
    $form_state->setRebuild();
}
}