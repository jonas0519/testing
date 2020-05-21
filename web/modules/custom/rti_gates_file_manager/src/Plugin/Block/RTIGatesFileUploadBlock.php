<?php

namespace Drupal\rti_gates_file_manager\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides 'New' file upload Block.
 * 
 * @Block(
 *    id = "rti_gates_file_upload_block",
 *    admin_label = @Translation("Upload File block"),
 *    category = @Translation("Upload File block"),
 * )
 */
class RTIGatesFileUploadBlock extends BlockBase implements BlockPluginInterface {

    // /**
    //  * {@ inheritdoc}
    //  */
    // public function build(){

    //     $form = \Drupal::formBuilder()->getForm('Drupal\rti_gates_file_manager\Form\RTIGatesFileUploadForm');

    //     return [
    //         '#theme' => "file_submit_th",
    //         '#submit_field' => $form
    //     ];
    // }
    /**
     * {@inheritdoc}
     */
    public function build(){

        // $link_url = Url::fromRoute('rti_gates_file_manager.upload');
        // $link_url->setOptions([
        //     'attributes' => [
        //         'class' => ['use-ajax','button','button--small'],
        //         'data-dialog-type' => 'modal',
        //         'data-dialog-options' => Json::encode(['width' => 400]),
        //     ]
        // ]);

        return array(
            '#theme' => "file_submit_th",
            '#attached' => ['library' => ['rti_gates_file_manager/rti_gates_file_manager']]
        );
    }



}