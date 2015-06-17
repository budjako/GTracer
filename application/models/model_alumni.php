<?php
	class Model_alumni extends CI_Model {
		/* OPTIMIZE QUERIES */
		public function __construct(){
			$this->load->database();
		}

		// main call for getting all alumni data
		public function get_stud_data($stdno){
			if(! $this->exists($stdno)) return false;

			$info['basic']=$this->get_stud_basic_info($stdno);
			$info['ability']=$this->get_stud_ability($stdno);
			$info['assoc']=$this->get_stud_assoc($stdno);
			$info['award']=$this->get_stud_award($stdno);
			$info['education']=$this->get_stud_education($stdno);
			$info['grant']=$this->get_stud_grant($stdno);
			$info['lang']=$this->get_stud_lang($stdno);
			$info['profexam']=$this->get_stud_prof_exam($stdno);
			$info['publication']=$this->get_stud_publication($stdno);
			$info['work']=$this->get_stud_work($stdno);

			return $info;
		}

		// check if alumni exists
		// checks using student number
		public function exists($stdno){
			$query=$this->db->get_where('graduate', array("student_no"=>$stdno));
			if($query->num_rows()==1){
				return true;
			}
			else{
				return false;
			}
		}

		// get the basic information of the alumnus
		public function get_stud_basic_info($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('graduate');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from graduate where student_no = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result()[0];
			}
			return false;
		}

		// get the abilities of an alumnus
		public function get_stud_ability($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('ability');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from ability where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the associations or organizations that the alumnus belongs to
		public function get_stud_assoc($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('association');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from association where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the awards received by the alumnus
		public function get_stud_award($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('award');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from award where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}
		
		// get the grants received by the alumnus
		public function get_stud_grant($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('grant');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from `grant` where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the list of languages known by the alumnus
		public function get_stud_lang($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('language');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from language where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the list of professional exams taken by the alumnus
		public function get_stud_prof_exam($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('profexam');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from profexam where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the publications made by the alumnus
		public function get_stud_publication($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('publication');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from publication where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				return $query->result();
			}
			return false;
		}

		// get the working experience of an alumnus
		public function get_stud_work($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('work');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from work where studentno = '".$stdno."' order by currentjob desc, workdateend asc;");
			if($query->num_rows()>0){
				$result=$query->result();
				foreach ($result as $work) {	// get company name
					$query_companyname=$this->db->query("SELECT companyname from company where company_no=".$work->companyno.";");
					if($query_companyname->num_rows()==1)
						$work->companyname=$query_companyname->result()[0]->companyname;
				}
				return $result;
			}
			return false;
		}

		// get the educational background of an alumnus
		public function get_stud_education($stdno=FALSE){
			if ($stdno === FALSE){
				$query = $this->db->get('educationalbg');
				return $query->result_array();
			}
			$query=$this->db->query("SELECT * from educationalbg where studentno = '".$stdno."';");
			if($query->num_rows()>0){
				$result=$query->result();
				foreach ($result as $education) {	// get school name
					$query_schoolname=$this->db->query("SELECT schoolname from school where school_no=".$education->schoolno.";");
					if($query_schoolname->num_rows()==1)
						$education->schoolname=$query_schoolname->result()[0]->schoolname;
				}
				return $result;
			}
			return false;
		}
	}
?>