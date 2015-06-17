<?php
	class Model_basic_search extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// set query and return all results
		public function get_search($search){
			$str="SELECT ";
			$ctr=0;
			$param=array();
			if ($search['stdno'] != FALSE){
				$param['student_no']=$search['stdno'];
				$ctr++;
			}
			if ($search['fname'] != FALSE){
				$param['firstname']=$search['fname'];
				$ctr++;
			}
			if ($search['mname'] != FALSE){
				$param['middlename']=$search['mname'];
				$ctr++;
			}
			if ($search['lname'] != FALSE){
				$param['lastname']=$search['lname'];
				$ctr++;
			}
			if ($search['email'] != FALSE){
				$param['email']=$search['email'];
				$ctr++;
			}

			$query = $this->db->get_where('graduate', $param);
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// set query and paginate results
		public function get_search_paginate($search, $limit, $start){
			$str="SELECT ";
			$ctr=0;
			$param=array();
			if ($search['stdno'] != FALSE){
				$param['student_no']=$search['stdno'];
				$ctr++;
			}
			if ($search['fname'] != FALSE){
				$param['firstname']=$search['fname'];
				$ctr++;
			}
			if ($search['mname'] != FALSE){
				$param['middlename']=$search['mname'];
				$ctr++;
			}
			if ($search['lname'] != FALSE){
				$param['lastname']=$search['lname'];
				$ctr++;
			}
			if ($search['email'] != FALSE){
				$param['email']=$search['email'];
				$ctr++;
			}

			$query = $this->db->get_where('graduate', $param, $limit, $start);
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>