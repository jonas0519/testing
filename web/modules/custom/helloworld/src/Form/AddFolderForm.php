<?php
/**
 * @file
 * Contains \Drupal\helloworld\Form\AddFolderForm.
 */
namespace Drupal\helloworld\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;

class AddFolderForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rti_add_folder_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $vid = 'directory';
    $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
    $term_data = array();
     foreach ($terms as $term) {
         $term_data[$term->tid] =  $term->name;
        }

    $form['term_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Folder Name'),
      '#required' => TRUE,
    );
    $form['directory'] = array(
        '#type' => 'value',
        '#value' => $term_data
    );
    $form['dt'] = array(
        '#title' => t('Select Your Parent'),
        '#type' => 'select',
        '#id' => 'parentSelect',
        '#options' => $form['directory']['#value'],
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );

    $form['actions']['addfolder'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Add Folder'),
        '#button_type' => 'primary',
      );

    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $term_name = $form_state->getValue('term_name');
    $dt = $form_state->getValue('dt');
              // Create the taxonomy term.
              $new_term = Term::create([
                'vid' => "all_files",
                'name' => $term_name,
                "parent" => array($dt)
            ]);
            $new_term->save();
            drupal_set_message(t('Thank you, the folder is created'));
            $url = \Drupal\Core\Url::fromUserInput('/taxonomy/term/'.$new_term->id());
            return $form_state->setRedirectUrl($url);
   }
}