<?php
	class Model_company_approval extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_approval_company_count(){
			$query=$this->db->query("SELECT count(*) FROM request r, company c WHERE r.companyno=c.company_no");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_approval_company($limit, $start){
			$query=$this->db->query("SELECT c.company_no, c.companyname, c.companyaddress, c.companytype FROM request r, company c WHERE r.companyno=c.company_no LIMIT ".$start.",".$limit) or die(mysqli_error());
			return $query->result_array();
		}

		public function approve_company($company_no){
			$query=$this->db->query("DELETE from request where companyno=".$company_no);
			return;
		}
	}
?>