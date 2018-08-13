
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
header('Access-Control-Allow-Headers', 'Content-Type');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/REST_Controller.php';

class Loom extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('LoomModel', 'lm');
        $this->load->model('CommonModel', 'cm');
        //   $this->output->set_header('application/json');
        //    $var_ = $this->input->server();
        //      $allowedDomains = unserialize(ALLOWED_DOMAIN);
        //      $domain = parse_url($var_['HTTP_REFERER']);
        //      if (!in_array($domain['host'], $allowedDomains))
        //      {
        //      echo json_encode(array('message' => "Access denied!"));
        //      exit;
        //      }
    }

    // public function getrows_get()
    // {
    //     $Status = $this->get('Status');
    //     $result = $this->lm->getRows($Status);
    //     $this->responseapi_get($result);
    // }

    public function edit_get()
    {
        $Id = $this->get('id');
        $result = $this->lm->Edit($Id);
        $this->responseapi_get($result);
    }


    public function Insertupdate_post()
    {
        $post = json_decode($_POST['data']);

        $CrudData = array();
        $CrudData['reg_id'] = $post->reg_id;
        $CrudData['username'] = $this->cm->test_input($post->username);
        $CrudData['password'] = $this->cm->test_input($post->password);
        //$loomData['Description'] = $this->cm->test_input($post->Description);
        $CrudData['Status'] = ACTIVESTATUS;

        $uniqueCheck = $this->cm->unique_check_loom('registration', $CrudData['reg_id'], $CrudData['username'], "username", $CrudData['password'], "password"); // Name must be unique

        if ($uniqueCheck['data'] <= 0) {
            if ($loomData['reg_id'] > 0) {
                //Update data
                $loomData['UpdatedBy'] = 1;
                $loomData['UpdatedOn'] = date('Y-m-d H:i:s');
                $result = $this->lm->Update($CrudData);
            } else {

                $uniqueCheckInactive = $this->cm->unique_check_loom_inactive('registration', $CrudData['reg_id'], $CrudData['username'], "username", $CrudData['password'], "password"); // Name must be unique

                if ($uniqueCheckInactive['data'] <= 0) {
                    $loomData['CreatedBy'] = 1;
                    $loomData['CreatedOn'] = date('Y-m-d H:i:s');
                    $result = $this->lm->Insert($CrudData);
                } else {
                    $CrudData = array();
                    $CrudData['reg_id'] = $uniqueCheckInactive['listdata'][0]->reg_id;
                    $CrudData['username'] = $uniqueCheckInactive['listdata'][0]->username;
                    //$loomData['Code'] = $uniqueCheckInactive['listdata'][0]->Code;
                    //$loomData['Description'] = $uniqueCheckInactive['listdata'][0]->Description;
                    $CrudData['Status'] = ACTIVESTATUS;
                    $CrudData['UpdatedBy'] = 1;
                    $CrudData['UpdatedOn'] = date('Y-m-d H:i:s');
                    $result = $this->lm->Update($CrudData);
                }

            }
            $this->responseapi_get($result);
        } else {
            $this->responseapi_get($uniqueCheck);
        }
    }

    public function delete_get()
    {
        $Id = $this->get('reg_id');
        $result = $this->lm->Delete($reg_id);
        $this->responseapi_get($result);
    }

    public function CrudAction_post()
    {
        $post = json_decode($_POST['data']);

        $result = $this->cm->CrudActionMultiple($post->Data, $post->Action, $post->Table, $post->reg_id);

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
    public function insertRecord_post(){
    
        
    //     $post = json_decode($_POST['data']);

    //     $Data = array();
    //   //  $Data=$post->reg_id;
    //     $Data['username'] = $this->cm->test_input($post->username);
    //     $Data['password'] = $this->cm->test_input($post->password);
    //     $Data['createOn'] = date('Y-m-d H:i:s');
      
    //    $result=$this->lm->Newrecord($Data['username'],"username",$Data['password'],"password",$Data['createOn'],"createOn");
    //     $this->response($result);
    $post = json_decode($_POST['data']);

        $Data = array();
      //  $Data=$post->reg_id;
        $Data['username'] = $this->cm->test_input($post->username);
        $Data['password'] = $this->cm->test_input($post->password);
        $Data['createOn'] = date('Y-m-d H:i:s');
    
       $result=$this->lm->Newrecord($Data);
     
        $this->response(["result"=>$result]);
    }
    public function getData_get()
    { 
        $record=$this->lm->get_Record();
       $this->response(["record"=>$record]);
     
    }

    public function delData_get()
    {
        
        $reg_id = $this->get('reg_id');
       $result = $this->lm->deleteRecord($reg_id);
       $this->response(["result"=>$result]);
       
       

    }

    public function EdtRecord_get()
    {
        $reg_id = $this->get('reg_id');
        $edit = $this->lm->EditRecord($reg_id);
        $this->response(["edit"=>$edit]);
    }

    // public function UpdateData_post(){
    //     $post = json_decode($_POST['data']);

    //     $Data = array();
    //   //  $Data=$post->reg_id;
    //     $Data['username'] = $this->cm->test_input($post->username);
    //     $Data['password'] = $this->cm->test_input($post->password);
    //     $Data['createOn'] = date('Y-m-d H:i:s');
    
    //    $updateData=$this->lm->updateRecord($Data,$edit);
     
    //     $this->response(["updateData"=>$updateData]);
    // }


    public function InsupdateCrud_post(){
        $post = json_decode($_POST['data']);
        
        $CrudData = array();
        $CrudData['reg_id'] = $post->reg_id;
        $CrudData['username'] = $this->cm->test_input($post->username);
        $CrudData['password'] = $this->cm->test_input($post->password);
        $CrudData['Status'] = ACTIVESTATUS;
//    print_r($CrudData);exit();
       $checkcrud = $this->cm->unique_check_loom('registration',$CrudData['reg_id'],  $CrudData['username'], "username", $CrudData['password'], "password");
        
       if ($checkcrud['data'] <= 0) {
      
        if ($CrudData['reg_id'] > 0) {
         
            $CrudData['updatedBy'] = 1;
            $CrudData['UpdatedOn'] = date('Y-m-d H:i:s');

            $result = $this->lm->UpdateCrud1($CrudData);
        } else {

            $uniqueCheckCrud = $this->cm->unique_check_loom_inactive('registration', $CrudData['reg_id'], $CrudData['username'], "username", $CrudData['password'], "password");
            if ($uniqueCheckCrud['data'] <= 0) {
                $CrudData['createdBy'] = 1;
                $CrudData['createOn'] = date('Y-m-d H:i:s');
                $result = $this->lm->InsertCrud1($CrudData);
            } else {
                $CrudData = array();
                $CrudData['reg_id'] = $uniqueCheckCrud['listdata'][0]->reg_id;
                $CrudData['username'] = $uniqueCheckCrud['listdata'][0]->username;
                $CrudData['password'] = $uniqueCheckCrud['listdata'][0]->password;
                
                $CrudData['updatedBy'] = 1;
                $loomData['UpdatedOn'] = date('Y-m-d H:i:s');
                $result = $this->lm->UpdateCrud1($CrudData);
            }
        }
        $this->responseapi_get($result);
    } else {
        $this->responseapi_get($checkcrud);
    }
    }

    public function updateStatus_post(){
        
        $post = json_decode($_POST['data']);
        $CrudData = array();
        $CrudData['reg_id'] = $post->reg_id;
        $CrudData['Status']=  $post->Status;
 
    if( $CrudData['Status']=='Active'){
        $CrudData['Status']= INACTIVESTATUS;
        //  $result = $this->lm->UpdateCrud1($CrudData);
    
    }
    else
    {
        $CrudData['Status']= ACTIVESTATUS;
        // $result = $this->lm->UpdateCrud1($CrudData);
    }
    $result = $this->lm->UpdateCrud1($CrudData);
    $this->responseapi_get($result);    
}

public function CrudActionang_post(){
    
    $post = json_decode($_POST['data']);
   
    $x=count($post->Data);
     //print_r($x);exit();
   for($i = 0 ; $i < $x ; $i++){
       
    $crudData=array();
    $crudData['reg_id']=$post->Data[$i]->reg_id;
    $CrudData['Status'] =$post->Data[$i]->Status;
     //$updateData['Action'] =$post->Action;
    
     print_r($crudData);exit();
    
    
    if($crudData['Status'] =='InActive' && $crudData['reg_id'] > 0){
      
        $crudData['Status']=ACTIVESTATUS;
       // $result = $this->lm->UpdateCrud1($updateData)
    }
    else if($crudData['Status'] =='Active' && $crudData['reg_id'] > 0){
        
        $crudData['Status']=INACTIVESTATUS;
        //$result = $this->lm->UpdateCrud1($updateData)
    }
    else{
        echo "Error";
    
   } 
 
   }
   $result = $this->lm->UpdateCrud1($crudData);
   $this->responseapi_get($result);
  
  
}
// public function AllStatus_post()
// {
//     $post= json_decode($_POST['data']);
//     $length=count($post);
//     $result;
//     for($i=0;$i<$length;$i++)
//     {
//         $userData = array();
//         $userData['Id'] = $post[$i]->Id;
//         $userData['Status'] = $this->cm->test_input($post[$i]->Status);

//         $result = $this->rm->updateRecord($userData, $Id);
//     }
//     $this->responseapi_get($result);
// }




   
}

 



?>






 
