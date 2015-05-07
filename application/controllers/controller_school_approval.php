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
		echo "<th>Address</th>";
		echo "<th>View/Edit</th>";		// view -> edit values 
		echo "<th>Approve</th>";
		foreach ($result as $row){
			echo "<tr id='".$row['school_no']."' class='clickable-row' data-href='".base_url()."controller_single/index/school_".$row['school_no']."'><td>".$row['schoolname']."</td>";
			echo "<td>".$row['schooladdress']."</td>";
			echo "<td>";
			echo "<form method='POST' class='".$row['school_no']."'>";
			echo "<input type='button' class='view btn btn-default'";
			echo "value='View/Edit Info'>";
			echo "</form>";
			echo "</td><td>";
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

}