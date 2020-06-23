<?php

namespace Drupal\drupalup_controller\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Block\BlockBase;
use Drupal\block\Entity\Block;
use Drupal\hierarchical_taxonomy_menu\Plugin\Block\HierarchicalTaxonomyMenuBlock;

class ArticleController {

  public function content() {
    $block = \Drupal\block\Entity\Block::load('hierarchicaltaxonomymenu');
    $block_content = \Drupal::entityManager()
      ->getViewBuilder('block')
      ->view($block);

          return array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array("Myclass"),
        ),
        "element-content" => $block_content,
        '#weight' => 0,
      );
  }

  public function page() {

    $items = array(
      array('name' => 'Article one'),
      array('name' => 'Article two'),
      array('name' => 'Article three'),
      array('name' => 'Article four'),
    );

    return array(
      '#theme' => 'article_list',
      '#items' => $items,
      '#title' => 'Our article list'
    );
  }


  public function links()
  {
    // Link to /admin/structure/blocks.
    $url1 = Url::fromRoute('block.admin_display');
    $link1 = Link::fromTextAndUrl(t('Go to the Block administration page'), $url1);
    $list[] = $link1;

    // Link to /admin/content.
    $url2 = Url::fromRoute('system.admin_content');
    $link2 = Link::fromTextAndUrl(t('Go to the Content administration page'), $url2);
    $list[] = $link2;

    // Link to /admin/people.
    $url3 = Url::fromRoute('entity.user.collection');
    $link3 = Link::fromTextAndUrl(t('Go to the Users page'), $url3);
    $list[] = $link3;

    // Link to Home page.
    $url4 = Url::fromRoute('<front>');
    $link4 = Link::fromTextAndUrl(t('Go to the front page'), $url4);
    $list[] = $link4;

    // Link to the node with id = 1.
    $url5 = Url::fromRoute('entity.node.canonical', ['node' => 1]);
    $link5 = Link::fromTextAndUrl(t('Go to node with id = 1'), $url5);
    $list[] = $link5;

    // Link to the edit mode of the node with id = 1.
    $url6 = Url::fromRoute('entity.node.edit_form', ['node' => 1]);
    $link6 = Link::fromTextAndUrl(t('Go to the edit mode'), $url6);
    $list[] = $link6;

    // External Link to Drupal.org.
    $url7 = Url::fromUri('https://drupal.org.com');
     
    // We'll add some HTML attributes to the link. 
    $link_options = [
      'attributes' => [
        'target' => '_blank',
        'title' => 'Link to Drupal home page',
      ],
    ];
    $url7->setOptions($link_options);
    $link7 = Link::fromTextAndUrl(t('Go to Drupal.org site'), $url7);
    $list[] = $link7;

    // Mount the render output.
    $output['links_example'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => 'Examples of links:',
    ];
    return $output;
  }

  public function render_block () {

/*
// Get blocks definition

     //$config = \Drupal::config('block.block.hierarchicaltaxonomymenu'));
     //$taxMenu = new HierarchicalTaxonomyMenuBlock($config, 'hierarchical_taxonomy_menu', 'menu');
      //return $taxMenu->build();
      $block_manager = \Drupal::service('plugin.manager.block');
        // You can hard code configuration or you load from settings.
        $config = [];

        $plugin_block = $block_manager->createInstance('hierarchical_taxonomy_menu', $config);

        // Some blocks might implement access check.
        $access_result = $plugin_block->access(\Drupal::currentUser());
        // Return empty render array if user doesn't have access.
        // $access_result can be boolean or an AccessResult class
        if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
          // You might need to add some cache tags/contexts.
          return [];
        }
        $render = $plugin_block->build();
        // In some cases, you need to add the cache tags/context depending on
        // the block implemention. As it's possible to add the cache tags and
        // contexts in the render method and in ::getCacheTags and 
        // ::getCacheContexts methods.
        return $render;
*/

      $bid = '3'; // Get the block id through config, SQL or some other means
      $block = \Drupal\block_content\Entity\BlockContent::load($bid);
      $render = \Drupal::entityTypeManager()->getViewBuilder('block_content')->view($block);
      return $render;
      
  }

  
}
