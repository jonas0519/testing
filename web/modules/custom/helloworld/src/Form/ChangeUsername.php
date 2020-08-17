<?php
/**
 * @file
 * Contains \Drupal\helloworld\Form\AddAnotherItem.
 */

namespace Drupal\helloworld\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class ChangeUsername extends FormBase {

  public function getFormId() {
    return 'change_username_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['methods'] = array(
      '#type' => 'select',
      '#title' => $this->t('Method'),
      '#default_value' => "",
      '#options' => ["a"=>"A Value","b"=>"B Value",],
      '#ajax' => array(
        'callback' => '::methodChangeAjax',
        'wrapper' => 'edit-fieldsset',
        'method' => 'replace',
        'effect' => 'fade',
        'event' => 'change',
      ),
    );
  //Ajax changable fields container
    $form['fieldsset'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Fields'),
      '#default_value' => "",
      '#prefix' => '<div id="edit-fieldsset">',
      '#suffix' => '</div>',
    );

    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => 'Your user name',
      '#description' => 'User name',
      '#ajax' => array(
        'callback' => '::checkUserNameAjax',
        'wrapper' => 'edit-username',
        'method' => 'replace',
        'effect' => 'fade',
        'event' => 'change',
      ),

      //If you want to change the ID
      '#prefix' => '<div id="edit-username">',
      '#suffix' => '</div>',
    );


  $form['range'] = array(
    '#type' => 'fieldset',
    '#prefix' => '<div class="myclass">',
 );

  $form['range']['min'] = array(
     '#type' => 'textfield',
     '#title' => 'Address'
  );
  $form['range']['address2'] = array(
     '#type' => 'textfield',
     '#title' => 'Address',
     '#suffix' => '</div>',
  );

    return $form;
  }
  function methodChangeAjax($form, FormStateInterface $form_state) {
    $method = $form_state->getValue('methods');
    $form['fieldsset']['#title'] = $method;
    return $form['fieldsset'];
  }

  //1. Ajax Methode to Edit Form
  //function checkUserNameAjax($form, FormStateInterface $form_state) {
   // $form['username']['#description'] = "YES";
    //return $form['username'];
 // }

// 2. Or using AjaxResponse to change HTML/CSS

  function checkUserNameAjax(array &$form, FormStateInterface &$form_state) {
    $valid = rand(0,1);
    if ($valid) {
      $css = ['border' => '1px solid green'];
      $message = ('User name ok.');
    }else {
      $css = ['border' => '1px solid red'];
      $message = ('User name not valid.');
    }
    $response = new \Drupal\Core\Ajax\AjaxResponse();
    $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-username', $css));
    $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#edit-username--description', $message));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Final submit
  }
}