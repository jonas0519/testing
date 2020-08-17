<?php
 
// Note: The namespace path doesn't contain 'src' because
//  by default, Drupal will fetch all source code files from 'src' directory.
namespace Drupal\tradesteps\Controller;
 
class MyPage {
  public function getContent() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world'),
    );
  }
}
