<?php
/**
 * @file
 * Contains \Drupal\helloworld\Form\EditFileForm.
 */
namespace Drupal\helloworld\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\helloworld\ExtendPhpWord;



class EditFileForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'h_edit_file_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#cache'] = false;
    $parameteres = \Drupal::routeMatch()->getParameters();
    $fid = $parameteres->get('fid');
    $file = File::load($fid);
    $file_link = $file->getFileUri();
    
    if($file->getMimeType() == 'text/plain') {
      $file_content_value = file_get_contents($file_link);
    }
    elseif ($file->getMimeType() == 'application/msword' || $file->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {

      $word_writer = \Drupal::service('rti_phpword.writer');
      $word_reader = \Drupal::service('rti_phpword.doc_reader');
      $html_reader = \Drupal::service('rti_phpword.html_reader'); // returns a PHPword object
      $html_writer = \Drupal::service('rti_phpword.html_writer');  // pass phpword object

      //$html_value = $html_reader->load('/var/www/html/fortesting/web/sites/default/files/welcome.docx');
      $file_link = \Drupal::service('file_system')->realpath($file_link);
      $word_value = $word_reader->load($file_link);
      $html_content = new $html_writer($word_value);
      //$html = new HTML($htmlvalue);
      $file_content_value = $html_content->getContent(); //Get html content from html reader object
      $file_content_value = $html_content->getWriterPart('Body')->write();
      //$html_value->save('/var/www/html/fortesting/web/sites/default/files/testOutput.docx', 'Word2007');

      //echo var_dump($xx);
    }

    //file_tye is $file->getMimeType();
    if($file){
      $file_link = $file->getFileUri();


      $form['file_id'] = [
        '#type' => 'hidden',
        '#value' => $fid,
      ];

      $form['file_content'] = array(
        '#title' => t('File Content'),
        '#type' => 'text_format',
        '#default_value' => $file_content_value,
        '#format' => 'full_html',
        '#resizable' => TRUE,
        );

        $form['edit-mode'] = array(
        '#type' => 'submit',
        '#value' => t('Editable Mode'),
        '#attributes' => [
            'id' => ['editable-mode'],
          ],
        );

      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Save '),
        '#button_type' => 'primary',
      );
    }
    else {
      //not found message
    }

    $form['#attached']['library'][] = 'helloworld/textarea';
    return $form;
  }

 

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $fid = $form_state->getValues()['file_id'];
    $file = File::load($fid);
    
    //$php_word = \Drupal::service('rti_phpword.writer');
   // $word_writer = \Drupal::service('rti_phpword.doc_writer');
   // $word_reader = \Drupal::service('rti_phpword.doc_reader');
   // $html_reader = \Drupal::service('rti_phpword.html_reader'); // returns a PHPword object
  //  $html_writer = \Drupal::service('rti_phpword.html_writer');  // pass phpword object

    //if the file type is text
    if($file->getMimeType() == 'text/plain') {
      file_put_contents($file->getFileUri(), $form_state->getValues()['file_content']['value']);
      drupal_set_message(t('Thank you, the file is updated'));
    }
    // process a word file
    elseif ($file->getMimeType() == 'application/msword' || $file->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
      $original_location = $absolute_path = \Drupal::service('file_system')->realpath($file->getFileUri());
      $curr_html_value = $form_state->getValues()['file_content']['value'];

      $converter = new ExtendPhpWord($original_location);
      $WordOutput = $converter->processContent($curr_html_value);
      
      //$converter =  new HTML_TO_DOC();
      //$temp_file = file_unmanaged_save_data($curr_html_value); //put file on temporary place
      //$temp_file_location =  \Drupal::service('file_system')->realpath($temp_file);
     // $doc_file = $converter->createDoc($curr_html_value, $original_location);


      //$html_content = $html_reader->load($temp_file_location);
      //$word_content = new $word_writer($html_content);
      //$section = $php_word->addSection();
      //$section->addTitle('Welcome to PhpWord', 1);
      //$section->addText('Hello World! New one');     
      
     // $section->addText(strval($curr_html_value));
      $WordOutput ->save($original_location, 'Word2007');
      drupal_set_message(t('Thank you, the file is updated. Saved at'));
    }

   }

}