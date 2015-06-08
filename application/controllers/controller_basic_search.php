<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Controller_alumni
		- controller used in searching for a group of alumnus
		- fields that are can be supplied are First Name, Middle Name, Last Name and Email 
*/

class Controller_basic_search extends CI_Controller {

	function index() {
		if($this->session->userdata('logged_in') == FALSE){					// check if the user is logged in
			redirect('controller_login', 'refresh');						// if not, redirect to login page
		}
		
		$this->load->library('pagination');									// include pagination library

		$data['titlepage'] = "UPLB OSA GTracer - Basic Search"; //title page  
	
		$this->load->view("header", $data); //displays the header
		$this->load->view("navigation");
		$this->load->view("view_basic_search", $data); //displays the home page
		$this->load->view("footer");
	}

	function stdno($str){													// validate student number
		if($str == "") return true;
		return(! preg_match("/^[12][0-9]{3}\-[0-9]{5}$/i", $str))? FALSE: TRUE;
	}
	
	function fname_check($str){												// validate first name
		if($str == "") return true;
		return(! preg_match("/^[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*\.?((\.\s[A-Za-zñÑ]{2}[A-Za-zñÑ\s]*\.?)|(\s[A-Za-zñÑ][A-Za-zñÑ]{1,2}\.)|(-[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*))*$/i", $str))? FALSE: TRUE;
	}

	function lname_check($str){												// validate last name or middle name
		if($str == "") return true;
		return(! preg_match("/^([A-Za-zñÑ]){1}([A-Za-zñÑ]){1,}(\s([A-Za-zñÑ]){1,})*(\-([A-Za-zñÑ]){1,}){0,1}$/i", $str))? FALSE: TRUE;
	}

	function search_form(){													// validation handler
		$data['titlepage'] = "UPLB OSA GTracer - Basic Search"; //title page 
		$this->load->library('form_validation');

		// set rules in validating values supplied
		$this->form_validation->set_rules('stdno', 'Student Number', 'trim|xss_clean|callback_stdno');	
		$this->form_validation->set_message('stdno', 'Must be xxxx-xxxxx');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|xss_clean|ucwords|callback_fname_check');
		$this->form_validation->set_rules('mname', 'Middle Name', 'trim|xss_clean|ucwords|callback_lname_check');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|xss_clean|ucwords|callback_lname_check');
		$this->form_validation->set_rules('email', 'Your Email', 'trim|valid_email|xss_clean');


		$search['stdno'] = $this->input->post('stdno');
		$search['fname'] = $this->input->post('fname');
		$search['mname'] = $this->input->post('mname');
		$search['lname'] = $this->input->post('lname');
		$search['email'] = $this->input->post('email');

		$this->session->set_userdata('search', $search);

		if ($this->form_validation->run() === FALSE){						// there are some errors in the values supplied
			$search['msg'] = validation_errors();							// show page again and show what are the errors
			$this->load->view("header", $search);
			$this->load->view("navigation");
			$this->load->view("view_basic_search", $search); 
			$this->load->view("footer");
		}
		else{
			$this->search();
		}
	}

	public function search(){												// search results
		$this->load->model('model_basic_search');
		$this->load->library('pagination');

		$data['titlepage'] = "UPLB OSA GTracer - Basic Search Results"; 	//title page 
		$result['basic_result']=$this->model_basic_search->get_search($this->session->userdata('search'));
		if(! $result['basic_result']){
			$data['no_results']=1;
		}
		else{
			$config['base_url'] = base_url().'controller_basic_search/search/';
			$config['total_rows'] = count($result['basic_result']);
			$config['per_page'] = 20; 
			$config['uri_segment']=3;

			$this->pagination->initialize($config); 

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['results'] = $this->model_basic_search->get_search_paginate($this->session->userdata('search'), $config['per_page'], $page);
			// var_dump($data['results']);
			$data['links']=$this->pagination->create_links();

		}
		$this->load->view("header", $data); 								//displays the header
		$this->load->view("navigation");
		$this->load->view("view_basic_result", $data); 						//displays the home page
		$this->load->view("footer"); 										//displays the footer
	}
}  
