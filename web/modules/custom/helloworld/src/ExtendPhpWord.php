<?php 

namespace Drupal\helloworld;

use Drupal\Component\Utility\HTML;

/**
 * A calss to extend php Word functionality. 
 */
class ExtendPhpWord {
    
    // A PHP word object.
    public $phpword;

    //Font style 
    public $fontStyle;

    public $filLocation;

    public $section;

    /**
     * Create new instance
     */
    public function __construct($fileLocation)
    {
        $this->phpword = \Drupal::service('rti_phpword.writer');
        $this->fontStyle = \Drupal::service('rti_phpword.font');
        $this->section = $this->phpword->addSection();
        $this->fileLocation = $fileLocation;
    }

    public function processContent($content) {
        $content = $this->makeBold($content);

        // breakdown of the elements. 
        $dom = HTML::load($content);

        $paragraphs = $dom->getElementsByTagName('p');
        
        //Complete paragraphs 
        // get style attribute
        foreach ($paragraphs as $paragraph) {
            $paragraph_style = $paragraph->getAttribute('style');
            $span_style = '';
            //$span_style = $paragraph->getElementsByTagName('span')->getAttribute('style');
            //$bold = $paragraph->getElementsByTagName('strong') != NULL ? TRUE : FALSE;
            $this->addSection($paragraph, $paragraph_style, $span_style);
        }
        return $this->phpword;

    }

    public function setBold($content) {

    }

    public function addSection($content = NULL, $paragraph_style = NULL, $span_style = NULL) {
        
        $outputText = $this->section->addText($content->nodeValue);
        // style a section here 
        // check if Bolad is true
        if(strstr($paragraph_style, 'font-weight: bold')) {
            $this->fontStyle->setBold(true);
            $outputText->setFontStyle($this->fontStyle);
        }

        
        return TRUE;

    }
    public function saveContent()
    {

    }
    public function makeBold($content) {
       // Make sure to capture bold elents in the entire html content by creating an ID     
       $content = str_replace('"><span style="font-weight: bold;">','font-weight: bold;">',$content); // word bold 
       $content = str_replace('</span>','',$content);
       $content = str_replace('<span>','',$content);
       $content = str_replace('"><strong>', 'font-weight: bold;">', $content);
       $content = str_replace('</strong>','',$content);
       $content = str_replace('<strong>','',$content);
       return $content;
    }

} 