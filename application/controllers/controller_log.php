<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Controller_log
		- controller used in saving the transactions made by the staff
		- extended by other classes to be able to use functionalities such as add_log
*/
class Controller_log extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Jquery_pagination');
		$this->load->library('pagination');
		$this->load->model('model_logs');
	}

	// view all logs -- if parameter is not false, logs of specific user will be viewed
	function index($empno = FALSE){		
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to login page
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

	// get all users' logs
	public function get_log_data($string){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to login page
		}
		if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_log', 'refresh');// redirect to login page
		}

		$result['logs']=$this->model_logs->get_activity();
		if(! $result['logs']){
			$data['no_logs']=1;
		}
		else{
			if($this->session->userdata('logged_in') == FALSE){
				redirect('controller_login', 'refresh');// redirect to login page
			}

			$string=explode("_", $string);
			$sort_by = addslashes($string[0]); 
			$order_by = addslashes($string[1]); 

			//configuration of the ajax pagination  library.
			$config['base_url'] = base_url().'controller_log/get_log_data';
			$config['total_rows'] = $config['total_rows'] = $this->model_logs->get_log_count();
			$config['per_page'] = '20';
			$config['div'] = '#change_here';

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			//fetches data from database.
			$data['result'] = $this->model_logs->get_logs_paginate($config['per_page'], $page, $sort_by, $order_by);
			//display data from database
			
			//initialize the configuration of the ajax_pagination
			$this->jquery_pagination->initialize($config);
			//create links for pagination
			$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
			// var_dump($data['links']);
		}
		$this->print_logs($sort_by, $order_by, $data);
	}
	
	// view logs of specific user -- called from users page
	public function spec_user($string){		
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to login page
		}
		if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_list_alumni', 'refresh');// redirect to login page
		}

		$empno = $this->input->post('emp_no');
		$string=explode("_", $string);
		$sort_by = addslashes($string[0]); 
		$order_by = addslashes($string[1]); 
		$empno = addslashes($string[2]); 

		$result['logs']=$this->model_logs->get_logs_paginate(10, 0, $sort_by, $order_by, $empno);
		if(! $result['logs']){
			$data['no_logs']=1;
		}
		else{
			//configuration of the ajax pagination  library.
			$config['base_url'] = base_url().'controller_log/spec_user';
			$config['total_rows'] = $config['total_rows'] = $this->model_logs->get_log_count($empno);
			$config['per_page'] = '20';
			$config['div'] = '#change_here';

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			// fetches data from database.
			$data['result'] = $this->model_logs->get_logs_paginate($config['per_page'], $page, $sort_by, $order_by, $empno);
			//display data from database
			
			//initialize the configuration of the ajax_pagination
			$this->jquery_pagination->initialize($config);
			//create links for pagination
			$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
			// var_dump($data['links']);
		}
		$this->print_logs($sort_by, $order_by, $data);
	}

	public function print_logs($sort_by, $order_by, $data){
		if(isset($data['no_logs'])){
			echo "<h5 class='no-content'>No logs.<h5>";
		}
		else{
			echo $data['links'];
			echo "<table class='table table-hover table-bordered'>";
			// set table headers
			// onclick set for sorting data by column
			if($sort_by=="empno"){
				if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('empno','desc');>Employee Number<span class='caretdown'></span></a></th>";
				else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('empno','asc');>Employee Number<span class='caretup'></span></a></th>";
			}
			else echo "<th><a href='javascript:void(0);' onclick=get_data('empno','desc');>Employee Number<span class='caretdown'></span></a></th>";

			if($sort_by=="activity"){
				if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('activity','desc');>Activity<span class='caretdown'></span></a></th>";
				else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('activity','asc');>Activity<span class='caretup'></span></a></th>";
			}
			else echo "<th><a href='javascript:void(0);' onclick=get_data('activity','desc');>Activity<span class='caretdown'></span></a></th>";

			if($sort_by=="actdetails"){
				if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('actdetails','desc');>Activity Details<span class='caretdown'></span></a></th>";
				else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('actdetails','asc');>Activity Details<span class='caretup'></span></a></th>";
			}
			else echo "<th><a href='javascript:void(0);' onclick=get_data('actdetails','desc');>Activity Details<span class='caretdown'></span></a></th>";

			if($sort_by=="timeperformed"){
				if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('timeperformed','desc');>Time<span class='caretdown'></span></a></th>";
				else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('timeperformed','asc');>Time<span class='caretup'></span></a></th>";
			}
			else echo "<th><a href='javascript:void(0);' onclick=get_data('timeperformed','desc');>Time<span class='caretdown'></span></a></th>";

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

	// used by other classes to log activities made by the staff
	function add_log($empno, $activity, $actdetails){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to login page
		}
		$this->model_logs->add_log($empno, $activity, $actdetails);
	}

	// used to get country from the database
	function get_country(){
		return $this->model_logs->get_country();
	}

	function get_data($loadid){
		$array['result']=$this->model_logs->get_data($loadid);
		echo json_encode($array);
	}

}
/* End of file controller_log.php */
/* Location: ./application/controllers/controller_log.php */
?>
