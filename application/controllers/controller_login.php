<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

require_once APPPATH.'third_party/Google/autoload.php'; // or wherever autoload.php is located
include_once("controller_log.php");
session_start();

class Controller_login extends Controller_log {

	public function __construct() {
		parent::__construct();
		$this->load->model('model_user');
	}

	public function index($banned = FALSE) {
		// var_dump($banned);
		if($this->session->userdata('logged_in') == TRUE){
			redirect('controller_list_alumni', 'refresh');// redirect to controller_search_book
		}

		if($banned == 1){
			$data['titlepage']="UPLB OSA GTracer - User Ban";
			$data['header']="Status: Banned";
			$data['body']="You are currently banned. If you think this is an error, please contact any system administrator.<br><a href='".base_url()."controller_login'>Return to login page</a>";
			$this->load->view("header", $data); 					//displays the header
			$this->load->view("view_message", $data); 				//displays the home page
			$this->load->view("footer"); 					//displays the footer
			return;
		}
		else if($banned == 2){
			$data['titlepage']="UPLB OSA GTracer - Account Deleted";
			$data['header']="Status: Account Deleted";
			$data['body']="Your account was deleted. If you think this is an error, please contact any system administrator.<br><a href='".base_url()."controller_login'>Return to login page</a>";
			$this->load->view("header", $data); 					//displays the header
			$this->load->view("view_message", $data); 				//displays the home page
			$this->load->view("footer"); 					//displays the footer
			return;
		}

		// Store values in variables from project created in Google Developer Console
		$client_id = '*****';
		$client_secret = '*****';
		$redirect_uri = 'http://127.0.0.1/GTracer/controller_login';
		$simple_api_key = '*****';

		// Create Client Request to access Google API
		try{
			$client = new Google_Client();
			$client->setApplicationName("GTracer");
			$client->setClientId($client_id);
			$client->setClientSecret($client_secret);
			$client->setRedirectUri($redirect_uri);
			$client->setDeveloperKey($simple_api_key);
			$client->addScope("profile");
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			// $client->setHostedDomain("uplbosa.org");
			// $client->setHostedDomain("cia.uplbosa.org");

			// Send Client Request
			$objOAuthService = new Google_Service_Oauth2($client);

			// Add Access Token to Session
			if (isset($_GET['code'])) {
				$client->authenticate($_GET['code']);
				$this->session->set_userdata('access_token', $client->getAccessToken());
				// header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			}

			if ($this->session->userdata('access_token')) {
				$client->setAccessToken($this->session->userdata('access_token'));
			}

			// Get User Data from Google and store them in $data
			if ($client->getAccessToken()) {
					// $this->session->unset_userdata('logged_in');
		 		// $this->session->sess_destroy();
		 		// redirect('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'controller_login/index/0', 'refresh');
				$userinfo = $objOAuthService->userinfo->get();
				$data['userinfo'] = $userinfo;
				$this->session->set_userdata('access_token', $client->getAccessToken());

				// check if user is already in the database
				$eno=$this->get_eno($userinfo->email);
				if($this->check_email($userinfo->email)){	// existing on database
					$this->login($eno, $userinfo->email, $this->is_admin($eno));		// if already on database, redirect to home 
				}
				else{										// if not on database
 		// redirect('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'controller_login/index/0', 'refresh');
					$data['titlepage'] = "UPLB OSA GTracer - Edit User Information"; //title page 
					$this->load->view("header", $data); 						//displays the header
					$this->load->view("view_reg_edit_info", $data); 			//displays the home page
					$this->load->view("footer"); 						//displays the footer 
				}
			} 
			else {		// main login page
				$authUrl = $client->createAuthUrl();
				$data['authUrl'] = $authUrl;

				$data['titlepage'] = "UPLB OSA GTracer - Home"; 		//title page  
				$this->load->view("header", $data); 					//displays the header
				$this->load->view("view_login", $data); 				//displays the home page
				$this->load->view("footer"); 					//displays the footer
			}
		} catch(Google_Auth_Exception $e){
			$data['header']="Google Login Error";
			$data['body']="Try to login again.<br><a href='".base_url()."controller_login/index'>Return to Login page</a>";
			$this->add_log($eno, 'Log in', 'Employee '.$eno.' attempted to log in (Status: Banned).');
			$this->load->view("header", $data); 					//displays the header
			$this->load->view("view_message", $data); 				//displays the home page
			$this->load->view("footer"); 					//displays the footer
		} catch(Google_IO_Exception $con_err){
			$data['header']="Connection error";
			$data['body']="Check your internet connection then try to login again.<br><a href='".base_url()."controller_login/index'>Return to Login page</a>";
			$this->add_log($eno, 'Log in', 'Employee '.$eno.' attempted to log in (Status: Banned).');
			$this->load->view("header", $data); 					//displays the header
			$this->load->view("view_message", $data); 				//displays the home page
			$this->load->view("footer"); 
		}
	}

	public function edit_info_form(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('eno', 'Employee Number', 'trim|required|xss_clean|callback_eno_check');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean|ucwords|callback_fname_check');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean|ucwords|callback_lname_check');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|xss_clean|callback_email_check');

		$this->form_validation->set_message('eno', 'Must be 9 numeric characters!');

		$data['eno'] = $this->input->post('eno');
		$data['fname'] = $this->input->post('fname');
		$data['lname'] = $this->input->post('lname');
		$data['email'] = $this->input->post('email');

		if (! $this->form_validation->run())
		{
			$data['msg'] = validation_errors();
			$this->load->view("header", $data); 				//displays the header
			$this->load->view("view_reg_edit_info", $data); 	//displays the home page
			$this->load->view("footer");
		}
		else
		{
			$this->model_user->add_user($data);						// Save data to database
			$this->login($data['eno'], $data['email'], 0);								// Log in user 
		}
	} 

	function eno_check($str){
		return(! preg_match("/^[0-9]{9}$/i", $str))? FALSE: TRUE;
	}

	function fname_check($str){
		return(! preg_match("/^[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*\.?((\.\s[A-Za-zñÑ]{2}[A-Za-zñÑ\s]*\.?)|(\s[A-Za-zñÑ][A-Za-zñÑ]{1,2}\.)|(-[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*))*$/i", $str))? FALSE: TRUE;
	}

	function lname_check($str){
		return(! preg_match("/^([A-Za-zñÑ]){1}([A-Za-zñÑ]){1,}(\s([A-Za-zñÑ]){1,})*(\-([A-Za-zñÑ]){1,}){0,1}$/i", $str))? FALSE: TRUE;
	}

// EDIT
	function email_check($str){
		return(! preg_match("/^[A-Za-z][A-Za-z-0-9\._]{3,20}@gmail.com$/i", $str))? FALSE: TRUE;
	}

	function check_email($email){
		return $this->model_user->check_email($email);
	}

	function get_eno($email){
		return $this->model_user->get_eno($email);
	}

	function is_admin($eno){
		return $this->model_user->is_admin($eno);			//returns true or false
	}

	function is_banned($eno){
		return $this->model_user->is_banned($eno);		//returns true or false
	}

	function is_deleted($eno){
		return $this->model_user->is_deleted($eno);		//returns true or false
	}

	function eno_available($eno){
		if(! $this->model_user->exists($eno)){
			echo "Employee Number is available.";
		}
		else echo "Employee Number is not available.";
		return;
	}

	function login($eno, $email, $is_admin){
		$is_banned=$this->is_banned($eno);
		$is_deleted=$this->is_deleted($eno);
		$sess_array = array('eno' => $eno, 'is_admin' => $is_admin, 'is_banned' => $is_banned);
		//set session with value from database
		$this->session->set_userdata('logged_in', $sess_array);

		if($is_banned){
			$this->add_log($eno, 'Log in', 'Employee '.$eno.' attempted to log in (Status: Banned).');
			$eno=$this->session->userdata('logged_in')['eno'];
			$this->add_log($eno, 'Log out', 'Employee '.$eno.' was forced to log out  (Status: Banned).');
	 		$this->session->unset_userdata('logged_in');
	 		$this->session->sess_destroy();
	 		redirect('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'controller_login/index/1', 'refresh');
		}
		else if($is_deleted){
			$this->add_log($eno, 'Log in', 'Employee '.$eno.' attempted to log in (Status: Account Deleted).');
			$eno=$this->session->userdata('logged_in')['eno'];
			$this->add_log($eno, 'Log out', 'Employee '.$eno.' was forced to log out  (Status: Account Deleted).');
	 		$this->session->unset_userdata('logged_in');
	 		$this->session->sess_destroy();
	 		redirect('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'controller_login/index/2', 'refresh');
		}
		else{
			$this->add_log($eno, 'Log in', 'Employee '.$eno.' logged in.');
			redirect('controller_list_alumni', 'refresh');
		}
	}

	function logout() {
 	 	//remove all session data
		$eno=$this->session->userdata('logged_in')['eno'];
		$this->add_log($eno, 'Log out', 'Employee '.$eno.' log out.');
 		$this->session->unset_userdata('logged_in');
 		$this->session->sess_destroy();
 		redirect('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'controller_login/index/0', 'refresh');
	}
}
?>