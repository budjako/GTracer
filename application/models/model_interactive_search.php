<?php
	class Model_interactive_search extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_data($sql){
			// echo "<br>".$sql;
			// var_dump($sql);
			$query=$this->db->query($sql/*." LIMIT 0,30;"*/) or die(mysqli_error());
			// var_dump($query);
			return $query->result();
		}
	}
?>