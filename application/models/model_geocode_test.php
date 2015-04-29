<?php
	class Model_geocode_test extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_geocode_data(){
			$query=$this->db->query("SELECT name, address FROM company");
			return $query->result_array();
		}

		public function get_alumni_count(){
			$query=$this->db->query("SELECT count(*) FROM `graduate`");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_alumni_paginate($limit, $start, $sort, $order){
			// echo "sort: ".$sort."<br>";
			// echo "order: ".$order."<br>";
			// echo "limit: ".$limit."<br>";
			// echo "start: ".$start."<br>";
			if($order == FALSE)
				$query=$this->db->query("SELECT student_no, firstname, lastname, midname, email FROM graduate LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT student_no, firstname, lastname, midname, email FROM graduate ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>