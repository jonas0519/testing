<?php

namespace Drupal\drupalup_controller\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

class ArticleController {

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


  
}
