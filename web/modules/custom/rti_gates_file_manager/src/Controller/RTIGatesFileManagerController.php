<?php

namespace Drupal\rti_gates_file_manager\Controller;

use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;

/**
 * Class RTIGatesFileManagerController.
 */
class RTIGatesFileManagerController extends ControllerBase {

    public function report() {
        $content = array();
        $content['message'] = array (
            '#markup' => $this->t('This is list of files that users uploaded')
        );
        $headers = array(
            t('Name'),
            t('Project'),
            t('Owner'),
            t('Last Modified'),
            t('File Size')
        );
        $rows = array(
            'r1' => array(
                        'Name' => 'office_plan_365.pdf',
                        'Project' => 'Carlson Limited',
                        'Owner' => 'me',
                        'Last Modified' => '15 Dec 2019',
                        'File Size' => '78 KB'
            ),
            
        );
        $content['table'] = array(
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $rows,
            '#empty' => t('No entries available.')
        );
        $content['#cache']['max-age']=0;
        return $content;
    }

    public function getDirectories() {

        $response = array();

        $response[directories] = array(
            t('Team1'),
            t('Team2'),
            t('Team3'),
            t('Team4')
        );

       return  $response;
    }

    public function getEvent(Request $request) {
        
        $markup = "this is test";
        $output = "<div id='ajax-target'>$markup</div>";
        return ['#markup' => $output];

    }

    public function upload(Request $request) {
    //     $options = [
    //         'dialogClass' => 'popup-dialog-class',
    //         'width' => '50%',
    //     ];

    //     $form = \Drupal::formBuilder()->getForm(\Drupal\rti_gates_file_manager\Form\RTIGatesFileUploadForm::class);

    //     $response = new AjaxResponse();

    //      // Add an AJAX command to open a modal dialog with the form as the content.
    //     $response->addCommand(new OpenModalDialogCommand(t('Upload Files'), $form, $options));
    //    # $response->addCommand(new OpenModalDialogCommand)

    //    return $response;
    

    $uploadedFile = $request->files->get('file');
    $uploadedFilePath = $uploadedFile->getPathname();
    $uploadedFileName = $uploadedFile->getClientOriginalName();
    $fileData = file_get_contents($uploadedFilePath);

    $directory = 'public://';

    if(file_prepare_directory($directory,FILE_CREATE_DIRECTORY)){
        $savedFile = file_save_data($fileData,$directory . '/' . $uploadedFileName,FILE_EXISTS_RENAME);
    } else{
        return new JsonResponse([
            'success' => FALSE,
          ]);
    }

    $node = Node::create([
        'type' => 'download_files',
        'title' => $uploadedFileName,
        'field_upload_file' => [
          'target_id' => $savedFile->id(),
        ]
    ]);

    $node->save();

    return new JsonResponse([
        'success' => TRUE,
      ]);

    }


}