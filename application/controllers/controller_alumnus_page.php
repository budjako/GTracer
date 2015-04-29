<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller_alumnus_page extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_alumni');
	}

	function index($stdno) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');// redirect to controller_search_book
		}
		 
		//get data needed
		$data['info'] = $this->model_alumni->get_data($stdno);

		$data['titlepage'] = "UPLB OSA GTracer - Alumnus' Page"; //title page 

		$this->load->view("header", $data); //displays the header
		$this->load->view("navigation");
		$this->load->view("view_alumnus_page", $data); //displays the home page
		$this->load->view("footer"); //displays the footer
	}
}  
