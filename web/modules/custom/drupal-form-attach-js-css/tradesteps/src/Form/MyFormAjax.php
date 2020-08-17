<?php
namespace Drupal\tradesteps\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

// Use for Ajax.
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class MyFormAjax extends FormBase {

    /**
    * Build the simple form.
    */
    public function buildForm(array $form, FormStateInterface $form_state) {

        //$form['#attached']['library'][] = 'drupal-form-attach-js-css/trade-steps';

        // Add input field called title.
        $form['title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#description' => $this->t('Title must be at least 15 characters in length.'),
            '#required' => TRUE,
        ];

        // Attach Ajax callback to the Submit button.
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#ajax' => [
                'callback' => '::setMessage',
            ],
        ];

        // Placeholder to put the result of Ajax call, setMessage().
        $form['message'] = [
            '#type' => 'markup',
            '#markup' => '<div class="result_message"></div>',
        ];

        // Add your asset library here.
        $form['#attached']['library'][] = 'tradesteps/trade-steps';

        return $form;
    }

    public function setMessage(array $form, FormStateInterface $form_state) {

        $response = new AjaxResponse();
        $response->addCommand(
            new HtmlCommand(
                '.result_message',
                '<div class="my_message">Submitted title is ' . $form_state->getValue('title') . '</div>')
            );
        return $response;
    }



    /**
    * Implements a form submit handler.
    */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Nothing to do. Use Ajax.
    }

    public function getFormId() {
        return 'tradesteps_simple_form_ajax';
    }

}