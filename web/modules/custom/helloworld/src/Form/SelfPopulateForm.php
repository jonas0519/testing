<?php

namespace Drupal\helloworld\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\taxonomy\Entity\Term;

/**
 * Class TestModalForm.
 *
 * @package Drupal\helloworld\Form
 */
class SelfPopulateForm extends FormBase {

  protected $formBuilder;
 
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'shift8module_form';
    }
   
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

            // Get values of selected dropdowns to aid in filtering and db queries
    
            $options_first = $this->get_first_dropdown_options();
    
            $form['description'] = [
              '#type' => 'item',
            ];
    
            // Product Category
            $form['dropdown_first'] = array(
                '#type' => 'select',
                '#title' => 'Industries',
                '#prefix' => '<div id="dropdown-first-replace" class="shift8-form-select">',
                '#suffix' => '</div>',
                '#options' => $options_first,
                '#attributes' => array('style' => 'display:inline-block;'),
                '#default_value' => '_none',
                '#empty_option' => t('- None -'),
                '#empty_value' => '_none',
                '#validated' => TRUE,
                '#ajax' => array(
                    'callback' => [$this, 'shift8_dependent_dropdown_callback'],
                    'event' => 'change',
                    'wrapper' => 'dropdown-second-replace',
                ),
            );
    
            // Product Sub Category
            $form['dropdown_second'] = array(
                '#type' => 'select',
                '#title' => 'Products',
                '#prefix' => '<div id="dropdown-second-replace" class="shift8-form-select">',
                '#suffix' => '</div>',
                '#options' => array(),
                '#attributes' => array('style' => 'display:inline-block;'),
                '#default_value' => '_none',
                '#empty_option' => t('- None -'),
                '#empty_value' => '_none',
                '#validated' => TRUE,
                '#ajax' => array(
                    'callback' => [$this, 'shift8_dependent_dropdown_callback_second'],
                    'event' => 'change',
                    'wrapper' => 'dropdown-third-replace',
                ),
            );
    
            // Group submit handlers in an actions element with a key of "actions" so
            // that it gets styled correctly, and so that other modules may add actions
            // to the form. This is not required, but is convention.
            $form['actions'] = [
              '#type' => 'actions',
            ];
    
            $form['reset'] = array(
                '#type' => 'button',
                '#button_type' => 'reset',
                '#value' => t('Reset'),
                '#validate' => array(),
                '#attributes' => array(
                    'onclick' => 'this.form.reset(); return false;',
                ),
                '#ajax' => array(
                    'callback' => [$this, 'shift8_reset'],
                ),
                '#prefix' => '',
                '#sufix' => '',
            );
    
            $form['message'] = [
                '#type' => 'markup',
                '#markup' => '<div class="result_message"></div>',
            ];
    
            return $form;
    
    }

    public function shift8_dependent_dropdown_callback(array &$form, FormStateInterface $form_state) {
        // This is where you will build your form options and call other functions to generate options
        $this->first_selected = $form_state->getValue('dropdown_first');

        // Get entity_id of first dropdown selection
        $query = db_select('taxonomy_term_field_data');
        $query->fields('taxonomy_term_field_data', array('tid',));
        $query->condition(db_and()
            ->condition('name', $this->first_selected, '=')
        );

        $query->range(0, 1);
        $results = $query->execute();
        $firstchoiceTID = $results->fetchField();

        // Build list of options based on first selection
        $query_2 = db_select('taxonomy_term__parent');
        $query_2->fields('taxonomy_term__parent', array('entity_id',));
        $query_2->condition(db_and()
            ->condition('bundle', 'shift8_products', '=')
            ->condition('parent_target_id', $firstchoiceTID, '=')
        );

        $results_2 = $query_2->execute();
        $result_ids = array();

        foreach ($results_2 as $result) {
            $result_ids[] = $result->entity_id;
        }

        $entities = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($result_ids);

        $result_names = array();
        $result_names[] = array( '_none' => '- None -');
        $result_options = null;

        foreach ($entities as $single_entity) {
            $result_names[] = array(
                $single_entity->get('name')->getValue()[0]['value'] => $single_entity->get('name')->getValue()[0]['value']
            );
            $result_options .= '<option value="' . $single_entity->get('name')->getValue()[0]['value'] . '">' . $single_entity->get('name')->getValue()[0]['value'] . '</option>';
        }

        $result_names = call_user_func_array('array_merge', $result_names);
        $form['dropdown_second']['#options'] = $result_names;

        // Result Handling
        $response = new AjaxResponse();

        // Populate the dropdown
        $response->addCommand(new AppendCommand('#edit-dropdown-second',$result_options));

        return $response;

    }
   
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
   
    }

  }