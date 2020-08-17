<?php

namespace Drupal\helloworld\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Provides a default form.
 */
class DefaultForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'filter_default_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Create a select field that will update the contents
    // of the textbox below.

    //DRUPAL 8
    $query = \Drupal::database()->select('node', 'n');
    $query->addField('n', 'nid');
    $query->condition('n.type', 'article');
    $results = $query->execute()->fetchAll();
    drupal_set_message('value' .print_r($results, true));

    $form['example_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => [
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('From New York to Ger-ma-ny!'),
      ],
    ];

    // Create a textbox that will be updated
    // when the user selects an item from the select box above.
    $form['output'] = [
      '#type' => 'textfield',
      '#size' => '60',
      '#disabled' => TRUE,
      '#value' => 'Hello, Drupal!!1',      
      '#prefix' => '<div id="edit-output">',
      '#suffix' => '</div>',
    ];

    $form['time_container']['time'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Time'),
      '#size' => 20,
      '#date_date_element' => 'none', // hide date element
      '#date_time_element' => 'time', // you can use text element here as well
      '#date_time_format' => 'H:i',
      '#default_value' => '00:00',
     ];

    // Create the submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

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
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addStatus($key . ': ' . $value);
    }
  }

}