<?php
/**
 * @file
 * Contains Drupal\helloworld\AjaxModuleForm
 */
namespace Drupal\helloworld\Form;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class AjaxModuleForm extends FormBase {
  public function getFormId() {
	return 'ajax_module_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
	$form['user_name'] = array(
  	'#type' => 'textfield',
  	'#title' => 'Username',
  	'#description' => 'Please enter in a username',
  	'#ajax' => array(
    	// Function to call when event on form element triggered.
    	'callback' => 'Drupal\helloworld\Form\AjaxModuleForm::usernameValidateCallback',
    	// Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
    	'effect' => 'fade',
    	// Javascript event to trigger Ajax. Currently for: 'onchange'.
    	'event' => 'change',
    	'progress' => array(
      	// Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
      	'type' => 'throbber',
      	// Message to show along progress graphic. Default: 'Please wait...'.
      	'message' => NULL,
    	),
  	),
	);
	
	return $form;
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state) {
	drupal_set_message('Nothing Submitted. Just an Example.');
  }
 
  public function usernameValidateCallback(array &$form, FormStateInterface $form_state) {
	// Instantiate an AjaxResponse Object to return.
	$ajax_response = new AjaxResponse();
	
	// Check if Username exists and is not Anonymous User ('').
	if (user_load_by_name($form_state->getValue('user_name')) && $form_state->getValue('user_name') != false) {
	
	$uname = $form_state->getValue('user_name');
  	$text = 'User Found';
  	$color = 'green';
	} else {
  	$text = 'No User Found';
  	$color = 'red';
	}
	
	// Add a command to execute on form, jQuery .html() replaces content between tags.
	// In this case, we replace the desription with wheter the username was found or not.
    $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $uname .$text));
	
	// Add a command, InvokeCommand, which allows for custom jQuery commands.
	// In this case, we alter the color of the description.
    $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));
	
	// Return the AjaxResponse Object.
	return $ajax_response;
  }
}