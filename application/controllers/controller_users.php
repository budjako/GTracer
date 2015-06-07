<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

include_once("controller_log.php");

class Controller_users extends Controller_log {

	function __construct(){
        parent::__construct();
        $this->load->library('Jquery_pagination');
        $this->load->model('model_user');
        $this->load->library('pagination');
    }

	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');
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
			$data['titlepage'] = "UPLB OSA GTracer - Users"; //title page

	    	$this->load->helper(array('form','html'));

		    $this->load->view("header",$data);
		    $this->load->view("navigation");
		    $this->load->view("view_user");
		    $this->load->view("footer");
		}
	}

	public function get_users_data($string) {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}
		else if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_users/index', 'refresh');	// redirect to controller_search_book
		}

		$string=explode("_", $string);
		$sort_by = addslashes($string[0]); 
		if($sort_by=="empno") $sort_by="emp_no";
		$order_by = addslashes($string[1]); 

		//configuration of the ajax pagination  library.
		$config['base_url'] = base_url().'controller_users/get_users_data';
		$config['total_rows'] = $config['total_rows'] = $this->model_user->get_user_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here';

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		//fetches data from database.
		$data['result'] = $this->model_user->get_users_paginate($config['per_page'], $page, $sort_by, $order_by);
		//display data from database
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
		// var_dump($data['links']);
		$this->print_users($sort_by, $order_by, $data['result'],$data['links']);
	}

	public function print_users($sort_by, $order_by, $result, $links){
		$my_empno=$this->session->userdata('logged_in')['eno'];
		echo $links;
		echo "<table class='table table-hover table-bordered' >";

		if($sort_by=="empno"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('empno','desc');>Employee Number<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('empno','asc');>Employee Number<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('empno','desc');>Employee Number<span class='caretdown'></span></a></th>";

		if($sort_by=="name"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('name','desc');>Name<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('name','asc');>Name<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('name','desc');>Name<span class='caretdown'></span></a></th>";

		if($sort_by=="email"){
			if($order_by=="asc") echo "<th><a href='javascript:void(0);' onclick=get_data('email','desc');>Email Address<span class='caretdown'></span></a></th>";
			else if($order_by=="desc") echo "<th><a href='javascript:void(0);' onclick=get_data('email','asc');>Email Address<span class='caretup'></span></a></th>";
		}
		else echo "<th><a href='javascript:void(0);' onclick=get_data('email','desc');>Email Address<span class='caretdown'></span></a></th>";

		echo "<th>Active</th>";
		echo "<th>Set as Admin</th>";
		foreach ($result as $row){
			echo "<tr id='".$row->emp_no."' class='clickable-row' data-href='".base_url()."controller_log/index/".$row->emp_no."'><td>".$row->emp_no."</td>";
			echo "<td>".$row->name."</td>";
			echo "<td>".$row->email."</td><td>";
			if($row->admin == 0){
				echo "<form method='POST' class='".$row->emp_no."'>";
				echo "<input type='button' class='active btn btn-default'";
					if($row->active == 1) echo "value='Deactivate'>";
					else echo "value='Activate'>";
				echo "</form>";
			}
			echo "</td><td>";
			if($row->admin == 0){
				echo "<form method='POST' class='".$row->emp_no."'>
					<input type='button' class='admin btn btn-default' value='Add as Admin'>
				</form>";
			}
			echo "</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}


	public function delete_acct($empno){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}
		else if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_users/index', 'refresh');	// redirect to controller_search_book
		}

		if($this->model_user->exists($empno)){
			$this->model_user->delete($empno);
			$this->add_log($this->session->userdata('logged_in')['eno'], "Delete Staff Account", "Deleted account of employee ".$empno.".");
		}
		return;
	}

	public function active($empno){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}
		else if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_users/index', 'refresh');	// redirect to controller_search_book
		}
		// check if current logged in user is an admin
		if($this->model_user->exists($empno)){
			$active=$this->model_user->is_active($empno);
			if($active){			// currently active
				$this->model_user->active($empno, 0);
				$this->add_log($this->session->userdata('logged_in')['eno'], "Deactivated user", "Deactivated employee ".$empno."'s account.");
			}
			else{
				$this->model_user->active($empno, 1);
				$this->add_log($this->session->userdata('logged_in')['eno'], "Activated user", "Activated employee ".$empno."'s account.");
			}
		}
	}

	public function admin($empno){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}
		else if(! $this->session->userdata('logged_in')['is_admin']){
			redirect('controller_users/index', 'refresh');	// redirect to controller_search_book
		}
		if($this->model_user->exists($empno)){
			$admin=$this->model_user->is_admin($empno);
			if(! $admin){
				$this->model_user->add_admin($empno);
				$this->add_log($this->session->userdata('logged_in')['eno'], "Add as Admin", "Added employee ".$empno." as a system administrator.");
			}
		}
	}

}