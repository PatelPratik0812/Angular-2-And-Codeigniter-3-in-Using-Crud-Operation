<?php


defined('BASEPATH') or exit('No direct script access allowed');

class LoomModel extends CI_Model
{

    private $loom = 'loom';
   private $reg = 'registration';
    

    public function getRows($Status)
    {
        $this->db->select('*');
        $this->db->from($this->loom);
        if($Status == "" || $Status == "undefined")
        {
             $this->db->where('Status !=',"Delete");
        }
        else
        {
            $this->db->where('Status',$Status);
        }
     
        $this->db->order_by('CAST(loom.Code  AS UNSIGNED) ASC');
        
        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $LoomList = $query->result();
                return array('status' => 'TRUE', 'data' => $LoomList, null, 'message' => LOOM_LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $LoomList, 'message' => LOOM_LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $LoomList, 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function Insert1($loomData)
    {

        $query = $this->db->insert($this->loom, $loomData);
        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => LOOM_INSERT, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => LOOM_NOT_INSERT, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'code' => $error_array['code'], 'message' => $error_array['message']);
        }
    }

    public function Update($CrudData)
    {
        $this->db->where('reg_id', $CrudData['reg_id']);
        $this->db->update($this->registration, $CrudData);

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => LOOM_UPDATE, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => LOOM_NOT_UPDATE, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function Edit($Id)
    {
        $this->db->select('*');
        $this->db->from($this->loom);
        $this->db->where('Id', $Id);
        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $LoomList = $query->row();
                return array('status' => 'TRUE', 'data' => $LoomList, null, 'message' => LOOM_LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $LoomList, 'message' => LOOM_LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $LoomList, 'message' => $error_array['message'], $error_array['code']);
        }
    }

    public function Delete($reg_id)
    {

        $checkexisting = $this->cm->checkexisting('registration', $reg_id); // Name must be unique

        if ($checkexisting['data'] <= 0) {

            $this->db->select('*');
            $this->db->from($this->reg);
            $this->db->where('reg_id', $reg_id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data = array(
                    //'Status' => DELETESTATUS,
                    'UpdatedBy' => 1,
                    'UpdatedOn' => date('Y-m-d H:i:s'),
                );
                $this->db->where('reg_id', $reg_id);
                $this->db->update('registration', $data);

                $error_array = $this->db->error(); // If above query has some error

                if ($error_array['code'] == 0) // If 0 means query run successfully
                {
                    if ($this->db->affected_rows() > 0) {
                        return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => LOOM_DELETE, 'code' => $error_array['code']);
                    } else {
                        return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => LOOM_NOT_DELETE, 'code' => $error_array['code']);
                    }
                } else {
                    return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => $error_array['message'], 'code' => $error_array['code']);
                }
            }

        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => AllREADY_USED, 'code' => $error_array['code']);
        }
    }

    public function Newrecord($Data){
   // $this->db->insert($this->reg,$Data);
   // return array('status' => 201,'message' => 'Data has been created.');
   
        $this->username    = $Data['username'];
        $this->password  = $Data['password'];
        $this->createOn = $Data['createOn'];
       
        if($this->db->insert($this->reg,$this))
  
        {  
                return  'User has been added successfully.';    
      
        }
        
          else
  
        {
  
            return "Error has occured";
  
        }
  
    }

    public function get_Record()
    {
        $this->db->select('*');
        $this->db->from($this->reg);
        $query=$this->db->get();
        
        if ($query->num_rows() > 0) {
            return $response = $query->result();
        }
        else
        {
                return "Error Has occured";
        }
    

    }
    public function deleteRecord($reg_id){
        $this->db->where('reg_id',$reg_id);
        if($this->db->delete($this->reg)){
            return "Record Deleted";
            }else{
                return "Error In Code";
            }
    }

    public function EditRecord($reg_id){
        $this->db->select('*');
        $this->db->from($this->reg);
        $this->db->where('reg_id', $reg_id);
        $query = $this->db->get();
        if($EditList = $query->row() > 0){
            return $query->result();
        }
        else{
            return "Error Has Occured";
        }
    }

    // public function updateRecord($Data,$reg_id){
    //     $this->username    = $Data['username'];
    //     $this->password  = $Data['password'];
    //     $this->createOn = $Data['createOn'];
    //    if( $sql=$this->db->update($this->reg,$Data,$reg_id)){
    //        return "Record update SuccessFully";
    //    }
    //    else{
    //        return "Error Has occured";
    //    }
    // }


    public function InsertCrud1($CrudData){
        $query = $this->db->insert($this->reg, $CrudData);
        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => CRUD_INSERT, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => CRUD_NOT_INSERT, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'code' => $error_array['code'], 'message' => $error_array['message']);
        }
    }
    public function UpdateCrud1($CrudData){
          
        $this->db->where('reg_id', $CrudData['reg_id']);
        $this->db->update($this->reg, $CrudData);
      
        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => CRUD_UPDATE, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => CRUD_NOT_UPDATE, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

  

    

}
