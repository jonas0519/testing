<?php
namespace Drupal\helloworld\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Datetime;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\user\Entity\User;
 
class FormEventCalendarUpdate extends FormBase {
 
    public function getFormId() {
        return 'tradesteps_form_event_calendar';
    }
 
    public function buildForm(array $form, FormStateInterface $form_state) {
 

        //---------------------------------------------------------
        $nid = 130;
        $node = Node::load($nid);
        // or
        $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

        if ($node) {
        $title = $node->getTitle();
        $event_types = $node->get('field_event_types')->value;
        $location = $node->get('field_location')->value; 
        $description = $node->get('body')->value;

        $date_time = strtotime($node->get('field_date_time')->value);
        $year = date('Y', $date_time);
        $month = date('m', $date_time);
        $day = date('d', $date_time);
        $hour = date('H', $date_time);
        $minute = date('i', $date_time);
        //echo $year . $month . $day . $hour . $minute;
        $node_id = $node->id(); // returns node's id.
        $to = $node->get('field_to')->value;

        $guests = $node->get('field_add_guestss'); //get list of users
        $event_guests = array();
        if(!$form_state->get('user_added')){
            foreach ($guests as $key => $guest) {
            $user = User::load($guest->getValue()['target_id']);
            $event_guests[] = $user->getUsername();
            }
            $form_state->set('event_guests', $event_guests);
        } 
        $event_guests = $form_state->get('event_guests');
        }

        //----------------------------------------------------------


        // Get the number of rows, default to 2 rows.
       $num_of_rows = $form_state->get('num_of_rows');
        if (empty($num_of_rows)){
            $num_of_rows=1;
            $form_state->set('num_of_rows', $num_of_rows);
        } 
 
        // Add the headers.
        $form['contacts'] = array(
                                    '#type' => 'table',
                                    '#title' => 'Sample Table',
                                    '#header' => array('Name', 'Phone'),
                                );
 
        // Create rows according to $num_of_rows.
        for ($i=1; $i<=$num_of_rows; $i++) {
            $form['contacts'][$i]['name'] = array(
                                                '#type' => 'textfield',
                                                '#title' => t('Name'),
                                                '#title_display' => 'invisible',
                                                '#value' => $i,
                                            );
 
            $form['contacts'][$i]['phone'] = array(
                                                '#type' => 'textfield',
                                                '#title' => t('Phone'),
                                                '#title_display' => 'invisible',
                                                '#value' => $i
                                            );

                                            
        }


        // 'Add row' button.
        $form['actions']['add_row'] = [
                                        '#type' => 'submit',
                                        '#value' => $this->t('Add row'),
                                        '#submit' => array('::addRowCallback'),
                                    ];
 
        // Submit button.
        $form['actions']['submit'] = [
                                        '#type' => 'submit',
                                        '#value' => $this->t('Submit'),
                                    ];

        $form['event_type'] = array(
            '#type' => 'textfield',
            '#title' => t('Event Type'),
            '#size' => '35',
            '#value' => $event_types,
            );

        $month_option = array
        ( '1' => 'Jan', 
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr', 
        );

        $form['event_month'] = array(
            '#type' => 'select',
            '#options' => $month_option,
            '#default_value' => array_search($month, $month_option),
        );

        return $form;
    }
 
    public function addRowCallback(array &$form, FormStateInterface $form_state) {
 
        // Increase by 1 the number of rows.
        $num_of_rows = $form_state->get('num_of_rows');
        $num_of_rows++;
        $form_state->set('num_of_rows', $num_of_rows);
 
        // Rebuild form with 1 extra row.
        $form_state->setRebuild();
    }
 
 
 

    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Find out what was submitted.
        $values = $form_state->getValues();
        drupal_set_message(print_r($values['contacts'],true));
    }
 
}