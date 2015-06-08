<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Controller_alumni
		- controller used in viewing the profile of an alumni
*/

include_once("controller_log.php");

class Controller_alumni extends CI_Controller {

	public function index($string) {
		if($this->session->userdata('logged_in') == FALSE){					// check if the user is logged in
			redirect('controller_login/index', 'refresh');					// if not, redirect to login page
		}

		$this->load->model('model_alumni');	
		$data['titlepage'] = "UPLB OSA GTracer - Alumnus Page";				// title page
		$data['info'] = $this->model_alumni->get_stud_data($string);		// gets student data from the database

		$this->load->view("header",$data);									// show the page
		$this->load->view("navigation");
		$this->load->view("view_alumnus_page", $data);
		$this->load->view("footer");
	
	}
}