<?php
	class Model_school extends CI_Model {
		/* OPTIMIZE QUERIES */
		public function __construct(){
			$this->load->database();
		}

		public function get_school_data($school_no = FALSE){
			if($school_no === FALSE){
				$query = $this->db->get('school');
				return $query->result_array();
			}

			$query = $this->db->get_where('school', array('school_no' => $school_no));
			return $query->row_array();
		}

		public function is_approved($school_no){
			$query=$this->db->query("SELECT count(*) FROM `request` where `schoolno`=".$school_no);
			if($query->result_array()[0]['count(*)']>0) return false;
			return true;
		}

		public function edit_school($origentry, $schoolmerge){
			$query=$this->db->query("UPDATE `educationalbg` SET `schoolno`=".$schoolmerge." where `schoolno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `request` where `schoolno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `school` where `school_no`=".$origentry) or die(mysql_error());
		}

		public function get_school_count(){
			$query=$this->db->query("SELECT count(*) FROM `school`");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_school_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT school_no, schoolname, saddcountry, saddregion, saddprovince FROM school LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT school_no, schoolname, saddcountry, saddregion, saddprovince FROM school ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		public function get_school_name($school_no){
			$query=$this->db->query("SELECT schoolname FROM `school` where school_no=".$school_no);
			return $query->result_array()[0]['schoolname'];
		}

		public function get_school_approved_count(){
			$query=$this->db->query("SELECT count(*) FROM `school` where school_no not in (select schoolno from `request` where schoolno is not null)");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_school_approved_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT school_no, schoolname, saddcountry, saddregion, saddprovince FROM school where school_no not in (select schoolno from `request` where schoolno is not null) LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT school_no, schoolname, saddcountry, saddregion, saddprovince FROM school where school_no not in (select schoolno from `request` where schoolno is not null) ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>