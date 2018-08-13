
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
header('Access-Control-Allow-Headers', 'Content-Type');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/REST_Controller.php';

class Code extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('CodeModel', 'lm');
        $this->load->model('CommonModel', 'cm');

    }

    public function getrows_get()
    {
        $Status = $this->get('Status');
        $result = $this->lm->getRows($Status);
        $this->responseapi_get($result);
    }

    public function edit_get()
    {
        $Id = $this->get('id');
        $result = $this->lm->Edit($Id);
        $this->responseapi_get($result);
    }

    public function Insertupdate_post()
    {
        $post = json_decode($_POST['data']);

        $codeData = array();
        $codeData['Id'] = $post->Id;
        $codeData['Type'] = $this->cm->test_input($post->Type);
        $codeData['Name'] = $this->cm->test_input($post->Name);
        $codeData['Description'] = $this->cm->test_input($post->Description);
        $codeData['ParentId'] = $post->ParentId;
        $codeData['Status'] = ACTIVESTATUS;

        $uniqueCheck = $this->cm->unique_check_codemaster('codemaster', $codeData['Id'], $codeData['Name'], "Name"); // Name must be unique

        if ($uniqueCheck['data'] <= 0) {
            if ($codeData['Id'] > 0) {
                //Update data
                $codeData['UpdatedBy'] = 1;
                $codeData['UpdatedOn'] = date('Y-m-d H:i:s');
                $result = $this->lm->Update($codeData);
            } else {

                $uniqueCheckInactive = $this->cm->unique_check_code_inactive('codemaster', $codeData['Id'], $codeData['Name'], "Name"); // Name must be unique

                if ($uniqueCheckInactive['data'] <= 0) {
                    $codeData['CreatedBy'] = 1;
                    $codeData['CreatedOn'] = date('Y-m-d H:i:s');
                    $result = $this->lm->Insert($codeData);
                } else {
                    $codeData = array();
                    $codeData['Id'] = $uniqueCheckInactive['listdata'][0]->Id;
                    $codeData['Type'] = $uniqueCheckInactive['listdata'][0]->Type;
                    $codeData['Name'] = $uniqueCheckInactive['listdata'][0]->Name;
                    $codeData['Description'] = $uniqueCheckInactive['listdata'][0]->Description;
                    $codeData['ParentId'] = $uniqueCheckInactive['listdata'][0]->ParentId;
                    $codeData['Status'] = ACTIVESTATUS;
                    $codeData['UpdatedBy'] = 1;
                    $codeData['UpdatedOn'] = date('Y-m-d H:i:s');
                    $result = $this->lm->Update($codeData);
                }

            }
            $this->responseapi_get($result);
        } else {
            $this->responseapi_get($uniqueCheck);
        }
    }

    public function delete_get()
    {
        $Id = $this->get('id');
        $result = $this->lm->Delete($Id);
        $this->responseapi_get($result);
    }

    public function CrudAction_post()
    {
        $post = json_decode($_POST['data']);

        $result = $this->cm->CrudActionMultiple($post->Data, $post->Action, $post->Table, $post->Check, $post->CheckId, $post->Name);

        $this->responseapi_get($result);
    }

    /************************** Response ********************************* */

    //public function responseapi_get($status, $data, $msg = NULL, $code= null)
    public function responseapi_get($result)
    {
        if ($result['status'] == true) {
            $this->response([
                'status' => $result['status'],
                'data' => $result['data'],
                'message' => $result['message'],
                'code' => $result['code'],
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => $result['status'],
                'data' => $result['data'],
                'message' => $result['message'],
                'code' => $result['code'],
            ], REST_Controller::HTTP_BAD_REQUEST); // HTTP_NOT_FOUND (404) being the HTTP response code
        }
    }
}

?>
