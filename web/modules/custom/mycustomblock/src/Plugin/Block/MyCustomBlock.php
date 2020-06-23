<?php
/**
 * @file
 *
 */

namespace Drupal\mycustomblock\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Creates a 'Foobar' Block
 *
 * @Block(
 * id = "block_mycustomblock",
 * admin_label = @Translation("MyCustomBlock"),
 * category = @Translation("Blocks")
 * )
 */
class MyCustomBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */

  public function build() {
    $build = [];
    // get the variable from field_test
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      $build['#attached']['library'][] = 'mycustomblock/custom'; 
      $build['#attached']['drupalSettings']['mycustomblock']['test'] = $node->field_test->value;
    }
  
    return $build;
  }
}