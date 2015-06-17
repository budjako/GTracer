<?php
	class Model_company_approval extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// get number of approved companies
		public function get_approval_company_count(){
			$query=$this->db->query("SELECT count(*) FROM request r, company c WHERE r.companyno=c.company_no");
			return $query->result_array()[0]['count(*)'];
		}


		// get a list of all companies and their details
		public function get_approval_company($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT c.company_no, c.companyname, c.caddcountry, c.caddregion, c.caddprovince, c.caddcountrycode, c.caddregioncode, c.caddprovincecode, c.companytype FROM request r, company c WHERE r.companyno=c.company_no LIMIT ".$start.",".$limit);
			else
				$query=$this->db->query("SELECT c.company_no, c.companyname, c.caddcountry, c.caddregion, c.caddprovince, c.caddcountrycode, c.caddregioncode, c.caddprovincecode, c.companytype FROM request r, company c WHERE r.companyno=c.company_no ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result_array();
			}
			return false;
		}

		// remove entry of company on the request table
		// return company name
		public function approve_company($company_no){
			$companyname=$this->db->query("SELECT companyname from company where company_no=".$company_no);
			$query=$this->db->query("DELETE from request where companyno=".$company_no);
			return $companyname->result_array()[0]['companyname'];
		}

		// update the values of the company
		public function edit_company($details){
			$countryname=$this->get_country_name($details['country']);
			if($details['state']=="-1"){
				$query=$this->db->query("UPDATE `company` SET `companyname`='".$details['cname']."', `companytype`='".$details['ctype']."', `caddcountry`='".$countryname."', `caddcountrycode`='".$details['country']."' where `company_no`='".$details['cno']."';") or die(mysqli_error());
			}
			else{
				$statename=$this->get_state_name($details['state']);
				$query=$this->db->query("UPDATE `company` SET `companyname`='".$details['cname']."', `companytype`='".$details['ctype']."', `caddcountry`='".$countryname."', `caddcountrycode`='".$details['country']."', `caddprovince`='".$statename."', `caddprovincecode`='".$details['state']."' where `company_no`='".$details['cno']."';") or die(mysqli_error());
			}
			return;
		}

		// get the iso code of a country
		private function get_country_name($alpha_2){
			$this->db->select('name');
			$this->db->from('meta_country');
			$this->db->where('alpha_2', $alpha_2);
			$query = $this->db->get();
			return $query->result()[0]->name;
		}

		// get the iso code of a state/province
		private function get_state_name($iso_code){
			$this->db->select('name');
			$this->db->from('meta_province');
			$this->db->where('iso_code', $iso_code);
			$query =  $this->db->get();
			return $query->result()[0]->name;
		}
	}
?>