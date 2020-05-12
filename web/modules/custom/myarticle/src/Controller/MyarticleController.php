<?php
/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstController.
 */

namespace Drupal\myarticle\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;

class MyarticleController extends ControllerBase {
  public function content() {

  $content = [];

  $content[] = [
      '#type' => 'markup',
      '#title' => 'Selamta Page',
    ];

  $nid = \Drupal::request()->query->get('nid');
   if (!$nid)
   {
   	    return array(
      '#title' => 'page not found',
      '#markup' => t('The request nod id is not found'),
    );

   }

  	$node = \Drupal::entityManager()->getStorage('node')->load($nid); // random NID
  	   if (!$node)
   {
   	    return array(
      '#title' => 'page not found',
      '#markup' => t('The request nod id is not found'),
    );

   }

	$field_output = $node->get('title')->value;
	$field_created = $node->get('created')->value; 
	$field_body = $node->get('body')->value; 

	//echo var_dump($field_output);
	//exit();

	// requested by /?nid=12

    $content[] = [
      	'#title' => 'Selamta Page',
      	'#markup' => t($field_output),
    ];

    $content[] = [
      	'#title' => 'Selamta Page',
      	'#markup' => t($field_created),

    ];

    $content[] = [
      	'#title' => 'Selamta Page',
      	'#markup' => t($field_body),

    ];


    


    /*return array(
      '#title' => 'Selamta Page',
      '#markup' => t($field_output),
      '#markup' => t($field_created),
    );*/

    return $content;
  }
}



   