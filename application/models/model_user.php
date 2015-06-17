<?php
	class Model_user extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		// add new user to the system
		// only on first sign in of user
		public function add_user($data){
			$query=$this->db->query("INSERT INTO staff(emp_no, name, email) VALUES ('".$data["eno"]."','".$data["fname"]." ".$data['lname']."', '".$data['email']."');");
			$sql="INSERT INTO `log` (`empno`, `activity`, `actdetails`, `timeperformed`) VALUES ('".$data["eno"]."', 'Register user', 'Employee ".$data['eno']." information stored. Info[ Employee Number: ".$data['eno'].", Name: ".$data['fname']." ".$data['lname'].", Email: ".$data['email']."]', sysdate(3))";
			$query = $this->db->query($sql) or die(mysql_error());
			return;
		}

		// check if email specified is already used
		public function check_email($email){
			$query=$this->db->get_where('staff', array('email'=>$email));
			if($query->num_rows()>0){
				return true;
			}
			return false;
		}

		// get employee number using email address
		public function get_eno($email){
			$this->db->select('emp_no');
			$this->db->limit(1);
			$query=$this->db->get_where('staff', array('email'=>$email)) or die(mysql_error());
			if($query->num_rows()>0){
				return $query->result()[0]->emp_no;
			}
			return false;
		}

		// check if employee is already an admin by using the employee number
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

		// check if account is active or not
		public function is_active($empno){
			$query=$this->db->query("SELECT `active` from staff where `emp_no`='".$empno."';");
			if($query->num_rows()==1)
				if($query->result()[0]->active == 1){
					return true;
				}
				return false;
		}

		// add a user as an administrator
		public function add_admin($empno){
			$query=$this->db->query("UPDATE `staff` SET `active`=0 where `emp_no`='".$empno."';") or die(mysql_error());
			$query=$this->db->query("UPDATE `staff` SET `admin`=1 where `emp_no`='".$empno."';") or die(mysql_error());
		}

		// activate or deactvate a user
		public function active($empno, $value){
			$query=$this->db->query("UPDATE `staff` SET `active`=".$value." where `emp_no`='".$empno."';") or die(mysql_error());
		}

		// check if an employee exists using an employee number
		public function exists($empno){
			$query=$this->db->get_where('staff', array("emp_no"=>$empno));
			if($query->num_rows()==1){
				return true;
			}
			else{
				return false;
			}
		}

		// check if an employee is an administrator or not -- 0 if not, 1 if yes
		public function get_type($empno=FALSE){
			$query=$this->db->query("SELECT `admin` from staff where `emp_no`='".$empno."';");
			if($query->num_rows()==1){
				return $query->result()[0]->admin;
			}
			else{
				return false;
			}
		}

		// get number of all user accounts including deleted ones
		public function get_user_count_with_del_accts(){
			$query=$this->db->query("SELECT count(*) FROM `staff`");
			return $query->result_array()[0]['count(*)'];
		}

		// get list of all user accounts including deleted ones
		public function get_user_with_del_accts($empno=FALSE){
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

		// get the list of users and their details -- limited for pagination
		public function get_users_paginate_with_del_accts($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT * FROM staff LIMIT ".$start.",".$limit.";");
			else
				$query=$this->db->query("SELECT * FROM staff ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// NOT INCLUDING DEACTIVATED USERS
		// get number of users not including deactivated accounts
		public function get_user_count(){
			$query=$this->db->query("SELECT count(*) FROM `staff` ");
			return $query->result_array()[0]['count(*)'];
		}

		// get list of all users of users not including deactivated accounts
		public function get_user($empno=FALSE){
			if ($empno === FALSE){
				$query = $this->db->get('staff');
				return $query->result_array();
			}

			$query=$this->db->query("SELECT * from staff where `empno` = ".$empno."  and `active` = 1");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the  list of users and their details -- limited for pagination
		public function get_users_paginate($limit, $start, $sort, $order){
			if($order == FALSE)
				$query=$this->db->query("SELECT * FROM staff  LIMIT ".$start.",".$limit.";");
			else
				$query=$this->db->query("SELECT * FROM staff  ORDER BY ".$sort." ".$order." LIMIT ".$start.",".$limit.";") or die(mysqli_error());
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
	}
?>
