<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
//require APPPATH . '/libraries/REST_Controller.php';

class Insert extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('LoomModel');
    }
    public function insertRecord_post(){
      
        $data = array('username' => $this->input->post('username'),
        'password' =>$this->input->post('password'));
        // $country=$this->input->post('country');
        // $email=$this->input->post('email');
       
        // $create=$this->input->post('CreatedOn');// = date('Y-m-d H:i:s');
      //  $data=array("username"=>$uname,"password"=>$pass);
        $result=$this->LoomModel->newRecord($data);
        $this->response($result);
       

        
    }
}

?>