<?php
	class Model_company_approval extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_approval_company_count(){
			$query=$this->db->query("SELECT count(*) FROM request r, company c WHERE r.schoolno=c.company_no");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_approval_company($limit, $start){
			$query=$this->db->query("SELECT c.company_no, c.name, c.address, c.companytype FROM request r, company c WHERE r.schoolno=c.company_no LIMIT ".$start.",".$limit) or die(mysqli_error());
			return $query->result_array();
		}
	}
?>