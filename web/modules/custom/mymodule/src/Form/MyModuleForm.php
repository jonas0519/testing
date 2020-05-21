<?php
 /**
  * @file
  * Contains \Drupal\mymodle\Form\RSVPForm
  **/

 namespace Drupal\mymodule\Form;

 use Drupal\Core\Database\Database;
 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\Core\Session\AccountProxyInterface;

	/**
	 * Provides an MyModule create folder form.
	 */

class MyModuleForm extends FormBase {

	/**
	 * (@inheritdoc)
	 */
	public function getFormId() {
		return 'mymodule_create_folder_form';
	}

	/**
	 * (@inheritdoc)
	 */

	public function buildForm(array $form, FormStateInterface $form_state) {
		$node = \Drupal::routeMatch()-> getParameter('node');
		$nid = $node->nid->value;
		$form['textdata'] = array (
			'#title' => t('Create you folder or file'),
			'#type' => 'textfield',
			'#size' => 25,
			'#description' => t("Create you file or folder"),
			'#required' => TRUE,
		);

		$form['submit'] = array (
			'#type' => 'submit',
			'#value' => t('Submit'),
		);

    $form['createfolder'] = array (
			'#type' => 'submit',
			'#value' => t('Add Folder'),
		);

    $form['createfile'] = array (
			'#type' => 'submit',
			'#value' => t('Upload'),
		);

		$form['nid'] = array (
			'#type' => 'hidden',
			'#value' => $nid,
		);
		return $form;
	}

	/**
	 * (@inheritdoc)
	 * Validate the form
	 */

	public function validateForm(array &$form, FormStateInterface $form_state) {
		
	}

	/**
	 * (@inheritdoc)
	 */

	public function submitForm(array &$form, FormStateInterface $form_state) {
    //$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    
    $textdata = $form_state->getValue('textdata');
    //$user = \Drupal::currentUser();

    // Load the current user.
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

    // retrieve field data from that user

    $email = $user->get('mail')->value;
    $name = $user->get('name')->value;
    $uid= $user->get('uid')->value;

    /* var_dump($name);
    exit ();
    */

    $directory = "private://$name/$textdata/";
    file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
    $file = file_save_data($object->vertex_data,  $directory . 'vertex_data.txt', FILE_EXISTS_REPLACE);


		drupal_set_message(t('Folder and files created'));
	}
}
