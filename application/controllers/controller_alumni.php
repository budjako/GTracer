<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

include_once("controller_log.php");

class Controller_alumni extends CI_Controller {

	public function index($string) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');
		}

		$this->load->model('model_alumni');	
		$data['titlepage'] = "UPLB OSA GTracer - Alumnus Page"; //title page
		$data['info'] = $this->model_alumni->get_stud_data($string);

		$this->load->view("header",$data);
		$this->load->view("navigation");
		$this->load->view("view_alumnus_page", $data);
		$this->load->view("footer");
	
	}
}