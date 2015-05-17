<?php
	class Model_logs extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

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

		public function get_log_count($empno = FALSE){
			if ($empno === FALSE){
				$query=$this->db->query("SELECT count(*) FROM `log`");
				return $query->result_array()[0]['count(*)'];
			}
			$query=$this->db->query("SELECT count(*) FROM `log` where empno = ".$empno);
			return $query->result_array()[0]['count(*)'];
		}

		public function get_logs_paginate($limit, $start, $sort, $order, $empno = FALSE){
			// echo "sort: ".$sort."<br>";
			// echo "order: ".$order."<br>";
			// echo "limit: ".$limit."<br>";
			// echo "start: ".$start."<br>";
			// echo "empno: ".$empno."<br>";
			if($order){
				if($empno){		// all fields are present
					// echo "SELECT * FROM log where empno = ".$empno." ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";";
					$query=$this->db->query("SELECT * FROM log where empno = ".$empno." ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
				}
				else{			// no empno given
					// echo "SELECT * FROM log ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";";
					$query=$this->db->query("SELECT * FROM log ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
				}
			}
			else{
				if($sort){		// limit, start and empno are given 
					// echo "SELECT * FROM log where empno = ".$sort." LIMIT ".$start.",".$limit;
					$query=$this->db->query("SELECT * FROM log where empno = ".$sort." LIMIT ".$start.",".$limit);
				}
				else{			// limit and start only
					// echo "SELECT * FROM log LIMIT ".$start.",".$limit;
					$query=$this->db->query("SELECT * FROM log LIMIT ".$start.",".$limit);
				}
			}
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		public function add_log($empno, $activity, $actdetails){
			// $time=$this->udate('Y-m-d H:i:s:u'); 
			$sql="INSERT INTO `log` (`empno`, `activity`, `actdetails`, `timeperformed`) VALUES (".$this->db->escape($empno).", ".$this->db->escape($activity).", ".$this->db->escape($actdetails).", sysdate(3))";
			$query = $this->db->query($sql) or die(mysql_error());
			return;
		}

		public function get_country(){
			$this->db->select('alpha_2, name');
			$this->db->from('meta_country');
			$this->db->order_by('name', 'asc');
			$query=$this->db->get();
			return $query->result();
		}


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