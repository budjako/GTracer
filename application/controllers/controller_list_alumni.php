<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller_list_alumni extends CI_Controller {  
	function __construct(){
		parent::__construct();
		$this->load->library('Jquery_pagination');
		$this->load->model('model_list_alumni');
		$this->load->library('pagination');
	}

	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');
		}
		$data['titlepage'] = "UPLB OSA GTracer - View List of Alumni"; //title page

		$this->load->helper(array('form','html'));

		$this->load->view("header",$data);
		$this->load->view("navigation");
		$this->load->view("view_list_alumni");
		$this->load->view("footer");

	}

	public function get_alumni_data(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		$this->input->post('serialised_form');
		$sort_by = addslashes($this->input->post('sort_by')); 
		$order_by = addslashes($this->input->post('order_by')); 
		// echo "sort: ".$sort_by."<br>";
		// echo "order: ".$order_by."<br>";

		//configuration of the ajax pagination  library.
		$config['base_url'] = base_url().'controller_list_alumni/get_alumni_data';
		$config['total_rows'] = $config['total_rows'] = $this->model_list_alumni->get_alumni_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here';
		$config['additional_param']  = 'serialize_form()';


		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		//fetches data from database.
		$data['result'] = $this->model_list_alumni->get_alumni_paginate($config['per_page'], $page, $sort_by, $order_by);
		//display data from database
		
		ini_set('xdebug.var_display_max_depth', 10);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links();
		// var_dump($data['links']);
		$this->print_alumni($data['result'],$data['links']);
	   
	}

	public function print_alumni($result, $links){
		echo $links;
		echo "<table class='table table-hover table-bordered'>";
		echo "<th>Student Number</th>";
		echo "<th>Last Name</th>";
		echo "<th>First Name</th>";
		echo "<th>Middle Name</th>";
		echo "<th>Email Address</th>";
		foreach ($result as $row){
			echo "<tr id='".$row->student_no."' class='clickable-row' data-href='".base_url()."controller_alumni/index/".$row->student_no."'><td>".$row->student_no."</td>";
			echo "<td>".$row->lastname."</td>";
			echo "<td>".$row->firstname."</td>";
			echo "<td>".$row->midname."</td>";
			echo "<td>".$row->email."</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}
	
	
	function export_logs(){
		$this->load->dbutil();
		$this->load->helper('download');

		$query = $this->db->query("SELECT * FROM log");
		// var_dump($query->result_array());

		$fp = fopen('php://output', 'w');
		fputcsv($fp, array('Log Number', 'Employee Number', 'Activity', 'Details', 'Time'));
		fputcsv($fp, array('Note: Pad employee numbers with zeroes'));
		foreach ($query->result_array() as $fields) {
			// var_dump( $fields );
			fputcsv($fp, $fields);
		}

		$data = file_get_contents('php://output'); 
		$name = 'logs.csv';

		// Build the headers to push out the file properly.
		header('Pragma: public');     // required
		header('Expires: 0');         // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		exit();

		force_download($name, $data);
		fclose($fp);
	}
}  
