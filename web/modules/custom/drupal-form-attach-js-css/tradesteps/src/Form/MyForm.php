<?php
namespace Drupal\tradesteps\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Implements a simple form.
*/
class MyForm extends FormBase {

  /**
  * Build the simple form.
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    // Add input field called title.
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Title must be at least 15 characters in length.'),
      '#required' => TRUE,
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
  * The form ID is used in implementations of hook_form_alter() to allow other
  * modules to alter the render array built by this form controller.  it must
  * be unique site wide. It normally starts with the providing module's name.
  */
  public function getFormId() {
    return 'tradesteps_simple_form';
  }

  /**
  * Implements form validation.
  *
  * The validateForm method is the default method called to validate input on
  * a form.
  */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 15) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('title', $this->t('The title must be at least 15 characters long.'));
    }
  }

  /**
  * Implements a form submit handler.
  *
  * The submitForm method is the default method called for any submit elements.
  *     What to do after user click on Submit button.
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /*
    * This would normally be replaced by code that actually does something
    * with the title.
    */
    $title = $form_state->getValue('title');
    drupal_set_message($this->t('You specified a title of %title.', ['%title' => $title]));
  }

}