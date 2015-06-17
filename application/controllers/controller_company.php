<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once("controller_log.php");
/*
	Controller_company
		- controller used in viewing the details of a company
		- Company details can be edited with the help of this controller
		- if a company is not yet approved, the user can use the merge function if the entry for that company already exists.
		- if a company is merged with an existing company, the previous details of the existing company will be used instead of the new one
*/
class Controller_company extends Controller_log {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_company');
	}

	function index($string) {
		if($this->session->userdata('logged_in') == FALSE){						// check if the user is logged in
			redirect('controller_login', 'refresh');							// if not, redirect to login page
		}
		
		$data['info'] = $this->model_company->get_company_data($string);
		$data['list']=$this->get_country();
		$data['is_approved']=$this->model_company->is_approved($string);

		$data['titlepage'] = "UPLB OSA GTracer - Company Page"; 

		$this->load->view("header", $data);										//displays the header
		$this->load->view("navigation");
		$this->load->view("view_company_page", $data); 							//displays the home page
		$this->load->view("footer"); 											//displays the footer
	}

	public function get_company_data($string){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');							
		}
		$string=explode("_", $string);
		$sort_by = addslashes($string[0]); 
		$order_by = addslashes($string[1]); 

		//configuration of the jquery pagination library.
		$config['base_url'] = base_url().'controller_company/get_company_data';
		$config['total_rows'] = $config['total_rows'] = $this->model_company->get_company_approved_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here';

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		//fetches data from database.
		$data['result'] = $this->model_company->get_company_approved_paginate($config['per_page'], $page, $sort_by, $order_by);
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
		$this->print_company($sort_by, $order_by, $data['result'],$data['links']);
	   
	}

	public function print_company($sort_by, $order_by, $result, $links){								//display data from database
		echo $links;
		echo "<table class='table table-hover table-bordered'>";
		if($sort_by=="companyname"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('companyname','desc');>Name<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('companyname','asc');>Name<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('companyname','desc');>Name<span class='caretup'></span></a></th>";

		if($sort_by=="caddcountry"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddcountry','desc');>Country<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddcountry','asc');>Country<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('caddcountry','desc');>Country<span class='caretdown'></span></a></th>";

		if($sort_by=="caddregion"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddregion','desc');>Region<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddregion','asc');>Region<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('caddregion','desc');>Region<span class='caretdown'></span></a></th>";

		if($sort_by=="caddprovince"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddprovince','desc');>Province<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('caddprovince','asc');>Province<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('caddprovince','desc');>Province<span class='caretdown'></span></a></th>";

		if($sort_by=="companytype"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('companytype','desc');>Type<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('companytype','asc');>Type<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('companytype','desc');>Type<span class='caretdown'></span></a></th>";

		echo "<th>Merge</th>";
		foreach ($result as $row){
			echo "<tr id='".$row->company_no."' class='clickable-row' data-href='".base_url()."controller_company/index/".$row->company_no."'>";
			echo "<td>".$row->companyname."</td>";
			echo "<td>".$row->caddcountry."</td>";
			echo "<td>".$row->caddregion."</td>";
			echo "<td>".$row->caddprovince."</td>";
			if($row->companytype == 0) echo "<td>Private</td>";					// 0 means that the company type is private
			else if($row->companytype == 1) echo "<td>Government</td>";			// while if its value is 1 it means that it is a government type 
			echo "<td>";
			echo "<form method='POST' class='".$row->company_no."'>";
			echo "<input type='button' class='companymerge btn btn-default'";
			echo "value='Merge'>";
			echo "</form>";
			echo "</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}

	public function merge_company($string){									// merge new company entry to existing entry
		$tokens=explode("_", $string);
		$origentry=$tokens[0];
		$companymerge=$tokens[1];

		$origentryname=$this->model_company->get_company_name($origentry);	// company name of existing entry
		$companymergename=$this->model_company->get_company_name($companymerge);	// company name of new entry

		$this->model_company->edit_company($origentry, $companymerge);		// merging
		$empno=$this->session->userdata('logged_in')['eno'];
		// add log for activity
		$this->add_log($empno, "Merged company entry", "Employee ".$empno." merged ".$origentryname." with ".$companymergename.".");
	}
	
}  
