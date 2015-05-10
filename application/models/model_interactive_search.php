<?php
	class Model_interactive_search extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_data_count($sql){
			// echo "<br>".$sql;
			// var_dump($sql);
			$query=$this->db->query($sql) or die(mysqli_error());
			// var_dump($query);
			return count($query->result());
		}

		public function get_data_paginate($sql, $limit, $start){
			// echo "<br>".$sql;
			// var_dump($sql);
			$query=$this->db->query($sql." LIMIT ".$start.",".$limit) or die(mysqli_error());
			// var_dump($query);
			return $query->result_array();
		}

		public function get_data($sql){
			$query=$this->db->query($sql) or die(mysqli_error());
			// var_dump($query->result_array());
			return $query->result_array();
		}
	}
?>