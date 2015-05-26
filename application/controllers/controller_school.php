<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once("controller_log.php");

class Controller_school extends Controller_log {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_school');
	}

	function index($string) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		
		$data['info'] = $this->model_school->get_school_data($string);
		$data['list']=$this->get_country();
		$data['is_approved']=$this->model_school->is_approved($string);

		$data['titlepage'] = "UPLB OSA GTracer - School Page"; //title page 

		// var_dump($data['list']);
		$this->load->view("header", $data); //displays the header
		$this->load->view("navigation");
		$this->load->view("view_school_page", $data); //displays the home page
		$this->load->view("footer"); //displays the footer
	}

	public function get_school_data(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		$this->input->post('serialised_form');
		$sort_by = addslashes($this->input->post('sort_by')); 
		$order_by = addslashes($this->input->post('order_by')); 
		// echo "sort: ".$sort_by."<br>";
		// echo "order: ".$order_by."<br>";

		//configuration of the ajax pagination  library.
		$config['base_url'] = base_url().'controller_school/get_school_data';
		$config['total_rows'] = $config['total_rows'] = $this->model_school->get_school_approved_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here';
		$config['additional_param']  = 'serialize_form()';


		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		//fetches data from database.
		$data['result'] = $this->model_school->get_school_approved_paginate($config['per_page'], $page, $sort_by, $order_by);
		//display data from database
		
		ini_set('xdebug.var_display_max_depth', 10);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links();
		// var_dump($data['links']);
		$this->print_school($data['result'],$data['links']);
	   
	}

	public function print_school($result, $links){
		echo $links;
		echo "<table class='table table-hover table-bordered'>";
		echo "<th>School Name</th>";
		echo "<th>Country</th>";
		echo "<th>Region</th>";
		echo "<th>Province</th>";
		echo "<th>Merge</th>";
		foreach ($result as $row){
			echo "<tr id='".$row->school_no."' class='clickable-row' data-href='".base_url()."controller_school/index/".$row->school_no."'>";
			echo "<td>".$row->schoolname."</td>";
			echo "<td>".$row->saddcountry."</td>";
			echo "<td>".$row->saddregion."</td>";
			echo "<td>".$row->saddprovince."</td>";
			echo "<td>";
			echo "<form method='POST' class='".$row->school_no."'>";
			echo "<input type='button' class='schoolmerge btn btn-default'";
			echo "value='Merge'>";
			echo "</form>";
			echo "</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}

	public function merge_school($string){
		$tokens=explode("_", $string);
		$origentry=$tokens[0];
		$schoolmerge=$tokens[1];

		$origentryname=$this->model_school->get_school_name($origentry);
		$schoolmergename=$this->model_school->get_school_name($schoolmerge);

		$this->model_school->edit_school($origentry, $schoolmerge);
		$empno=$this->session->userdata('logged_in')['eno'];
		$this->add_log($empno, "Merged school entry", "Employee ".$empno." merged ".$origentryname." with ".$schoolmergename.".");
	}
	
}  