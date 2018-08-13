<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CommonModel extends CI_Model
{

    private $common = 'common';
    private $codemaster = 'codemaster';
    private $employeemaster = "employeemaster";

    public function test_input($field)
    {
        $field = trim(stripcslashes(htmlspecialchars($field)));
        return $field;
    }   

    public function getEmployee()
    {
        $this->db->select('*,CONCAT(FirstName," " ,IFNULL(LastName, "")) as FullName,CONCAT(FirstName," " ,IFNULL(LastName, "")," - " ,IFNULL(Code, "")) as FullNameCode');
        $this->db->from($this->employeemaster);
        $this->db->where('Status', "Active");
        $this->db->order_by('employeemaster.FirstName', 'ASC');

        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $List = $query->result();
                return array('status' => 'TRUE', 'data' => $List, null, 'message' => LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $List, 'message' => LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $List, 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }
    public function getStatus($Type)
    {

        $this->db->select('codemaster.Id,codemaster.Name');
        $this->db->from($this->codemaster);
        $this->db->where('Status', ACTIVESTATUS);
        $this->db->where('Type', $Type);
        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $List = $query->result();
                return array('status' => 'TRUE', 'data' => $List, null, 'message' => LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $List, 'message' => LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $List, 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function getRemark($Type)
    {

        $this->db->select('codemaster.Id,codemaster.Name');
        $this->db->from($this->codemaster);
        $this->db->where('Status', ACTIVESTATUS);
        $this->db->where('Type', $Type);
        $query = $this->db->get();

        $error_array = $this->db->error(); // If above query has some error

        if ($error_array['code'] == 0) // If 0 means query run successfully
        {
            if ($query->num_rows() > 0) {
                $List = $query->result();
                return array('status' => 'TRUE', 'data' => $List, null, 'message' => LIST_FOUND, 'code' => $error_array['code']);
            } else {
                return array('status' => 'FALSE', 'data' => $List, 'message' => LIST_NOT_FOUND, 'code' => $error_array['code']);
            }
        } else {
            return array('status' => 'FALSE', 'data' => $List, 'message' => $error_array['message'], 'code' => $error_array['code']);
        }
    }

    public function unique_check($TableName, $Id, $Name, $RowName)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where($RowName, $Name);
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where($RowName, $Name)
                ->where('Id !=', $Id);
            $query = $this->db->get();

        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND);
        }
    }

    public function unique_checkQuality($TableName, $Id, $Name, $MessId)
    {

        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where('Name', $Name)
                ->where('MessId', $MessId);
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where('Name', $Name)
                ->where('Id !=', $Id)
                ->where('MessId', $MessId);
            $query = $this->db->get();
        }

        //echo $query;

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND);
        }
    }

    public function unique_check_loomdaily($TableName, $Id, $Date, $RowName1, $Loom, $RowName2, $Shift, $RowName)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Date(' . $RowName1 . ')', $Date)
                ->where($RowName2, $Loom)
                ->where($RowName, $Shift)
                ->where('Status !=', 0);
            $query = $this->db->get();
        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where($RowName, $Shift)
                ->where('Date(' . $RowName1 . ')', $Date)
                ->where($RowName2, $Loom)
                ->where('Id !=', $Id)
                ->where('Status !=', 0);
            $query = $this->db->get();
        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND);
        }
    }

    public function checkexistingcodesame($TableName, $reg_id)
    {

        $this->db->select('*');
        $this->db->from($TableName);
        $this->db->where( $reg_id);
        $this->db->where("Status !=", 0);
        $query = $this->db->get();

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();

            return array('status' => 'TRUE', 'data' => $count, null, 'message' => "Not Used");
        } else {
            // found duplicate record
            $count = $query->num_rows();

            return array('status' => 'FALSE', 'data' => $count, null, 'message' => AllREADY_USED);
        }
    }

    public function checkexistingcode($TableName, $reg_id)
    {
        $this->db->select('*');
        $this->db->from($TableName);
        $this->db->group_start()
            ->where( $reg_id)
            //->or_where($Name2, $Id)
            ->group_end();
        $this->db->where("Status !=", 0);
        $query = $this->db->get();

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();

            return array('status' => 'TRUE', 'data' => $count, null, 'message' => "Not Used");
        } else {
            // found duplicate record
            $count = $query->num_rows();

            return array('status' => 'FALSE', 'data' => $count, null, 'message' => AllREADY_USED);
        }
    }

    public function checkexisting($TableName, $reg_id)
    {

        $this->db->select('*');
        $this->db->from($TableName);
        $this->db->where($reg_id);
        $this->db->where("Status !=", 0);
        $query = $this->db->get();

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();

            if ($reg_id = "MessId") {

                $this->db->select('*');
                $this->db->from("registration");
                $this->db->where( $reg_id);
                $this->db->where("Status", ACTIVESTATUS);
                $query2 = $this->db->get();

                if ($query2->num_rows() <= 0) {
                    // not found duplicate record
                    $count = $query2->num_rows();

                } else {

                }

            }

            return array('status' => 'TRUE', 'data' => $count, null, 'message' => "Not Used");
        } else {
            // found duplicate record
            $count = $query->num_rows();

            return array('status' => 'FALSE', 'data' => $count, null, 'message' => AllREADY_USED);
        }

    }

    public function CrudActionMultiple($Data, $Action, $Table)
    {

        $loom = array();

        if ($Data > 0) {

            foreach ($Data as $key => $value) {

                if ($Check == "") {

                    $this->db->select('*');
                    $this->db->from($Table);
                    $this->db->where('reg_id', $Data[$key]->reg_id);
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {
                        $data = array(
                            'Status' => $Action,
                            'UpdatedBy' => 1,
                            'UpdatedOn' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('rge_id', $Data[$key]->reg_id);
                        $this->db->update($Table, $data);
                    }
                } else {
                    if ($CheckId == "Status") {

                        $checkexisting = $this->checkexistingcode($Check, $Data[$key]->reg_id); // Name must be unique
                       
                    } else {
                        $checkexisting = $this->checkexisting($Check, $Data[$key]->reg_id); // Name must be unique
                    }

                    if ($checkexisting['data'] <= 0) {

                        $this->db->select('*');
                        $this->db->from($Table);
                        $this->db->where('reg_id', $Data[$key]->reg_id);
                        $query = $this->db->get();

                        if ($query->num_rows() > 0) {
                            $data = array(
                                'Status' => $Action,
                                'UpdatedBy' => 1,
                                'UpdatedOn' => date('Y-m-d H:i:s'),
                            );
                            $this->db->where('reg_id', $Data[$key]->reg_id);
                            $this->db->update($Table, $data);
                        }

                   }
                   else {
                        array_push($loom, $Data[$key]->$reg_id);
                    }

               }
            }

            if (count($loom) > 0) {
                return array('status' => 'TRUE', 'data' => $loom, 'message' => "Action Successfully Applied , But This Data In Used :", 'code' => "");
            } else {
                return array('status' => 'TRUE', 'data' => $loom, 'message' => "Action Successfully Applied", 'code' => "");
            }

        } else {
            return array('status' => 'FALSE', 'data' => $loom, 'message' => "Action Not Applied", 'code' => "");
        }

    }

    public function unique_check_loom($TableName, $Id, $Name, $RowName, $Name1, $RowName1)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end();
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end()
                ->where('reg_id !=', $reg_id);
            $query = $this->db->get();

        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND);
        }
    }

    public function unique_check_codemaster($TableName, $Id, $Name, $RowName, $Name1, $RowName1)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where($RowName, $Name);
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', ACTIVESTATUS)
                ->where($RowName, $Name)
                ->where('Id !=', $Id);
            $query = $this->db->get();

        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND);
        }
    }

    public function unique_check_code_inactive($TableName, $Id, $Name, $RowName, $Name1, $RowName1)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', INACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end();
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', INACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end()
                ->where('reg_id !=', $reg_id);
            $query = $this->db->get();

        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            $List = $query->result();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND, 'listdata' => $List);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            $List = $query->result();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND, 'listdata' => $List);
        }
    }

    public function unique_check_loom_inactive($TableName, $Id, $Name, $RowName, $Name1, $RowName1)
    {
        if ($Id <= 0) {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', INACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end();
            $query = $this->db->get();

        } else {
            $this->db->select('*');
            $this->db->from($TableName);
            $this->db->where('Status', INACTIVESTATUS)
                ->group_start()
                ->where($RowName, $Name)
                ->or_where($RowName1, $Name1)
                ->group_end()
                ->where('reg_id !=', $reg_id);
            $query = $this->db->get();

        }

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();
            $List = $query->result();
            return array('status' => 'TRUE', 'data' => $count, null, 'message' => LIST_FOUND, 'listdata' => $List);
        } else {
            // found duplicate record
            $count = $query->num_rows();
            $List = $query->result();
            return array('status' => 'FALSE', 'data' => $count, null, 'message' => DUPLICATE_FOUND, 'listdata' => $List);
        }
    }

    public function checkactive($TableName, $Id, $Name)
    {

        $this->db->select('*');
        $this->db->from($TableName);
        $this->db->where('reg_id', $reg_id);
        $this->db->where("Status !=", "Active");
        $query = $this->db->get();

        if ($query->num_rows() <= 0) {
            // not found duplicate record
            $count = $query->num_rows();

            return array('status' => 'TRUE', 'data' => $count, null, 'message' => "Not Used");

        } else {
            // found duplicate record
            $count = $query->num_rows();

            return array('status' => 'FALSE', 'data' => $count, null, 'message' => "Your Selected " . $Name . " Inactive.");
        }

    }

}
