<?php

namespace Drupal\private_data\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns a private page.
 *
 * @return array
 *   A simple renderable array.
 */


class PrivateDataController extends ControllerBase {
public function privateContent() {
    $element = array(
        '#markup' => 'Private content',
    );
    return $element;
    }
}