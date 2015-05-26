<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

include_once("controller_log.php");

class Controller_company_approval extends Controller_log {

	function __construct(){
        parent::__construct();
        $this->load->library('Jquery_pagination');
        $this->load->model('model_company_approval');
        $this->load->library('pagination');
    }

	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');
		}
		$data['titlepage'] = "UPLB OSA GTracer - Company Entry Approval"; //title page

	    $this->load->view("header",$data);
	    $this->load->view("navigation");
	    $this->load->view("view_company_approval");
	    $this->load->view("footer");
	
	}

	public function get_company_requests(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}

		$config['base_url'] = base_url().'controller_company_approval/get_company_requests';
		$config['total_rows'] = $config['total_rows'] = $this->model_company_approval->get_approval_company_count();
		$config['per_page'] = '20';
		$config['div'] = '#change_here_company';

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		//fetches data from database.
		$data['result'] = $this->model_company_approval->get_approval_company($config['per_page'], $page);
		//display data from database
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links();
		// var_dump($data['links']);
		$this->print_company_requests($data['result'],$data['links']);
	}

	public function print_company_requests($result, $links){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login/index', 'refresh');	// redirect to controller_search_book
		}

		echo $links;
		echo "<table class='table table-hover table-bordered' >";
		echo "<th>Name</th>";
		echo "<th>Country</th>";
		echo "<th>Region</th>";
		echo "<th>Province</th>";
		echo "<th>Type</th>";
		echo "<th>Approve</th>";
		foreach ($result as $row){
			echo "<tr id='".$row['company_no']."' class='clickable-row' data-href='".base_url()."controller_company/index/".$row['company_no']."'><td>".$row['companyname']."</td>";
			echo "<td>".$row['caddcountry']."</td>";
			echo "<td>".$row['caddregion']."</td>";
			echo "<td>".$row['caddprovince']."</td>";
			echo "<td>";
				if($row['companytype'] == 0){
					echo "Private/Self-Employed";
				}
				else echo "Government";
			echo "</td>";
			echo "<td>";
			echo "<form method='POST' class='".$row['company_no']."'>";
			echo "<input type='button' class='approve btn btn-default'";
			echo "value='Approve'>";
			echo "</form>";
			echo "</td></tr>";
		} 
		echo "</table>";
		echo $links;
	}

	public function company_approve($company_no){
		$companyname=$this->model_company_approval->approve_company($company_no);
		$empno=$this->session->userdata('logged_in')['eno'];
		$this->add_log($empno, "Approve company entry", "Employee ".$empno." approved the entry of company ".$companyname.".");
		return;
	}

	function cname($str){
		if($str == "") return true;
		return(! preg_match("/^[A-Za-zñÑ\s][A-Za-zñÑ0-9\s]+$/i", $str))? FALSE: TRUE;
	}

	function ctype($str){
		if($str == "") return true;
		return(! preg_match("/^[01]$/i", $str))? FALSE: TRUE;
	}

	function country_check($str){
		if($str == "") return true;
		return(! preg_match("/^[A-Z]{2}$/i", $str))? FALSE: TRUE;
	}

	function state_check($str){
		if($str == "" || $str== "-1") return true;
		return(! preg_match("/^[A-Z]{2}[\-\_][A-Z0-9]{3}$/i", $str))? FALSE: TRUE;
	}

	public function edit_company(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cname', 'Company Name', 'trim|xss_clean|callback_cname');
		$this->form_validation->set_rules('ctype', 'Company Type', 'trim|xss_clean|callback_ctype');
		$this->form_validation->set_rules('country', 'Country', 'trim|xss_clean|ucwords|callback_country_check');
		$this->form_validation->set_rules('state', 'State', 'trim|xss_clean|ucwords|callback_state_check');

		$search['cno'] = $this->input->post('cno');
		$search['ctype'] = $this->input->post('ctype');
		$search['cname'] = $this->input->post('cname');
		$search['country'] = $this->input->post('country');
		$search['state'] = $this->input->post('state');

		if ($this->form_validation->run() === FALSE)
		{
			// echo "There are some problems";
			$search['msg'] = validation_errors();
			$data['titlepage'] = "UPLB OSA GTracer - Company Details"; //title page

			$this->load->view("header",$search);
			$this->load->view("navigation");
			$this->load->view("view_company_approval", $search);
			$this->load->view("footer");
		}
		else
		{
			$companyname=$this->model_company_approval->edit_company($search);
			$empno=$this->session->userdata('logged_in')['eno'];
			$this->add_log($empno, "Edited company entry", "Employee ".$empno." edited the entry of company ".$companyname.". Info[Company Number: ".$search['cno'].", Company Name: ".$search['cname'].", Country: ".$search['country'].", State/Province: ".$search['state']."] ");
		
			redirect('controller_company/index/'.$search['cno'], 'refresh');	// redirect to controller_search_book
		}
	}

}