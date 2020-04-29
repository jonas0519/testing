<?php
/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstController.
 */
 
namespace Drupal\helloworld\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class HelloworldController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world'),
    );
  }
}