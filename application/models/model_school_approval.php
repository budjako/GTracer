<?php
	class Model_school_approval extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// get the number of approved schools
		public function get_approval_school_count(){
			$query=$this->db->query("SELECT count(*) FROM request r, school s WHERE r.schoolno=s.school_no");
			return $query->result_array()[0]['count(*)'];
		}

		// get the list and details of schools
		public function get_approval_school($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT s.school_no, s.schoolname, s.saddcountry, s.saddregion, s.saddprovince, s.saddcountrycode, s.saddregioncode, s.saddprovincecode  FROM request r, school s WHERE r.schoolno=s.school_no LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT s.school_no, s.schoolname, s.saddcountry, s.saddregion, s.saddprovince, s.saddcountrycode, s.saddregioncode, s.saddprovincecode  FROM request r, school s WHERE r.schoolno=s.school_no ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result_array();
			}
			return false;
		}

		// remove school entry from request table
		public function approve_school($school_no){
			$schoolname=$this->db->query("SELECT schoolname from school where school_no=".$school_no);
			$query=$this->db->query("DELETE from request where schoolno=".$school_no);
			return $schoolname->result_array()[0]['schoolname'];
		}

		// edit school information
		public function edit_school($details){
			$countryname=$this->get_country_name($details['country']);
			if($details['state']=="-1"){
				$query=$this->db->query("UPDATE `school` SET `schoolname`='".$details['sname']."', `saddcountry`='".$countryname."', `saddcountrycode`='".$details['country']."' where `school_no`='".$details['sno']."';") or die(mysqli_error());
				$query=$this->db->query("DELETE from request where schoolno=".$details['sno']);
			}
			else{
				$statename=$this->get_state_name($details['state']);
				$query=$this->db->query("UPDATE `school` SET `schoolname`='".$details['sname']."', `saddcountry`='".$countryname."', `saddcountrycode`='".$details['country']."', `saddprovince`='".$statename."', `saddprovincecode`='".$details['state']."' where `school_no`='".$details['sno']."';") or die(mysqli_error());
				$query=$this->db->query("DELETE from request where schoolno=".$details['sno']);
			}
			return;
		}

		// get the country name using its iso code
		private function get_country_name($alpha_2){
			$this->db->select('name');
			$this->db->from('meta_country');
			$this->db->where('alpha_2', $alpha_2);
			$query = $this->db->get();
			return $query->result()[0]->name;
		}

		// get the state or region name using its iso code
		private function get_state_name($iso_code){
			$iso_code=str_replace("_", "-", $iso_code);
			$this->db->select('name');
			$this->db->from('meta_province');
			$this->db->where('iso_code', $iso_code);
			$query =  $this->db->get();

			if($query->num_rows()==0) return "";
			return $query->result()[0]->name;
		}
	}
?>