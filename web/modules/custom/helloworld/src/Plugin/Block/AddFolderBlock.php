<?php
/**
 * @file
 * Contains \Drupal\rti_gates_collaboration_tool\Plugin\Block\RTIGatesCollaborationTaxonomyMenuBlock.
 */

namespace Drupal\helloworld\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides a 'Modal' Block
 *
 * @Block(
 *   id = "modal_block",
 *   admin_label = @Translation("ADD Folder"),
 * )
 */
class AddFolderBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $link_url = Url::fromRoute('custom_modal.modal');

    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 400]),
      ],
    ]);

    //$add_folder = Url::fromRoute('entity.taxonomy_term.add_form', ['taxonomy_vocabulary' => 'all_files']);
    $add_folder = Url::fromRoute('helloworld.add_folder');

    $add_folder->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small', 'dropdown-item', 'close-menu'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 600]),
      ],
    ]);

    //$all_list_files = Url::fromRoute('rti_gates_collaboration_tool.all_list_files');

    return [
              [
                '#prefix' => '<div class="dropdown">',
              ],
                [
                  '#type' => 'markup',
                  '#markup' => '<a class="btn btn-secondary dropdown-toggle rti-dropdown-btn menu-new-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> + New </a>',
                ],

                  [
                    '#prefix' => '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">',
                  ],
              
                      [
                        '#type' => 'markup',
                        '#markup' => Link::fromTextAndUrl(t('+ Create New Folder'), $add_folder)->toString(),
                        '#attached' => ['library' => ['core/drupal.dialog.ajax']],
                      ],

                  [
                    '#suffix' => '</div>'
                  ],

                [
                  '#suffix' => '</div>'
                ],
            ];
  } 
}