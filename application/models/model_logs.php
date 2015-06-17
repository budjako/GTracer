<?php
	class Model_logs extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// get the logs  
		// if employee number is specified, get the logs of that employee only
		public function get_activity($empno = FALSE){
			if ($empno === FALSE){
				$query = $this->db->get('log');
				if($query->num_rows()>0){
					return $query->result();
				}
				return false;
			}

			$query=$this->db->query("SELECT * from log where empno = ".$empno);
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the number of logs 
		public function get_log_count($empno = FALSE){
			if ($empno === FALSE){
				$query=$this->db->query("SELECT count(*) FROM `log`");
				return $query->result_array()[0]['count(*)'];
			}
			$query=$this->db->query("SELECT count(*) FROM `log` where empno = ".$empno);
			return $query->result_array()[0]['count(*)'];
		}

		// show all logs
		public function get_logs_paginate($limit, $start, $sort, $order, $empno = FALSE){
			if($order){
				if($empno){		// all fields are present
					$query=$this->db->query("SELECT * FROM log where empno = ".$empno." ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
				}
				else{			// no empno given
					$query=$this->db->query("SELECT * FROM log ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
				}
			}
			else{
				if($sort){		// limit, start and empno are given 
					$query=$this->db->query("SELECT * FROM log where empno = ".$sort." LIMIT ".$start.",".$limit);
				}
				else{			// limit and start only
					$query=$this->db->query("SELECT * FROM log LIMIT ".$start.",".$limit);
				}
			}
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// add log entry
		public function add_log($empno, $activity, $actdetails){
			$sql="INSERT INTO `log` (`empno`, `activity`, `actdetails`, `timeperformed`) VALUES (".$this->db->escape($empno).", ".$this->db->escape($activity).", ".$this->db->escape($actdetails).", sysdate(3))";
			$query = $this->db->query($sql) or die(mysql_error());
			return;
		}

		// get the country name given the iso code
		public function get_country(){
			$this->db->select('alpha_2, name');
			$this->db->from('meta_country');
			$this->db->order_by('name', 'asc');
			$query=$this->db->get();
			return $query->result();
		}

		// get the state or region name given the iso code
		public function get_data($loadId){
			$fieldList='iso_code,name';
			$table='meta_province';
			$fieldName='country_code';
			$orderByField='name';
			
			$this->db->select($fieldList);
			$this->db->from($table);
			$this->db->where($fieldName, $loadId);
			if($loadId == "PH"){
			$this->db->where('type', 'Province');
			}
			$this->db->order_by($orderByField, 'asc');

			$query=$this->db->get();
			return $query->result_array();
		}
	}
?>