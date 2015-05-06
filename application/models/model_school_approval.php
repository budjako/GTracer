<?php
	class Model_school_approval extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_approval_school_count(){
			$query=$this->db->query("SELECT count(*) FROM request r, school s WHERE r.schoolno=s.school_no");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_approval_school($limit, $start){
			$query=$this->db->query("SELECT s.school_no, s.schoolname, s.schooladdress FROM request r, school s WHERE r.schoolno=s.school_no LIMIT ".$start.",".$limit) or die(mysqli_error());
			return $query->result_array();
		}

		public function approve_school($school_no){
			$query=$this->db->query("DELETE from request where schoolno=".$school_no);
			return;
		}
	}
?>