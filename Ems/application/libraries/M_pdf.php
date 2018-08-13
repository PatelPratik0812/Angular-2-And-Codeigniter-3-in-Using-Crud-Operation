<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'third_party/mpdf/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
	
	public function __construct($param = "'c','A4','','',42,15,67,67,20,15")
    {
        $this->param =$param;
        $this->pdf = new mPDF("'L','','','','',25,25,55,45,18,12");
    }
}
?>