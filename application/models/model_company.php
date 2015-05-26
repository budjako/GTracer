<?php
	class Model_company extends CI_Model {
		/* OPTIMIZE QUERIES */
		public function __construct(){
			$this->load->database();
		}

		public function get_company_data($company_no = FALSE){
			if($company_no === FALSE){
				$query = $this->db->get('company');
				return $query->result_array();
			}

			$query = $this->db->get_where('company', array('company_no' => $company_no));
			return $query->row_array();
		}

		public function is_approved($company_no){
			$query=$this->db->query("SELECT count(*) FROM `request` where `companyno`=".$company_no);
			if($query->result_array()[0]['count(*)']>0) return false;
			return true;
		}

		public function edit_company($origentry, $companymerge){
			$query=$this->db->query("UPDATE `work` SET `companyno`=".$companymerge." where `companyno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `request` where `companyno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `company` where `company_no`=".$origentry) or die(mysql_error());
		}

		public function get_company_count(){
			$query=$this->db->query("SELECT count(*) FROM `company`");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_company_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT company_no, companyname, caddcountry, caddregion, caddprovince, companytype FROM company LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT company_no, companyname, caddcountry, caddregion, caddprovince, companytype FROM company ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		public function get_company_name($company_no){
			$query=$this->db->query("SELECT companyname FROM `company` where company_no=".$company_no);
			return $query->result_array()[0]['companyname'];
		}

		public function get_company_approved_count(){
			$query=$this->db->query("SELECT count(*) FROM `company` where company_no not in (select companyno from `request` where companyno is not null)");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_company_approved_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT company_no, companyname, caddcountry, caddregion, caddprovince, companytype FROM company where company_no not in (select companyno from `request` where companyno is not null) LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT company_no, companyname, caddcountry, caddregion, caddprovince, companytype FROM company where company_no not in (select companyno from `request` where companyno is not null) ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>