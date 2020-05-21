<?php

/**
 * @file
 * 
 * Contains \Drupal\rti_gates_file_manager\Form\RTIGatesFileUploadForm.
 */

 namespace Drupal\rti_gates_file_manager\Form;

 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\file\Entity\File;
 use Drupal\user\Entity\User;
 use Drupal\node\Entity\Node;
 use Drupal\Core\Url;
 class RTIGatesFileUploadForm extends FormBase {

    /**
     * {@inheritdoc}
     */

     public function getFormId() {
         return 'upload_form';
     }

     /**
      * {@inheritdoc}
      */
      public function buildForm(array $form,FormStateInterface $form_state){

        $vid = 'directory';
        $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
        $term_data = array();
          foreach ($terms as $term) {
              $term_data[$term->tid] =  $term->name;
          }

        $form['upload_title'] = array(
          '#type' => 'textfield',
          '#title' => t('Title'),
          '#required' => TRUE,
        );
          
        $form['file'] = array(
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/file',
            '#title' => t('Choose File to upload'),
            '#default_value' => '',
            '#description' => t('The File to upload'),
            '#required' => true,
            '#size' => 48
        );

        $form['file_upload_directory_options'] = array (
          '#type' => 'value',
          '#value' => $term_data
        );

        $form['file_upload_directory'] = array (
          '#type' => 'select',
          '#title' => t('Select directory where you want to save your file'),
          '#description' => t('This directory is where the file will be saved'),
          '#options' => $form['file_upload_directory_options']['#value']
        );

        $form['actions']['#type'] = 'actions';
        
        $form['actions']['submit'] = array(
              '#type' => 'submit',
              '#value' => $this->t('Save'),
              '#button_type' => 'primary',
        );

        return $form;

      }

      /**
       * {@inheritdoc}
       */
      public function submitForm(array &$form, FormStateInterface $form_state) {

        $user= User::load(\Drupal::currentUser()->id());

        /* Fetch the array of the file stored temporarily in database */ 
        $title = $form_state->getValue('upload_title');
        $userFile = $form_state->getValue('file');
        $directory = $form_state->getValue('file_upload_directory');

        /* Load the object of the file by it's fid */
        $file = File::load( $userFile[0] );

        /* Set the status flag permanent of the file object */
        $file->setPermanent();
        /* Save the file in database */
        $file->save();

        $node = Node::create([
          'type' => 'download_files',
          'title' => $title,
          'field_upload_file' => [
            'target_id' => $file->id()
          ],
          'field_directory' => [
            'target_id' => $directory,
          ]
        ]);

        $node->save();

        drupal_set_message(t('Your file is uploaded!!!'));
        $form_state->setRedirectUrl(Url::fromUserInput('/'));
    
      }
 }

