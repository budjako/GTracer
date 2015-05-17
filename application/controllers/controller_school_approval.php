<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

include_once("controller_log.php");

class Controller_school_approval extends Controller_log {

	function __construct(){
		parent::__construct();
		$this->load->library('Jquery_pagination');
		$this->load->model('model_school_approval');
		$this->load->library('pagination');
	}

	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');
		}
		$data['titlepage'] = "UPLB OSA GTracer - School Entry Approval"; //title page

		$this->load->view("header",$data);
		$this->load->view("navigation");
		$this->load->view("view_school_approval");
		$this->load->view("footer");
	
	}

	public function get_school_requests(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}

		$config['base_url'] = base_url().'controller_school_approval/get_school_requests';
		$config['total_rows'] = $config['total_rows'] = $this->model_school_approval->get_approval_school_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here_school';

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		//fetches data from database.
		$data['result'] = $this->model_school_approval->get_approval_school($config['per_page'], $page);
		//display data from database
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links();
		// var_dump($data['links']);
		$this->print_school_requests($data['result'],$data['links']);

	}

	public function print_school_requests($result, $links){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}

		echo $links;
		echo "<table class='table table-hover table-bordered' >";
		echo "<th>Name</th>";
		echo "<th>Country</th>";
		echo "<th>Region</th>";
		echo "<th>Province</th>";
		echo "<th>Approve</th>";
		foreach ($result as $row){
			echo "<tr id='".$row['school_no']."' class='clickable-row' data-href='".base_url()."controller_single/index/school_".$row['school_no']."'><td>".$row['schoolname']."</td>";
			echo "<td>".$row['saddcountry']."</td>";
			echo "<td>".$row['saddregion']."</td>";
			echo "<td>".$row['saddprovince']."</td>";
			echo "<td>";
			echo "<form method='POST' class='".$row['school_no']."'>";
			echo "<input type='button' class='approve btn btn-default'";
			echo "value='Approve'>";
			echo "</form>";
			echo "</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}

	public function school_approve($school_no){
		$schoolname=$this->model_school_approval->approve_school($school_no);
		$empno=$this->session->userdata('logged_in')['eno'];
		$this->add_log($empno, "Approve school entry", "Employee ".$empno." approved the entry of school ".$schoolname.".");
		return;
	}

	function sname($str){
		if($str == "") return true;
		return(! preg_match("/^[A-Za-zñÑ\s][A-Za-zñÑ0-9\s]+$/i", $str))? FALSE: TRUE;
	}

	function country_check($str){
		if($str == "") return true;
		return(! preg_match("/^[A-Z]{2}$/i", $str))? FALSE: TRUE;
	}

	function state_check($str){
		if($str == "" || $str== "-1") return true;
		return(! preg_match("/^[A-Z]{2}[\-\_][A-Z0-9]{3}$/i", $str))? FALSE: TRUE;
	}

	public function edit_school(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('sname', 'School Name', 'trim|xss_clean|callback_sname');
		$this->form_validation->set_rules('country', 'Country', 'trim|xss_clean|ucwords|callback_country_check');
		$this->form_validation->set_rules('state', 'State', 'trim|xss_clean|ucwords|callback_state_check');

		$search['sno'] = $this->input->post('sno');
		$search['sname'] = $this->input->post('sname');
		$search['country'] = $this->input->post('country');
		$search['state'] = $this->input->post('state');

		if ($this->form_validation->run() === FALSE)
		{
			// echo "There are some problems";
			$search['msg'] = validation_errors();
			$data['titlepage'] = "UPLB OSA GTracer - School Details"; //title page

			$this->load->view("header",$search);
			$this->load->view("navigation");
			$this->load->view("view_school_approval", $search);
			$this->load->view("footer");
		}
		else
		{
			$this->model_school_approval->edit_school($search);
			redirect('controller_single/index/school_'.$search['sno'], 'refresh');	// redirect to controller_search_book
		}
	}

}