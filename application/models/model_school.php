<?php
	class Model_school extends CI_Model {
		/* OPTIMIZE QUERIES */
		public function __construct(){
			$this->load->database();
		}

		// get a list of all schools and their details
		// if school number is specified, get only info of that school
		public function get_school_data($school_no = FALSE){
			if($school_no === FALSE){
				$query = $this->db->get('school');
				return $query->result_array();
			}

			$query = $this->db->get_where('school', array('school_no' => $school_no));
			return $query->row_array();
		}

		// check if school is approved or not
		public function is_approved($school_no){
			$query=$this->db->query("SELECT count(*) FROM `request` where `schoolno`=".$school_no);
			if($query->result_array()[0]['count(*)']>0) return false;
			return true;
		}

		// edit school details
		public function edit_school($origentry, $schoolmerge){
			$query=$this->db->query("UPDATE `educationalbg` SET `schoolno`=".$schoolmerge." where `schoolno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `request` where `schoolno`=".$origentry) or die(mysql_error());
			$query=$this->db->query("DELETE FROM `school` where `school_no`=".$origentry) or die(mysql_error());
		}

		// get the number of schools in the database -- both approved and not
		public function get_school_count(){
			$query=$this->db->query("SELECT count(*) FROM `school`");
			return $query->result_array()[0]['count(*)'];
		}

		// show all schools and their details
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

		// get the school name using the school's school number
		public function get_school_name($school_no){
			$query=$this->db->query("SELECT schoolname FROM `school` where school_no=".$school_no);
			return $query->result_array()[0]['schoolname'];
		}

		// get the number of approved schools
		public function get_school_approved_count(){
			$query=$this->db->query("SELECT count(*) FROM `school` where school_no not in (select schoolno from `request` where schoolno is not null)");
			return $query->result_array()[0]['count(*)'];
		}

		// get the list of approved school entries and their details
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