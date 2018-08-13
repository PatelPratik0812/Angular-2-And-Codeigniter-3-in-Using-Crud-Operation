<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!defined('TCPDF_ROOT')) {
    define('TCPDF_ROOT', dirname(__FILE__) . '/');
    require(TCPDF_ROOT . 'tcpdf/tcpdf.php');
}

class mytcpdf extends TCPDF
{
   protected $ci;
   public function __construct()
    {
           // $this->ci-> get_instance();
    }
}
?>