<?php
	class Model_user extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function add_user($data){
			$query=$this->db->query("INSERT INTO staff(emp_no, name, email) VALUES ('".$data["eno"]."','".$data["fname"]." ".$data['lname']."', '".$data['email']."');");
			return;
		}

		public function check_email($email){
			$query=$this->db->get_where('staff', array('email'=>$email));
			if($query->num_rows()>0){
				return true;
			}
			return false;
		}

		public function get_eno($email){
			$this->db->select('emp_no');
			$this->db->limit(1);
			$query=$this->db->get_where('staff', array('email'=>$email)) or die(mysql_error());
			if($query->num_rows()>0){
				return $query->result()[0]->emp_no;
			}
			return false;
		}

		public function is_admin($empno){
			$query=$this->db->query("SELECT `admin` from staff where `emp_no`='".$empno."';");
			if($query->num_rows()==1){
				if($query->result()[0]->admin == 0){
					return false;
				}
				return true;
			}
			else{
				return false;
			}
		}

		public function is_banned($empno){
			$query=$this->db->query("SELECT `ban` from staff where `emp_no`='".$empno."';");
			if($query->num_rows()==1){
				if($query->result()[0]->ban == 0){
					return false;
				}
				return true;
			}
			else{
				return false;
			}
		}

		public function add_admin($empno){
			$query=$this->db->query("UPDATE `staff` SET `ban`=0 where `emp_no`='".$empno."';") or die(mysql_error());
			$query=$this->db->query("UPDATE `staff` SET `admin`=1 where `emp_no`='".$empno."';") or die(mysql_error());
		}

		public function ban($empno, $value){
			$query=$this->db->query("UPDATE `staff` SET `ban`=".$value." where `emp_no`='".$empno."';") or die(mysql_error());
		}

		public function exists($empno){
			$query=$this->db->get_where('staff', array("emp_no"=>$empno));
			if($query->num_rows()==1){
				return true;
			}
			else{
				return false;
			}
		}

		public function get_type($empno=FALSE){
			$query=$this->db->query("SELECT `admin` from staff where `emp_no`='".$empno."';");
			if($query->num_rows()==1){
				return $query->result()[0]->admin;
			}
			else{
				return false;
			}
		}

		public function get_user_count(){
			$query=$this->db->query("SELECT count(*) FROM `staff`");
			return $query->result_array()[0]['count(*)'];
		}

		public function get_user($empno=FALSE){
			if ($empno === FALSE){
				$query = $this->db->get('staff');
				return $query->result_array();
			}

			$query=$this->db->query("SELECT * from staff where empno = ".$empno);
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		public function get_users_paginate($limit, $start, $sort, $order){
			// echo "sort: ".$sort."<br>";
			// echo "order: ".$order."<br>";
			// echo "limit: ".$limit."<br>";
			// echo "start: ".$start."<br>";
			
			if($order == FALSE)
				$query=$this->db->query("SELECT * FROM staff LIMIT ".$start.",".$limit.";");
			else
				$query=$this->db->query("SELECT * FROM staff ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>
