<?php
/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstController.
 */
 
namespace Drupal\helloworld\Controller;
 
use Drupal\Core\Controller\ControllerBase;
//use PhpOffice\PhpWord\PhpWord\Writer\HTML;
/* use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response; */
 
class HelloworldController extends ControllerBase {

  public function content() {

    $writer = \Drupal::service('rti_phpword.writer');
    $word_reader = \Drupal::service('rti_phpword.doc_reader');
    $html_reader = \Drupal::service('rti_phpword.html_reader'); // returns a PHPword object
    $html_writer = \Drupal::service('rti_phpword.html_writer');  // pass phpword object

    //$html_value = $html_reader->load('/var/www/html/fortesting/web/sites/default/files/welcome.docx');
    $word_value = $word_reader->load('/var/www/html/fortesting/web/sites/default/files/welcome.docx');
    $html_content = new $html_writer($word_value);
    //$html = new HTML($htmlvalue);
    $xx = $html_content->getContent(); //Get html content from html reader object
    
    //$html_value->save('/var/www/html/fortesting/web/sites/default/files/testOutput.docx', 'Word2007');

    echo var_dump($xx);
    exit();
    // New portrait section
    $section = $writer->addSection();
    // Simple text
    $section->addTitle('Welcome to PhpWord', 1);
    $section->addText('Hello World!');
    $fontStyle = \Drupal::service('phpword.font');
    $fontStyle->setBold(true);
    $fontStyle->setName('Tahoma');
    $fontStyle->setSize(13);
    $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
    $myTextElement->setFontStyle($fontStyle);

    $writer->save('/var/www/html/fortesting/web/sites/default/files/welcome.docx', 'Word2007');
    return "Hello";

// Saving the document as HTML file...
//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
//$objWriter->save('helloWorld.html');

  }

  public function render_block () {

    $block_manager = \Drupal::service('plugin.manager.block');
    // You can hard code configuration or you load from settings.
    $config = [];
    $plugin_block = $block_manager->createInstance('system_breadcrumb_block', $config);
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
  }

}