<?php
    
namespace Drupal\helloworld\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
    
    class MessageModal extends FormBase {
    
    public function getFormId() {
        return 'message_modal_form';
    }
    
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['description'] = array(
    '#markup' => '<div>'. t('This example shows an add-more and a remove-last button.').'</div>',
    );
    
    $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Download File'),
    ];

    $form['cancel'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Cancel'),
        '#button_type' => 'primary',
        '#submit' => array('::cancelSubmit'),
      );
    
        return $form;
    }

    public function cancelSubmit(array &$form, FormStateInterface $form_state) {
        $url = \Drupal\Core\Url::fromUserInput('/all-files');
        return $form_state->setRedirectUrl($url);
      }
    
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
    
    }
    
}