<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CodeModel extends CI_Model
{

    private $code = 'codemaster';

    public function getRows($Status)
    {
        $this->db->select('*');
        $this->db->from($this->code);
        if ($Status == "" || $Status == "undefined") {
            $this->db->where('Status !=', "Delete");
        } else {
            $this->db->where('Status', $Status);
        }

        $this->db->order_by('CAST(codemaster.Type  AS UNSIGNED) ASC');

        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $CodeList = $query->result();
                return array('status' => 'TRUE', 'data' => $CodeList, null, 'message' => CODE_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $CodeList, 'message' => CODE_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $CodeList, 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function Insert($codeData)
    {

        $query = $this->db->insert($this->code, $codeData);
        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => CODE_INSERT, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => CODE_NOT_INSERT, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'code' => $error_array['code'], 'message' => $error_array['message']);
        }
    }

    public function Update($codeData)
    {
        $this->db->where('Id', $codeData['Id']);
        $this->db->update($this->code, $codeData);

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($this->db->affected_rows() > 0) {
                return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => CODE_UPDATE, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => CODE_NOT_UPDATE, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function Edit($Id)
    {
        $this->db->select('*');
        $this->db->from($this->code);
        $this->db->where('Id', $Id);
        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $CodeList = $query->row();
                return array('status' => 'TRUE', 'data' => $CodeList, null, 'message' => CODE_LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $CodeList, 'message' => CODE_LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $CodeList, 'message' => $error_array['message'], $error_array['code']);
        }
    }

    public function Delete($Id)
    {
        //$checkexisting = $this->cm->checkexistingcodesame('codemaster', $Id, "Type");

        $checkexisting = $this->cm->checkexistingcode('loomdaily', $Id, "Status","Remark"); // Name must be unique

        if ($checkexisting['data'] <= 0) {

            $this->db->select('*');
            $this->db->from($this->code);
            $this->db->where('Id', $Id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data = array(
                    'Status' => DELETESTATUS,
                    'UpdatedBy' => 1,
                    'UpdatedOn' => date('Y-m-d H:i:s'),
                );
                $this->db->where('Id', $Id);
                $this->db->update('codemaster', $data);

                $error_array = $this->db->error(); // If above query has some error

                if ($error_array['code'] == 0) // If 0 means query run successfully
                {
                    if ($this->db->affected_rows() > 0) {
                        return array('status' => 'TRUE', 'data' => 'TRUE', 'message' => CODE_DELETE, 'code' => $error_array['code']);
                    } else {
                        return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => CODE_NOT_DELETE, 'code' => $error_array['code']);
                    }
                } else {
                    return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => $error_array['message'], 'code' => $error_array['code']);
                }
            }

        } else {
            return array('status' => 'FALSE', 'data' => 'FALSE', 'message' => AllREADY_USED, 'code' => $error_array['code']);
        }
    }

}
