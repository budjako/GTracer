<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller_geocode_test extends CI_Controller {  
	function __construct(){
		parent::__construct();
		$this->load->model('model_geocode_test');
	}

	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');
		}
		$data['titlepage'] = "UPLB OSA GTracer - Map Results"; //title page

		//get data to plot from db
		$data['result']=$this->model_geocode_test->get_geocode_data();

		// $this->load->view("header",$data);
		// $this->load->view("navigation");
		// $this->load->view("view_geocode_test", $data);
		// $this->load->view("footer");
		$this->load->view("view_chart_map", $data);
	}
}
