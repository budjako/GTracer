<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once("controller_log.php");
/*
	Controller_school
		- controller used in viewing the details of a school
		- school details can be edited with the help of this controller
		- if a school is not yet approved, the user can use the merge function if the entry for that school already exists.
		- if a school is merged with an existing school, the previous details of the existing school will be used instead of the new one
*/
class Controller_school extends Controller_log {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_school');
	}

	function index($string) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');									// redirect to login page
		}
		
		$data['info'] = $this->model_school->get_school_data($string);
		$data['list']=$this->get_country();
		$data['is_approved']=$this->model_school->is_approved($string);

		$data['titlepage'] = "UPLB OSA GTracer - School Page"; 							//title page 

		// var_dump($data['list']);
		$this->load->view("header", $data); 											//displays the header
		$this->load->view("navigation");
		$this->load->view("view_school_page", $data); 									//displays the home page
		$this->load->view("footer"); 													//displays the footer
	}

	public function get_school_data($string){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');									// redirect to login page
		}

		$string=explode("_", $string);
		$sort_by = addslashes($string[0]); 
		$order_by = addslashes($string[1]); 

		//configuration of the ajax pagination  library.
		$config['base_url'] = base_url().'controller_school/get_school_data';
		$config['total_rows'] = $config['total_rows'] = $this->model_school->get_school_approved_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here';


		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		//fetches data from database.
		$data['result'] = $this->model_school->get_school_approved_paginate($config['per_page'], $page, $sort_by, $order_by);
		//display data from database
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
		// var_dump($data['links']);
		$this->print_school($sort_by, $order_by, $data['result'],$data['links']);
	   
	}

	// print data from db
	public function print_school($sort_by, $order_by, $result, $links){
		echo $links;
		echo "<table class='table table-hover table-bordered'>";
		if($sort_by=="schoolname"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('schoolname','desc');>Name<span class='caretdown'></span></a></th>";
			else echo "<th><a href='javascript:void(0);' onclick=get_data('schoolname','asc');>Name<span class='caretup'></span></a></th>";
		}
		else if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('schoolname','desc');>Name<span class='caretup'></span></a></th>";

		if($sort_by=="saddcountry"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddcountry','desc');>Country<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddcountry','asc');>Country<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('saddcountry','desc');>Country<span class='caretdown'></span></a></th>";

		if($sort_by=="saddregion"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddregion','desc');>Region<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddregion','asc');>Region<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('saddregion','desc');>Region<span class='caretdown'></span></a></th>";

		if($sort_by=="saddprovince"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddprovince','desc');>Province<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('saddprovince','asc');>Province<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('saddprovince','desc');>Province<span class='caretdown'></span></a></th>";

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

	// merge new school entry from existing school entry
	public function merge_school($string){
		$tokens=explode("_", $string);
		$origentry=$tokens[0];
		$schoolmerge=$tokens[1];

		$origentryname=$this->model_school->get_school_name($origentry);			// school name of existing school
		$schoolmergename=$this->model_school->get_school_name($schoolmerge);		// school name of current school

		$this->model_school->edit_school($origentry, $schoolmerge);					// merge new entry to existing school entry
		$empno=$this->session->userdata('logged_in')['eno'];
		// add log of transaction
		$this->add_log($empno, "Merged school entry", "Employee ".$empno." merged ".$origentryname." with ".$schoolmergename.".");
	}
	
}  
