<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once("controller_log.php");

class Controller_single extends Controller_log {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_single');
	}

	function index($string) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		
		$tokens=explode("_", $string);

		if($tokens[0] == "student"){
			$data['info'] = $this->model_single->get_stud_data($tokens[1]);

			$data['titlepage'] = "UPLB OSA GTracer - Alumnus' Page"; //title page 

			$this->load->view("header", $data); //displays the header
			$this->load->view("navigation");
			$this->load->view("view_alumnus_page", $data); //displays the home page
			$this->load->view("footer"); //displays the footer
		}
		else if($tokens[0] == "school"){
			$data['info'] = $this->model_single->get_school_data($tokens[1]);
			$data['list']=$this->get_country();

			$data['titlepage'] = "UPLB OSA GTracer - School Page"; //title page 

			// var_dump($data['list']);
			$this->load->view("header", $data); //displays the header
			$this->load->view("navigation");
			$this->load->view("view_school_page", $data); //displays the home page
			$this->load->view("footer"); //displays the footer
		}
		else if($tokens[0] == "company"){
			$data['info'] = $this->model_single->get_company_data($tokens[1]);
			$data['list']=$this->get_country();

			$data['titlepage'] = "UPLB OSA GTracer - Company Page"; //title page 

			$this->load->view("header", $data); //displays the header
			$this->load->view("navigation");
			$this->load->view("view_company_page", $data); //displays the home page
			$this->load->view("footer"); //displays the footer
		}
	}
}  
