<?php
/**
 * @file
 * Contains \Drupal\myhookform\Controller\MyfirstController.
 **/

namespace Drupal\myhookform\Controller;

use Drupal\Core\Controller\ControllerBase;

 class MyfirstController extends ControllerBase {
 	public function content () {
 		return array(
 			'#type' => 'markup',
 			'#markup' => t('This is my menu link'),
 		);
 	}
 }