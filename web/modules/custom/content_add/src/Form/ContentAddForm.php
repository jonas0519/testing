<?php
/**
 * @file
 * Contains \Drupal\content_add\Form\ContentAddForm.
 */
namespace Drupal\content_add\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

class ContentAddForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'content_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('First Name'),
        '#required' => TRUE,
      );

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE,
    );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE,
    );

    $form['description'] = array(
        '#type' => 'textfield',
        '#title' => t('Description'),
        '#required' => TRUE,
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
  /*
    public function validateForm(array &$form, FormStateInterface $form_state) {

      if (strlen($form_state->getValue('candidate_number')) < 10) {
        $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
      }

    }

    */

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $node = Node::create(['type' => 'content_add']);
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $node->set('title',$form_state->getValue('title'));
    $node->set('field_first',$form_state->getValue('first_name'));
    $node->set('field_l',$form_state->getValue('last_name'));

    $node->save();
    drupal_set_message(t('Thank you, the form data saved on content add node table'));

   }
}