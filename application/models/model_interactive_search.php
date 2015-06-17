<?php
	class Model_interactive_search extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// get the number of results for the query
		public function get_data_count($sql){
			$query=$this->db->query($sql) or die(mysqli_error());
			return count($query->result());
		}

		// get the results of the query made -- limited for pagination
		public function get_data_paginate($sql, $limit, $start){
			$query=$this->db->query($sql." LIMIT ".$start.",".$limit) or die(mysqli_error());
			return $query->result_array();
		}

		// get the results of the query made
		public function get_data($sql){
			$query=$this->db->query($sql) or die(mysqli_error());
			return $query->result_array();
		}
	}
?>