<?php
	class Model_list_alumni extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// if student number is not specified, get the list of all graduates
		// else get the information of an alumnus using his or her student number
		public function get_alumni($studentno = FALSE){
			if ($studentno === FALSE){
				$query = $this->db->get('graduate');
				return $query->result_array();
			}

			$query = $this->db->get_where('graduate', array('studentno' => $studentno));
			return $query->row_array();
		}

		// get the total number of alumni in the database
		public function get_alumni_count(){
			$query=$this->db->query("SELECT count(*) FROM `graduate`");
			return $query->result_array()[0]['count(*)'];
		}

		// get the list of all alumni -- limited for pagination
		public function get_alumni_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT student_no, firstname, lastname, email FROM graduate LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT student_no, firstname, lastname, email FROM graduate ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>