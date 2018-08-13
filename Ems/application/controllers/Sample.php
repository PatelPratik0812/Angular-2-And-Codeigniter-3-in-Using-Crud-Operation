<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model("app_template");
		$this->load->library('mongo_db');
	} 
	 
	public function index()
	{
		$page['title'] = "Home";
		$page['page'] = "mongo_signup";
		$page['scripts'] = ['templates/js/jquery-2.1.4.min.js', 'templates/js/bootstrap.min.js', 'templates/js/angular.min.js', 'templates/js/angular-route.min.js', 'templates/js/app.js'];
		$page['styles'] = ['templates/css/bootstrap.css', 'templates/css/style.css'];
		
		$page['user_collection'] = $this->mongo_db->get("users");
		$this->load->view("index", $page);
	}

	public function update($actionId){
		$page['title'] = "Home";
		$page['page'] = "mongo_update_profile";
		$page['scripts'] = ['templates/js/jquery-2.1.4.min.js', 'templates/js/bootstrap.min.js', 'templates/js/angular.min.js', 'templates/js/angular-route.min.js', 'templates/js/app.js'];
		$page['styles'] = ['templates/css/bootstrap.css', 'templates/css/style.css'];
		
		$page['user_document'] = $this->mongo_db->where("_id", $actionId)->get("users");
		$this->load->view("index", $page);
	}
	
	public function do_create_user(){
		$user['firstName'] = $this->input->post("firstName");
		$user['lastName']  = $this->input->post("lastName");
		$user['email']     = $this->input->post("email");
		$user['password']  = $this->input->post("password");
		
		
		$this->mongo_db->where("email", $user['email']);
		$check = $this->mongo_db->get("users");
		
		if(empty($check)){
			$insert = $this->mongo_db->insert("users", $user);
			redirect(base_url()."sample/login/");	
		}
		else{
			redirect(base_url()."sample/?error");
		}
		
	}
	
}
