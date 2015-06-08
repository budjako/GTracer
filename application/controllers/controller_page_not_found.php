<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Controller_page_not_found
		- page shown when url entered is not valid.
*/

class Controller_page_not_found extends CI_Controller{
	
	function index(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to login page
		}
	
		$data['titlepage'] = "UPLB OSA GTracer - Page not found"; //title page

		$data['header'] = "Error 404 - Page not found";
		$data['body'] = "The page you are looking for does not exist. Please check if the URL you entered is correct.";
		$this->load->view("header", $data);
		$this->load->view("navigation");
		$this->load->view("view_message", $data);
		$this->load->view("footer");
	}
}
/* End of file controller_page_not_found.php */
/* Location: ./application/controllers/controller_page_not_found.php */
?>
