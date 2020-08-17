<?php
    
    namespace Drupal\helloworld\Form;
    
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Core\Form\FormBase;
    
    class FeeForm extends FormBase {

      public function getFormId() {
        return 'form_fee';
      }
    
      public function buildForm(array $form, FormStateInterface $form_state, $fid = NULL) {
        // CheckBoxes.
        $form['tests_taken'] = [
          '#type' => 'checkboxes',
          '#options' => ['SAT' => $this->t('SAT'), 'ACT' => $this->t('ACT')],
          '#title' => $this->t('What standardized tests did you take?'),
          '#description' => 'Checkboxes, #type = checkboxes',
        ];
       $txt_value = file_get_contents('/var/www/html/fortesting/web/modules/custom/helloworld/src/Form/my.txt');
       

        $form['keywords'] = array(
          '#title' 
          => t('Keywords'),
          
          '#type' => 'textarea',
          
          '#description' => t('The comment will be unpublished if it contains any of the phrases above. Use a case-sensitive, comma-separated list of phrases. Example: funny, bungee jumping, "Company, Inc."'),
          '#default_value' => $txt_value,
          //'#default_value' => isset(  $context['keywords']) ? drupal_implode_tags($context['keywords']) : '',
          );

            // Add a submit button that handles the submission of the form.
        $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit'),
          '#description' => $this->t('Submit, #type = submit'),
          '#attributes' => [
            'id' => ['but'],
          ],
        ];

                $form['#prefix'] = '<div id="my-form-wrapper">';
          $form['#suffix'] = '</div>';

          $form ['info'] =array(   
            '#markup' => "<div id='pageAbiliRequestDiv'>",    
          );  


        $form ['ContactUsMsg'] =array(
            '#prefix' => '<div id="ContactUsMsgDiv">',
            '#markup' => '',
            '#suffix' => '</div>',
          );
        $form['contact_number'] = array(
            '#prefix' => '<div class="webform-container-inline2">',
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => t('Contact Number'),
          '#size' => 20,
            '#maxlength' => 255,
          '#attributes'=>array('class'=>array('txtabili')),	
            '#required'=>true,
          );

        $form['verification_code'] = array(
            '#prefix' => '<div class="webform-container-inline2">',
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => t('Verification Code'),
          '#size' => 20,
            '#maxlength' => 255,
          '#attributes'=>array('class'=>array('txtabili')),	
            '#required'=>true,
          );

          $form['send_vcode'] = array(
            '#prefix' => '<div style="margin-top:30px;">',
            '#suffix' => '</div><br/><br/>',
            '#type' => 'submit',
            '#value' => t('Send Verification Code'),
            '#ajax' => array(
            'callback' => 'send_Verification_code_callback',
            'wrapper' => 'my-form-wrapper',	        
            'method'=>'replace',
            'effect'=>'fade',
            ),		  
          );
          
        $form['message'] = array(
          '#prefix' => '<div class="webform-container-inline2">',
            '#suffix' => '</div>',
          '#title' => t('Message'),
          '#type' => 'textarea',
            '#attributes'=>array('class'=>array('txtcontactuss')),
          '#required' => true,
          '#rows' => 10,
          );
            
          $form['sendmail'] = array(
            '#prefix' => '<div style="margin-top:30px;">',
            '#suffix' => '</div></div>',
            '#type' => 'submit',
            '#value' => t('Send Request'),
            '#ajax' => array(
            'callback' => 'get_contact_us_callback',
            'wrapper' => 'ContactUsMsgDiv',	        
            'method'=>'replace',
            'effect'=>'fade',
            ),		  
          );

          $form['clicks'] = array(
          '#type' => 'value',
        );

        return $form;
     }
    
     function send_Verification_code_callback($form, &$form_state){
      //code to send sms
      return $form; 
      }
     /**
       * AJAX Callback: Update Field Options.
       */
      public function updateFieldOptions(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse;
        $response->addCommand(new ReplaceCommand('#field-add-form--wrapper', $form));
        return $response;
      }
  
      public function submitForm(array &$form, FormStateInterface $form_state) {

    
    }
  }