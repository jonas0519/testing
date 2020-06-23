<?php

namespace Drupal\helloworld\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Our example form class
 */
class HelloWorldForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'helloworld_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

      // Initialize the counter if it hasn't been set.
      if (!isset($form_state['fields'])) {
        // Nested this deep to avoid conflicts with other modules
        $form_state['fields'] = array(
          'helloworld' => array(
            'foo' => array(
              'items_count' => 1
            )
          )
        );
      }

      $max = $form_state['fields']['helloworld']['foo']['items_count'];
      $form['foo'] = array(
        '#tree' => TRUE,
        '#prefix' => '<div id="foo-replace">',
        '#suffix' => '</div>'
      );
      // Add elements that don't already exist
      for ($delta = 0; $delta < $max; $delta++) {
        if (!isset($form['foo'][$delta])) {
          $element = array(
            '#type' => 'textfield'
          );
          $form['foo'][$delta] = $element;
        }
      }
      $form['add'] = array(
        '#type' => 'submit',
        '#name' => 'add',
        '#value' => t('Add'),
        '#submit' => array(array($this, 'addMoreSubmit')),
        '#ajax' => array(
          'callback' => array($this, 'addMoreCallback'),
          'wrapper' => 'foo-replace',
          'effect' => 'fade',
        ),
      );
      return $form;
    }
    public function addMoreSubmit(array &$form, FormStateInterface $form_state) {
      $form_state['fields']['helloworld']['foo']['items_count']++;
      $form_state['rebuild'] = TRUE;
    }
    public function addMoreCallback(array &$form, FormStateInterface $form_state) {
      return $form['foo'];
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      drupal_set_message('Nothing Submitted. Just an Example.');
    }
  }