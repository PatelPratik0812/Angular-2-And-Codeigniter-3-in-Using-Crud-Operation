<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

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
		$this->load->library('facebook');
		$this->load->library('googleplus');
		date_default_timezone_set('Asia/Kolkata');
		redirect('#/');
	}
	 public function index()	{
		$page['title'] = "Home";
		$page['page'] = "mainpage"; 
		$page['scripts'] = ['templates/js/mainpage.js'];
		$page['styles'] = ['templates/css/homepage.css'];
		$this->load->view("index", $page);
	}
	
	
	public function user($param1 = null,$param2 = null){
		if($param1 == 'login'){
			/*
			if ($this->session->userdata('sp_login') == 1){
							redirect(base_url());	
						}*/
			
			$page['title'] = "Login";
			$page['page'] = "login";
			$page['login_url'] = $this->facebook->getLoginUrl(array(
	                'redirect_uri' => site_url('index/fbLogin/'), 
	                'scope' => array("email") // permissions here
	            ));		
			$page['gplus_url'] = $this->googleplus->createAuthUrl();	
		}
		if($param1 == 'logout'){
			$this->session->unset_userdata("sp_login");	
			$this->session->unset_userdata("sp_id");	
			$this->session->unset_userdata("sp_user_email");
			$this->session->unset_userdata("sp_user_type");
			redirect(base_url(), 'refresh');
		}
		if($param1 == 'signUp'){
			$page['title'] = "Sign Up";
			$page['page'] = "signUp";
		}
		if($param1 == 'profile'){
			$page['title'] = "Profile";
			$page['page'] = "user-profile";
		}
		if($param1 == 'verify'){
			if($param2 != ''){
				$verify = $this->db->get_where("sp_users", array("auth_token" => $param2));
				if($verify->num_rows() == 1){
					$user_row = $verify->row_array();
					$user_id = $user_row['user_id'];
					$this->db->where('user_id',$user_id);
					$this->db->update("sp_users", array("auth_token"=>NULL, "activation_date" => time(),"is_active"=>1,"is_deleted"=>0));
					
					$welcome_mail = $this->email_model->send_welcome_email($user_row['email']);
					if($welcome_mail == 1){
						$this->session->set_flashdata('verify_popup_message', 'Your account successfully verify!');
					}
				} else if($verify->num_rows() == 0){
					/*$welcome_mail = $this->email_model->send_welcome_email('kashyap@coronation.in');
					if($welcome_mail == 1){*/
						$this->session->set_flashdata('verify_popup_message', 'Your account already verify!');
					/*}*/
				}
			}
			redirect(base_url('index/user/login'));
		}
		if($param1 == 'reset_password'){
			if(!empty($param2)){
				$verify = $this->db->get_where("sp_users", array("auth_token" => $param2));
				if($verify->num_rows() == 1){
					$user_row = $verify->row_array();
					$user_id = $user_row['user_id'];
					$this->session->set_userdata('sp_forgot_id', $user_id);
					$page['title'] = "Forgot";
					$page['page'] = "forgot";
					
				}
				else {
					redirect(base_url());
				} 
			}else {
				redirect(base_url());
			}	
		}
		$page['scripts'] = ['templates/select.js'];
		$page['styles'] = ['templates/select.css'];
		$this->load->view("index", $page);
	}
	
	public function fbLogin(){
		
		$user = $this->facebook->getUser();
		
		if ($user) {
			
            try {
                $page['user_profile'] = $this->facebook->api('/me', array('fields' => 'id,email,first_name,last_name,picture'));
				
				$email = $page['user_profile']['email'];
				$firstName = $page['user_profile']['first_name'];
				$lastName = $page['user_profile']['last_name'];
				
				$checkUsr = $this->db->get_where("users", array("email"=>$email))->row_array();
				
				if(!empty($checkUsr)){
					
					$data['firstName'] = $page['user_profile']['first_name'];
					$data['lastName'] = $page['user_profile']['last_name'];
					$data['email'] = $page['user_profile']['email'];
					$data['type'] = "facebook";
					$data['social_id'] = $page['user_profile']['id'];
					
					$this->db->where("email",$data['email']);
					$this->db->update("users", $data);
					
					redirect(base_url()."index/dashboard/");
				}
				
				else{
					
					$data['firstName'] = $page['user_profile']['first_name'];
					$data['lastName'] = $page['user_profile']['last_name'];
					$data['email'] = $page['user_profile']['email'];
					$data['type'] = "facebook";
					$data['social_id'] = $page['user_profile']['id'];
					
					$this->db->insert("users", $data);
					
					redirect(base_url()."index/dashboard/");	
				}
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }
	}
	
	public function profile_edit(){
		/*if ($this->session->userdata('sp_login') == 1){*/
			$page['title'] = "Profile";
			$page['page'] = "edit-profile";
			$page['scripts'] = ['templates/admin/js/ng-file-upload-shim.js','templates/admin/js/ng-file-upload.js'];
			$page['styles'] = ['templates/css/pruthvi.css'];
			$this->load->view("index", $page);
		/*} else { redirect(base_url()); }*/
	}
	
	public function company_profile($companyId){
		$page['title'] = "Company Profile";
		$page['page'] = "company-profile";
		$page['companyId'] = $companyId;
		
		$this->db->where('user_id',$companyId);
		$company = $this->db->get('sp_users')->row_array();
		$page['title'] = $company['company_name'];
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	public function scrap_price(){
		$page['title'] = "Scrap Price";
		$page['page'] = "scrap-price"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}

	/* My Account pages */
	public function my_contacts(){
		$page['title'] = "My Contacts";
		$page['page'] = "my-contacts"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css'];
		
		$this->load->view("index", $page);
	}

	
	public function active_offers(){
		$page['title'] = "Active Offers";
		$page['page'] = "active-offers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		
		$this->load->view("index", $page);
	}

	public function expired_offers(){
		$page['title'] = "Expired Offers";
		$page['page'] = "expired-offers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		$this->load->view("index", $page);
	}
	
	public function deleted_offers(){
		$page['title'] = "Deleted Offers";
		$page['page'] = "deleted-offers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		$this->load->view("index", $page);
	}
	
	public function status_offers(){
		$page['title'] = "Status Offers";
		$page['page'] = "status-offers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		$this->load->view("index", $page);
	}
	
	public function my_soldOffers(){
		$page['title'] = "My Sold Offers";
		$page['page'] = "my_soldOffers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		$this->load->view("index", $page);
	}
	
	public function my_purchasedOffers(){
		$page['title'] = "My Purchased Offers";
		$page['page'] = "my_purchasedOffers"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		$this->load->view("index", $page);
	}
	

	
	public function my_account(){
		$page['title'] = "My Account";
		$page['page'] = "my-account"; 
		$page['typeOfDocuments'] = 'offer'; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}
		
	public function favourite_offers(){
		$page['title'] = "Favourite Offers";
		$page['page'] = "favourite-offers"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}
	
	public function block_list(){
		$page['title'] = "My Block list";
		$page['page'] = "blocked-list"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/my_contacts.css'];
		$this->load->view("index", $page);
	}
	
	public function mail_alerts(){
		$page['title'] = "Offer Alerts";
		$page['page'] = "mail-alerts"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}

	public function my_documents($action = null){
		if($action == 'personnel' || $action == 'offer'){
			$page['title'] = "My Documents";
			$page['page'] = "my-documents";
			$page['typeOfDocuments'] = $action; 
			$page['scripts'] = ['templates/js/swiper.min.js'];
			$page['styles'] = ['templates/css/swiper.css','templates/css/pruthvi.css','templates/css/replies-to-offer.css'];
			$this->load->view("index", $page);
		}
	}

	public function replies ($param) {
		
		if($param == "me") {
			$page['title'] = "Replies to My offer";
			$page['page'] = "replies-me"; 
			$page['scripts'] = [];
			$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css'];
			$this->load->view("index", $page);	
		}
		else if ($param == "to") {
			$page['title'] = "My Replies to offers";
			$page['page'] = "replies-to"; 
			$page['scripts'] = [];
			$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css'];
			$this->load->view("index", $page);
		}
	}
	
	public function chats ($param = null) {
		$page['title'] = "My Chats";
		$page['page'] = "chats";
		if($param ==""){
			$page['activeTab'] = "all";
		}
		else if($param =="to"){
			$page['activeTab'] = "to";
		}
		else if($param =="me"){
			$page['activeTab'] = "me";
		}
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/chats.css'];
		$this->load->view("index", $page);
	}
	
	/* End:/ My Account pages */
		
	
	public function suppliers(){
		$page['title'] = "Suppliers";
		$page['page'] = "supplier-list"; 
		$page['scripts'] = [];
		$page['styles'] = [];
		
		$this->load->view("index", $page);
	}
	
 	public function buyers(){
		$page['title'] = "Buyers";
		$page['page'] = "buyer-list"; 
		$page['scripts'] = [];
		$page['styles'] = [];
		$this->load->view("index", $page);
	}
	
	
	public function postoffer($offer_id = null){
		$page['title'] = "Post offer";
		$page['page'] = "post-offer"; 
		$page['offer_id'] = $offer_id;	
		if($offer_id == null){
			$page['offer_id'] = 0;	
		}
		$page['scripts'] = ['templates/admin/js/ng-file-upload-shim.js','templates/admin/js/ng-file-upload.js','templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/date_time_picker.css'];
 		$this->load->view("index", $page);
	}
	
	public function buy_scrap(){
		$page['title'] = "Buy Offers";
		$page['page'] = "buy-scrap"; 
		$page['scripts'] = [ 'templates/js/ng-tags-input.min.js' ,'templates/js/app.js'];
		$page['styles'] = ['templates/css/admin.css','templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}

	public function sell_scrap(){
		$page['title'] = "Sell Offers";
		$page['page'] = "sell-scrap"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	public function search($keyword = null){
		$keyword = urldecode($keyword);
		$page['title'] = "Search for '".$keyword."'";
		$page['page'] = "search"; 
		$page['keyword'] = $keyword;
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	public function our_sell_scraps($companyId = null){
		$page['title'] = "Our Sell Scrap";
		$page['page'] = "sell-scrap-company";
		
		$page['companyId'] = $companyId;
		$this->db->where('user_id',$companyId);
		$company = $this->db->get('sp_users')->row_array();
		$page['title'] = 'Selling Offers - '.$company['company_name'];
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	public function our_buy_scraps($companyId = null){
		$page['title'] = "Our Buy Scrap";
		$page['page'] = "buy-scrap-company";
		
		$page['companyId'] = $companyId;
		$this->db->where('user_id',$companyId);
		$company = $this->db->get('sp_users')->row_array();
		$page['title'] = 'Buying Offers - '.$company['company_name'];
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	public function offer_details($id = null){
		$page['title'] = "Offer Detail";
		
		$this->db->where('offer_id',$id);
		$offer = $this->db->get('sp_offers')->row_array();
		$page['title'] = $offer['offer_title'];
		
		$page['page'] = "offer-details";  
		$page['scripts'] = ['templates/js/swiper.min.js','templates/js/wheelzoom.js'];
		$page['styles'] = ['templates/css/swiper.css','templates/css/pruthvi.css'];
		$this->load->view("index", $page);
	}
	
	/* Teneder listing */
	public function tenders(){
		$page['title'] = "Tenders";
		$page['page'] = "tender"; 
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}
	
	public function new_tender($tender_id = null){
		$page['title'] = "New Tender";
		$page['page'] = "post-tender"; 
		$page['tender_id'] = $tender_id;	
		if($tender_id == null){
			$page['tender_id'] = 0;	
		}
		$page['scripts'] = ['templates/admin/js/ng-file-upload-shim.js','templates/admin/js/ng-file-upload.js','templates/js/moment.js','templates/js/bootstrap-datetimepicker.min.js'];
		$page['styles'] = ['templates/css/bootstrap-datetimepicker.min.css'];
 		$this->load->view("index", $page);
	}
	/* End:/ Teneder listing */
	
	
	/*  Category wise and Product wise offers */
	public function offers($category_id = 0, $product_id = 0,$group_id = null, $offer_type = null){
		$page['title'] = "Offers";
		
		if($category_id != 0 && $product_id==0){
			$category = $this->db->get_where("sp_categories",array("category_id"=>$category_id))->row_array();
			$page['title'] = 'Category - '.$category['category_name'];
			$page['cat_id'] = $category_id;
			$page['offer_type'] = $offer_type;
			$page['group_id'] = $group_id;
			$page['page'] = "category_wise_offers";
		}
		else if($category_id == 0 && $product_id != 0){
			$product = $this->db->get_where("sp_products",array("product_id"=>$product_id))->row_array();
			$page['title'] = 'Product - '.$product['product_name'];
			$page['product_id'] = $product_id;
			$page['page'] = "product_wise_offers";
		}
		else {
			$category['message'] = 'Category id required!';
		}
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/media.css'];
		$this->load->view("index", $page);
	}
	/* End:/ Category wise and Product wise offers */
	
	
	/*  Company wise offers */
	public function company_offers($company_id = null){
		$page['title'] = "Offers";
		
		if($company_id != null){
			$user = $this->db->get_where("sp_users",array("user_id"=>$company_id))->row_array();
			$page['title'] = $user['company_name'];
			$page['company_id'] = $company_id;
			$page['cat_id'] = 0;
			$page['offer_type'] = null;
			$page['group_id'] = null;
			$page['page'] = "company_wise_offers";
		}
		
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/media.css'];
		$this->load->view("index", $page);
	}
	/* End:/ Company wise offers */

	public function video_gallery(){
		$page['title'] = "Video Gallery";
		$page['page'] = "video_gallery"; 
		$page['scripts'] = ['templates/js/swiper.min.js'];
		$page['styles'] = ['templates/css/swiper.css','templates/css/pruthvi.css'];
		
		$this->load->view("index", $page);
	}
	
	public function ancillary_services(){
		$page['title'] = "Ancillary Service Providers";
		$page['page'] = "ancillary_list"; 
		$page['scripts'] = [];
		$page['styles'] = [];
		
		$this->load->view("index", $page);
	}
	
	public function links(){
		$page['title'] = "All pages";
		$page['page'] = "all_pages";
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/replies-to-offer.css'];
		$this->load->view("index", $page);
	}
	
	public function all_pages(){
		$page['title'] = "All pages";
		$page['page'] = "all_pages";
		$page['scripts'] = [];
		$page['styles'] = ['templates/css/replies-to-offer.css'];
		$this->load->view("index", $page);
	}
	
	
	public function cropImagesPNG(){
		require_once(APPPATH."libraries/SimpleImage.php");
		$normal_Image_path = './media/sample/crop/';
		ini_set('memory_limit', '-1');
		$dir = './media/sample/org/';
		
		$ext_list = array('png','jpg','jpeg','bmp');
		if ($dh = opendir($dir)){
		
			while (($file = readdir($dh)) !== false){
				$file_ext = strtolower(pathinfo($file,PATHINFO_EXTENSION));
				if(in_array($file_ext, $ext_list)) {
					$new_file = rand(0,1000).time().'.png';
					$simple_image = new SimpleImage($dir.$file);
					$simple_image->cutFromCenter(250,205);
					$simple_image->save($normal_Image_path.$new_file);
					echo $normal_Image_path.$new_file.'<br/>';
				}
			}
			closedir($dh);
		 }
	}
	
	
	public function test_mail() {
		
		$from = "nirav@coronation.in";
		$to = "nirav2410@gmail.com";
		$sub = "Scrapport Test mail";
		$msg = "Scrapport Test Message";
		
		$this->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = 465;
		$config['smtp_user'] = "nirav@coronation.in";
		$config['smtp_pass'] = "993@pfdh2410";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		
		$system_name	=	'Scrap Port';
		$this->email->from($from, ucfirst($system_name));
		$this->email->to($to);
		$this->email->subject($sub);
		$this->email->message($msg);
		$sent = $this->email->send();
		if($sent) {
			echo "Mail Sent Successfull";
		}
		else {
			echo "Mail Sent Failed";
		}
	}
	public function my_bidding(){
		$page['title'] = "Biddings";
		$page['page'] = "my_bidding"; 
		$page['scripts'] = ['templates/js/bootstrap-datepicker.js'];
		$page['styles'] = ['templates/css/pruthvi.css','templates/css/replies-to-offer.css','templates/css/date_time_picker.css'];
		
		$this->load->view("index", $page);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */