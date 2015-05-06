<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controller_log extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Jquery_pagination');
		$this->load->library('pagination');
		$this->load->model('model_logs');
	}

	function index($empno = FALSE){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		else if(! $this->session->userdata('logged_in')['is_admin']){
			$data['titlepage'] = "UPLB OSA GTracer - Insufficient Privilege"; //title page
			$data['header'] = "Insufficient Privileges";
			$data['body'] = "You have insufficient privileges. If you think this is an error, please contact the administrator.";
			$this->load->view("header", $data);
			$this->load->view("navigation");
			$this->load->view("view_message", $data);
			$this->load->view("footer");
		}
		else{
			$data['titlepage'] = "UPLB OSA GTracer - Logs"; //title page

			if($empno) $data['empno'] = $empno;
			$this->load->helper(array('form','html'));

			$this->load->view("header", $data);
			$this->load->view("navigation");
			$this->load->view("view_log", $data);
			$this->load->view("footer");
		}
	}

	public function get_log_data(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_log', 'refresh');// redirect to controller_search_book
		}

		$result['logs']=$this->model_logs->get_activity();
		if(! $result['logs']){
			$data['no_logs']=1;
		}
		else{
			if($this->session->userdata('logged_in') == FALSE){
				redirect('controller_login', 'refresh');// redirect to controller_search_book
			}

			$this->input->post('serialised_form');
			$sort_by = addslashes($this->input->post('sort_by')); 
			$order_by = addslashes($this->input->post('order_by')); 
			// echo "sort: ".$sort_by."<br>";
			// echo "order: ".$order_by."<br>";

			//configuration of the ajax pagination  library.
			$config['base_url'] = base_url().'controller_log/get_log_data';
			$config['total_rows'] = $config['total_rows'] = $this->model_logs->get_log_count();
			$config['per_page'] = '20';
			$config['div'] = '#change_here';
			$config['additional_param']  = 'serialize_form()';


			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			//fetches data from database.
			$data['result'] = $this->model_logs->get_logs_paginate($config['per_page'], $page, $sort_by, $order_by);
			//display data from database
			
			//initialize the configuration of the ajax_pagination
			$this->jquery_pagination->initialize($config);
			//create links for pagination
			$data['links'] = $this->jquery_pagination->create_links();
			// var_dump($data['links']);
		}
		$this->print_logs($data);
	}
	
	public function spec_user($empno = FALSE){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_list_alumni', 'refresh');// redirect to controller_search_book
		}

		$this->input->post('serialised_form');
		$empno = $this->input->post('emp_no');
		$sort_by = addslashes($this->input->post('sort_by')); 
		$order_by = addslashes($this->input->post('order_by')); 

		$result['logs']=$this->model_logs->get_activity($empno);
		if(! $result['logs']){
			$data['no_logs']=1;
		}
		else{
			//configuration of the ajax pagination  library.
			$config['base_url'] = base_url().'controller_log/spec_user';
			$config['total_rows'] = $config['total_rows'] = $this->model_logs->get_log_count($empno);
			$config['per_page'] = '20';
			$config['div'] = '#change_here';
			$config['additional_param']  = 'serialize_form()';

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			// fetches data from database.
			$data['result'] = $this->model_logs->get_logs_paginate($config['per_page'], $page, $sort_by, $order_by, $empno);
			//display data from database
			
			//initialize the configuration of the ajax_pagination
			$this->jquery_pagination->initialize($config);
			//create links for pagination
			$data['links'] = $this->jquery_pagination->create_links();
			// var_dump($data['links']);
		}
		$this->print_logs($data);
	}

	public function print_logs($data){
		if(isset($data['no_logs'])){
			echo "<h5 class='no-content'>No logs.<h5>";
		}
		else{
			echo $data['links'];
			echo "<table class='table table-hover table-bordered'>";
			echo "<th>Employee Number</th>";
			echo "<th>Activity</th>";
			echo "<th>Details</th>";
			echo "<th>Time</th>";
			foreach ($data['result'] as $row){
			    echo "<tr><td>".$row->empno."</td>";
				echo "<td>".$row->activity."</td>";
				echo "<td>".$row->actdetails."</td>";
				echo "<td>".$row->timeperformed."</td></tr>";

			} 
			echo "</table>";
			echo $data['links'];
		}
	}

	/* This function only shows the log for the current day. */
	function today(){
		if($this->model_check_session->check_admin_session() == TRUE){	
			$today = date("Y-m-d");
			$this->load->model('model_log');
			$data['log'] = $this->model_log->get_log($today);
			$data['parent'] = "Admin";
			$data['current'] = "View Logs";
			
			$this->load->helper(array('form','html'));
			$this->load->view("view_header",$data);
			$this->load->view("view_aside");
			$this->load->view("view_log",$data);
			$this->load->view("view_footer");
		}
	}
	
	// sample: $this->add_log("Admin $session_user verified account of $account_number.", "Verify User Account");
	function add_log($empno, $activity, $actdetails){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		$this->model_logs->add_log($empno, $activity, $actdetails);
	}

}
/* End of file controller_log.php */
/* Location: ./application/controllers/controller_log.php */
?>
