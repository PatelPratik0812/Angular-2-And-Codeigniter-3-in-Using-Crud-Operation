<?php
class Email extends CI_Controller {

    function Email()
    {
        parent::Controller();   
        $this->load->library('email');
    }

    function index()
    {
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'localhost:8090';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'patelpratik5992@gmail.com';
        $config['smtp_pass']    = '*#22@57*#';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('patelpratik5992@gmail.com', 'pratik');
        $this->email->to('divyesh1.hadiyal@gmail.com'); 

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  

        $this->email->send();

        echo $this->email->print_debugger();

        //$this->load->view('email_view');
    }
}