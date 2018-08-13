<?php

class Front_model extends CI_Model
{

    private $codemaster = 'codemaster';
    private $messincentive = 'messincentive';
    private $loomdaily = 'loomdaily';
    private $loom = 'loom';
    private $incentivecalculation = 'incentivecalculation';

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_code_name($Id, $Name)
    {
        if ($Id != '') {

            $this->db->select('codemaster.*,codemaster.Name as ' . $Name . '');
            $this->db->from($this->codemaster);
            $this->db->where("Id", $Id);
            $Data = $this->db->get()->result_array();

            if ($Data[0][$Name] != null) {
                return $Data[0][$Name];
            } else {
                return "None";
            }
        } else {
            //return 'dsa';
        }
        return $Data;
    }

    public function get_loom_endreading($loomDate, $shift, $loomId)
    {

        $time = strtotime($loomDate);
        $dateInLocal = date("Y-m-d H:i:s", $time);
        $datetime = explode(' ', $dateInLocal);
        $date = $datetime[0];
        $time3 = $datetime[1];
        $time2 = strtotime($date);
        $finaldate = date("Y-m-d", mktime(0, 0, 0, date("n", $time2), date("j", $time2), date("Y", $time2)));

        $loomFinalDate = (string) $finaldate;

        if ($shift != '' && $shift != '-1') {
            $this->db->select('loomdaily.*,mess.Size as "MessSize"');
            $this->db->from("loomdaily");
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->where('Date(LoomDate)', $loomFinalDate);
            $this->db->where('loomdaily.LoomId', $loomId);
            $this->db->where('loomdaily.Status !=', 0);
            // $this->db->where('loomdaily.StartReading !=', 0);

            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                if ($query->num_rows() == 2) {
                    //loom,date,shiftid
                    $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                    $this->db->from("loomdaily");
                    $this->db->join("mess", "loomdaily.MessId = mess.Id");
                    $this->db->where('loomdaily.LoomId', $loomId);
                    $this->db->where('loomdaily.Status !=', 0);
                    $this->db->where('Date(LoomDate)', $loomFinalDate);
                    $this->db->where('loomdaily.ShiftId', $shift);
                    $this->db->order_by("loomdaily.LoomDate", "desc");
                    $this->db->order_by("ShiftId", "desc");
                    $this->db->limit("1");

                    $query2 = $this->db->get();

                    $res2 = $query2->row();

                    return $res2;

                } else if ($query->num_rows() == 1) {
                    $res = $query->row();
                    $user_shift = $shift;
                    $res_shift = $res->ShiftId;
                    if ($user_shift == $res_shift) {
                        //loom,date,shiftid

                        $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                        $this->db->from("loomdaily");
                        $this->db->join("mess", "loomdaily.MessId = mess.Id");
                        $this->db->where('loomdaily.LoomId', $loomId);
                        $this->db->where('loomdaily.Status !=', 0);
                        $this->db->where('Date(LoomDate)', $loomFinalDate);
                        $this->db->where('loomdaily.ShiftId', $shift);
                        $this->db->order_by("loomdaily.LoomDate", "desc");
                        $this->db->order_by("ShiftId", "desc");
                        $this->db->limit("1");

                        $query3 = $this->db->get();

                        $res3 = $query3->row();

                        return $res3;

                    } else {

                        if ($user_shift < $res_shift) {

                            $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                            $this->db->from("loomdaily");
                            $this->db->join("mess", "loomdaily.MessId = mess.Id");
                            $this->db->where('loomdaily.LoomId', $loomId);
                            $this->db->where('loomdaily.Status !=', 0);
                            $this->db->where('Date(LoomDate) <', $loomFinalDate);
                            $this->db->order_by("loomdaily.LoomDate", "desc");
                            $this->db->order_by("ShiftId", "desc");
                            $this->db->limit("1");

                            $query4 = $this->db->get();

                            $res4 = $query4->row();

                            if ($res4->EndReading != '' && $res4->EndReading != 0) {
                                return $res4;
                            } else {
                                return "";
                            }

                            //< conditon with  date and loom with end reading 0
                        } else {
                            $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                            $this->db->from("loomdaily");
                            $this->db->join("mess", "loomdaily.MessId = mess.Id");
                            $this->db->where('loomdaily.LoomId', $loomId);
                            $this->db->where('loomdaily.Status !=', 0);
                            $this->db->where('Date(LoomDate) <=', $loomFinalDate);
                            $this->db->order_by("loomdaily.LoomDate", "desc");
                            $this->db->order_by("ShiftId", "desc");
                            $this->db->limit("1");

                            $query5 = $this->db->get();

                            $res5 = $query5->row();

                            return $res5;

                            //<= conditon with  date and loom
                        }
                    }
                    //loom,date,shiftid
                }
            } else {
                if ($shift > 1) {
                    $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                    $this->db->from("loomdaily");
                    $this->db->join("mess", "loomdaily.MessId = mess.Id");
                    $this->db->where('loomdaily.LoomId', $loomId);
                    $this->db->where('loomdaily.Status !=', 0);
                    $this->db->where('Date(LoomDate)', $loomFinalDate);
                    $this->db->where('loomdaily.EndReading !=', 0);
                    $this->db->order_by("loomdaily.LoomDate", "desc");
                    $this->db->order_by("ShiftId", "desc");
                    $this->db->limit("1");
                    $query2 = $this->db->get();
                    if ($query2->num_rows() > 0) {
                        $res2 = $query2->row();
                        if ($res2->EndReading != '' && $res2->EndReading != 0) {
                            return $res2;
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }
                } else {
                    $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                    $this->db->from("loomdaily");
                    $this->db->join("mess", "loomdaily.MessId = mess.Id");
                    $this->db->where('loomdaily.LoomId', $loomId);
                    $this->db->where('loomdaily.Status !=', 0);
                    $this->db->where("Date(LoomDate) = subdate('$loomFinalDate',1)");
                    $this->db->where('loomdaily.ShiftId', 2);
                    $this->db->where('loomdaily.EndReading !=', 0);
                    $this->db->order_by("loomdaily.LoomDate", "desc");
                    $this->db->order_by("ShiftId", "desc");
                    $this->db->limit("1");
                    $query2 = $this->db->get();
                    if ($query2->num_rows() > 0) {
                        $res2 = $query2->row();
                        if ($res2->EndReading != '' && $res2->EndReading != 0) {
                            return $res2;
                        } else {
                            return "";
                        }
                    } else {
                        return "";
                    }

                }
            }
            
        } else {
            $this->db->select('loomdaily.*,mess.Size as "MessSize"');
            $this->db->from("loomdaily");
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->where('Date(LoomDate)', $loomFinalDate);
            $this->db->where('loomdaily.LoomId', $loomId);
            $this->db->where('loomdaily.Status !=', 0);
            $this->db->order_by("ShiftId", "desc");
            $this->db->limit("1");

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $res2 = $query->row();
                return $res2;
            } else {

                $this->db->select('loomdaily.*,mess.Size as "MessSize"');
                $this->db->from("loomdaily");
                $this->db->join("mess", "loomdaily.MessId = mess.Id");
                $this->db->where('loomdaily.LoomId', $loomId);
                $this->db->where('loomdaily.Status !=', 0);
                $this->db->where("Date(LoomDate) = subdate('$loomFinalDate',1)");
                $this->db->where('loomdaily.ShiftId', 2);
                $this->db->where('loomdaily.EndReading !=', 0);
                $this->db->order_by("loomdaily.LoomDate", "desc");
                $this->db->limit("1");

                $query2 = $this->db->get();

                if ($query2->num_rows() > 0) {
                    $res = $query2->row();

                    if ($res->EndReading != '' && $res->EndReading != 0) {
                        return $res;
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }

            }
        }

        return null;

    }

    public function get_loom_endreading2($loomDate, $shift, $loomId)
    {

        $time = strtotime($loomDate);
        $dateInLocal = date("Y-m-d H:i:s", $time);
        $datetime = explode(' ', $dateInLocal);
        $date = $datetime[0];
        $time3 = $datetime[1];
        $time2 = strtotime($date);
        $finaldate = date("Y-m-d", mktime(0, 0, 0, date("n", $time2), date("j", $time2), date("Y", $time2)));

        $loomFinalDate = (string) $finaldate;

        $this->db->select('loomdaily.*,mess.Size as "MessSize"');
        $this->db->from("loomdaily");
        $this->db->join("mess", "loomdaily.MessId = mess.Id");
        $this->db->where('Date(LoomDate)', $loomFinalDate);
        $this->db->where('loomdaily.LoomId', $loomId);
        $this->db->where('loomdaily.Status !=', 0);
        $this->db->order_by("ShiftId", "desc");
        $this->db->limit("1");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $res2 = $query->row();
            return $res2;
        } else {

            $this->db->select('loomdaily.*,mess.Size as "MessSize"');
            $this->db->from("loomdaily");
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->where('loomdaily.LoomId', $loomId);
            $this->db->where('loomdaily.Status !=', 0);
            $this->db->where('Date(LoomDate) <=', $loomFinalDate);
            $this->db->order_by("loomdaily.LoomDate", "desc");
            $this->db->order_by("ShiftId", "desc");
            $this->db->limit("1");

            $query2 = $this->db->get();

            if ($query2->num_rows() > 0) {
                $res = $query2->row();

                if ($res->EndReading != '' && $res->EndReading != 0) {
                    return $res;
                } else {
                    return "";
                }
            } else {
                return "";
            }

        }

        return null;

    }

    public function get_production_statuswise_datewise($shiftname,$enddate)
    {

        if ($enddate != '') {

            $this->db->select('*,sum(loomdaily.Production) as TotalProduction');
            $this->db->from($this->loomdaily);
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("codemaster", "loomdaily.Status = codemaster.Id");
            $this->db->where('LoomDate', $enddate);
            $this->db->where("shift.Type", $shiftname);

            $query = $this->db->get();

            $Data = $query->result();

            $count = $Data[0]->TotalProduction;
           
            if ($query->num_rows() > 0) {
                return $count;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $count;
    }

    public function get_count_statuswise_datewise($StatusName, $shiftname,$enddate)
    {

        if ($enddate != '') {

            $this->db->select('*');
            $this->db->from($this->loomdaily);
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("codemaster", "loomdaily.Status = codemaster.Id");
            $this->db->where("codemaster.Name", $StatusName);
            $this->db->where('LoomDate', $enddate);
            $this->db->where("shift.Type", $shiftname);

            $query = $this->db->get();

            $count = $query->num_rows();

            if ($query->num_rows() > 0) {
                return $count;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $count;
    }

    public function get_loomstatus_data_datewise($Id, $Name)
    {
        if ($Id != '') {

            $this->db->select('loomdaily.*,mess.Size as "MessSize",
            shift.Type as "ShiftName",
            loom.Name as "LoomName",
            quality.Name as "QualityName",
            employeemaster.FirstName as "EmpFirstName",sum(loomdaily.Production) as TotalProduction');
            $this->db->from($this->loomdaily);
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("loom", "loomdaily.LoomId = loom.Id");
            $this->db->join("codemaster", "loomdaily.Status = codemaster.Id");
            $this->db->join("quality", "loomdaily.QualityId = quality.Id");
            $this->db->join("employeemaster", "loomdaily.EmployeeId = employeemaster.Id");
            $this->db->where("loomdaily.Status !=", "0");
            $this->db->where("LoomDate", $Id);

            $query = $this->db->get();

           
            if ($query->num_rows() > 0) {

                $Data = $query->result();
                $i = 0;
                foreach ($Data as $value) {

                    $PerformanceName = $this->front_model->get_code_name($value->Performance, "PerformanceName");

                    $StatusName = $this->front_model->get_code_name($value->Status, "StatusName");

                    $Data[$i]->PerformanceName = $PerformanceName;
                    $Data[$i]->StatusName = $StatusName;
                    $i += 1;
                }
                return $Data;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $Data;
    }

    /*****Remaining for solve START*******/
    public function get_loomstatus_data($Id, $Name, $start, $end)
    {
        $startdate = date("Y-m-d", strtotime($start));
        $enddate = date("Y-m-d", strtotime($end));

        if ($Id != '') {

            $this->db->select('loomdaily.*,mess.Size as "MessSize",
            shift.Type as "ShiftName",
            loom.Name as "LoomName",
            quality.Name as "QualityName",
            employeemaster.FirstName as "EmpFirstName",sum(loomdaily.Production) as TotalProduction');
            $this->db->from($this->loomdaily);
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("loom", "loomdaily.LoomId = loom.Id");
            $this->db->join("quality", "loomdaily.QualityId = quality.Id");
            $this->db->join("employeemaster", "loomdaily.EmployeeId = employeemaster.Id");
            $this->db->where("loomdaily.Status !=", "0");
            $this->db->where("QualityId", $Id);

            if ($startdate != "NaN-aN-aN" && $enddate != "NaN-aN-aN") {
                if ($startdate && $enddate) {
                    //$this->db->where("loomdaily.LoomDate BETWEEN $startdate AND $enddate");
                    $this->db->where('loomdaily.LoomDate >=', $startdate);
                    $this->db->where('loomdaily.LoomDate <=', $enddate);
                }

            }

            $this->db->group_by("shift.Id");

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $Data = $query->result();
                $i = 0;
                foreach ($Data as $value) {

                    $PerformanceName = $this->front_model->get_code_name($value->Performance, "PerformanceName");

                    $StatusName = $this->front_model->get_code_name($value->Status, "StatusName");

                    $Data[$i]->PerformanceName = $PerformanceName;
                    $Data[$i]->StatusName = $StatusName;
                    $i += 1;
                }
                return $Data;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $Data;
    }

    /*****Remaining for solve END*******/
    public function get_production_data($Id, $Name)
    {
        if ($Id != '') {

            $this->db->select('loomdaily.*,mess.Size as "MessSize",
            shift.Type as "ShiftName",
            loom.Name as "LoomName",
            quality.Name as "QualityName",
            employeemaster.FirstName as "EmpFirstName",sum(loomdaily.Production) as TotalProduction');
            $this->db->from($this->loomdaily);
            $this->db->join("mess", "loomdaily.MessId = mess.Id");
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("loom", "loomdaily.LoomId = loom.Id");
            $this->db->join("quality", "loomdaily.QualityId = quality.Id");
            $this->db->join("employeemaster", "loomdaily.EmployeeId = employeemaster.Id");
            $this->db->where("loomdaily.Status !=", "0");
            $this->db->where("QualityId", $Id);
            $this->db->group_by("shift.Id");

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $Data = $query->result();
                $i = 0;
                foreach ($Data as $value) {

                    $PerformanceName = $this->front_model->get_code_name($value->Performance, "PerformanceName");

                    $StatusName = $this->front_model->get_code_name($value->Status, "StatusName");

                    $Data[$i]->PerformanceName = $PerformanceName;
                    $Data[$i]->StatusName = $StatusName;
                    $i += 1;
                }
                return $Data;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $Data;
    }

    public function get_count_statuswise($qualityid, $StatusName, $shiftname, $startdate, $enddate)
    {

        if ($qualityid != '') {

            $this->db->select('*');
            $this->db->from($this->loomdaily);
            $this->db->join("shift", "loomdaily.ShiftId = shift.Id");
            $this->db->join("codemaster", "loomdaily.Status = codemaster.Id");
            $this->db->where("QualityId", $qualityid);
            $this->db->where("codemaster.Name", $StatusName);
            $this->db->where("shift.Type", $shiftname);

            if ($startdate != "NaN-aN-aN" && $enddate != "NaN-aN-aN") {
                if ($startdate && $enddate) {
                    //$this->db->where("loomdaily.LoomDate BETWEEN $startdate AND $enddate");
                    $this->db->where('loomdaily.LoomDate >=', $startdate);
                    $this->db->where('loomdaily.LoomDate <=', $enddate);
                }

            }

            $query = $this->db->get();

            $count = $query->num_rows();

            if ($query->num_rows() > 0) {
                return $count;
            } else {
                return "0";
            }

        } else {
            //return 'dsa';
        }
        return $count;
    }

    public function get_incentive_amount($Id, $Production, $loomDailyData)
    {
        if ($Id != '') {

            $this->db->select('messincentive.*,messincentive.Amount');
            $this->db->from($this->messincentive);
            $this->db->where('Status', ACTIVESTATUS);
            $this->db->where("MessId = $Id AND $Production BETWEEN min AND max");

            $Data = $this->db->get()->result_array();

            if ($Data[0]["Amount"] != null) {
                return $Data[0]["Amount"];
            } else {
                return "0";
            }
        } else {
            //return 'dsa';
        }
        return $Data;
    }

    public function get_incentive_wisedata()
    {

        $prevblank = $this->db->query("CALL EmployeeLoomCountReport('2018-01-01','2018-02-28','1')");

        $prevblankresult = $prevblank->result_array();

        return $prevblankresult;
    }

    public function GetMatchineCountStatus($startdate, $enddate, $shift, $status)
    {

        $this->db->select('*');
        $this->db->from($this->loomdaily);
        $this->db->join("codemaster", "codemaster.Id = loomdaily.Status");
        $this->db->where("loomdaily.Status= $status");
        //$this->db->group_by("loomdaily.LoomId");

        if ($shift != "null" && $shift) {
            $this->db->where("loomdaily.ShiftId = $shift");
        }

        if ($startdate != "NaN-aN-aN" && $enddate != "NaN-aN-aN") {
            if ($startdate && $enddate) {
                $this->db->where('loomdaily.LoomDate >=', $startdate);
                $this->db->where('loomdaily.LoomDate <=', $enddate);
            }

        }

        $query = $this->db->get();

        $count = $query->num_rows();

        if ($query->num_rows() > 0) {
            return $count;
        } else {
            return 0;
        }
        return $count;
    }

    public function GetLoomCount()
    {
        $this->db->select('*');
        $this->db->from($this->loom);
        $this->db->where("Status", "Active");

        $query = $this->db->get();

        $count = $query->num_rows();

        if ($query->num_rows() > 0) {
            return $count;
        } else {
            return "0";
        }
        return $count;
    }

}
