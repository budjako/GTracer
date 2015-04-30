<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller_interactive_search extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_interactive_search');
	}

	function index() {
		// if($this->session->userdata('logged_in') == FALSE){
		// 	redirect('controller_login', 'refresh');// redirect to controller_search_book
		// }
		
		$data['titlepage'] = "UPLB OSA GTracer - Interactive Search"; //title page  

		$this->load->view("dragdropheader", $data); //displays the header
		$this->load->view("navigation");
		$this->load->view("view_interactive_search"); //displays the home page
		$this->load->view("footer"); //displays the footer
	}

	function recursive_bracket_parser($str, $i, &$array){	// per character processing -- pass by reference
		$len=strlen($str);
		$retstring=$op="";
		$tempstring="";
		$count=0;

		while ($i < $len){
			// echo $i;
			// echo strpos($str, "Val", $i);
			if (strpos($str, "And", $i) === $i) {
				// echo "AND OPERATION!<br>";
				/*if($array==null) $array[]=array('And'=>null);
				else */$array[]['And']=null;
				// var_dump($array);
				$op='And';
				$i+=3;
				continue;
			}
			else if (strpos($str, "Or", $i) === $i) {
				// echo "OR OPERATION!<br>";
				/*if($array==null) $array[]=array('Or'=>null);
				else */$array[]['Or']=null;					// add new item with or as value(another array)
				// var_dump($array);
				$op='Or';
				$i+=2;
				continue;
			}
			else if (strpos($str, "Val", $i) === $i) {
				// echo "VALUE!asdfasdfasdfasdfasdf<br>";
				// /*if($array==null) */$array[]['Value']=null;
				// else $array=array('Value'=>null);
				if($array==null) $array['Value']=null;
				// var_dump($array);
				$op='Value';
				$i+=3;
				continue;
			}
			else if ($str[$i] === '('){
				// echo "START OPERATION!<br>";
				// var_dump($array[$op]);
				// echo "ETO: $op<br>";
				// echo "===========<br>";
				// var_dump($array);
				// echo "===========<br>";
				if($op == "Value") $i = $this->recursive_bracket_parser($str, $i+1, $array['Value']);
				else{
					// echo "PASS ETO: $op<br>";
					if(array_key_exists('Value', $array)){
						// var_dump($array[count($array)-2][$op]);
						$i = $this->recursive_bracket_parser($str, $i+1, $array[count($array)-2][$op]);
					
					}
					else{
						// var_dump($array[count($array)-1][$op]);
						$i = $this->recursive_bracket_parser($str, $i+1, $array[count($array)-1][$op]);
					}
				}
				// echo "<br>ASSIGNING<br>     Given:<br>"; 
				// echo $op."<br>";
				// var_dump($array);
			}
			else if ($str[$i] == ')'){			// end token return to calling function
				$i++;
				// echo "END $op OPERATION!<br>";
				// echo "TO BE RETURNEDDDD!!";
				// if($tempstring == null) $retval = array('$i'=>$i, 'query' => $array);
				// else $retval = array('$i'=>$i, 'query' => $tempstring);
				// var_dump($retval);
				if($tempstring != null){
					if(!isset($array)) $array=array();
					$array[]=$tempstring;
					// var_dump($array);
				}
				return $i;
			}
			else{
				if($str[$i] == ',' && $tempstring == ""){
					// echo "Comma not value<br>";
					$i++;
					continue;
				}
				$tempstring.=$str[$i];
				// echo $tempstring."<br>";
				$i++;
			}
		}
		return false;
		// return array('$i'=>$i, $array);
	}

	function create_query($arr){
		$tables=array();
		$selected=array();
		$sql="select ";
		$condition=array();

		$selct=0;
		$school=0;
		$company=0;
		var_dump($arr);

		// while ($field=current($arr)) {					// $field as items in array: [0], [1], etc.
		$fields=array_keys($arr);
		// for($i=0; $i<count($fields); $i++){
		// 	// var_dump($field);
		// 	$item = $arr[$fields[$i]];
		// 	echo "ITEEEEEEMMMMMM! <br>$item<br>";
		foreach ($fields as $item){
			var_dump($item);
			$details=$this->to_table_name($item);
			if(! in_array($details[0], $tables)) $tables[]=$details[0];		// list of table names involved
			$selected[]=$details[1];										// list of field names involved
			if($selct>0) $sql.=", ";
			$sql.=$details[0].".".$details[1];
			if($details[0] == "company") $company=1;
			if($details[0] == "school") $school=1;
			// echo "$sql<br>";
			// echo "$selct<br>";
			$selct++;
			// set conditions
			var_dump($arr);
			if($arr[$item]!=null){
				if(array_key_exists('Value', $arr[$item])){		// Single Constraint
					$val=$this->cond_value($arr[$item]['Value'], $details);
					$condition[]=$val[0];
				}
				else if($arr[$item][0]!=null){
					/*if(array_key_exists('Value', $arr[$item][0])){
						// var_dump($arr[$item][0]['Value']);
						$val=$this->cond_value($arr[$item][$key]['Value'], $details);
						$condition[]=$val[0];
					}
					else */if(array_key_exists('Or', $arr[$item][0])){
						// var_dump($arr[$item][0]['Or']);
						$condition[]=$this->cond_or($arr[$item][0]['Or'], $details);

					}
					else if(array_key_exists('And', $arr[$item][0])){
						// var_dump($arr[$item][0]['And']);
						$condition[]=$this->cond_and($arr[$item][0]['And'], $details);
					}
				}
			}
			next($arr);	
		}

		$sql.=" from ";									// include in from all tables involved
		$count2=0;
		$tabcount=count($tables);
		for($count2=0; $count2<$tabcount; $count2++){
			if($count2>0) $sql.=", ";
			if($tables[$count2] == "work") $company=2;
			if($tables[$count2] == "educationalbg") $school=2;
			$sql.=$tables[$count2];
		}
		if($company == 1) $sql.=", work";
		if($school == 1) $sql.=", educationalbg";
		if(in_array('graduate', $tables)){
			if(count($tables)>1){							// link by student number
				$sql.=" where ";
				$count3=0;
				$count4=0;
				for($count3=0; $count3<$tabcount; $count3++){
					if ($tables[$count3] == "company"){
						if($count4>0) $sql.=" and ";
						$sql.="(graduate.student_no=work.studentno and work.companyno=company.company_no)";
						$count4++;
					}
					else if ($tables[$count3] == "school"){
						if($count4>0) $sql.=" and ";
						$sql.="(graduate.student_no=educationalbg.studentno and educationalbg.school=school.school_no)";
						$count4++;
					}
					else if($tables[$count3] != "graduate"){
						if($count4>0) $sql.=" and ";
						$sql.="graduate.student_no=".$tables[$count3].".studentno";
						$count4++;
					}
				}
				if(count($condition)>0){
					$sql.=" and ";
				}
			}
			else{
				if(count($condition)>0) $sql.=" where ";
			}
			for($i=0; $i<count($condition); $i++) {
				if($i>0) $sql.=" and ";
				// else $sql.=" where ";
				$sql.=$condition[$i];
			}
		}
		else{
			echo "<br>Details unconstrained by an alumni.<br>";
		}
		return $sql;
	}

	function cond_value($arr, $details){							// recursive function
		// echo "cond_value<br>";
		// var_dump($arr);
		$condition=array();
		foreach ($arr as $untokencond) {
			// var_dump($untokencond);
			$tokencond=$this->convert_value($untokencond);
			// var_dump($tokencond);
			if($tokencond[0] == "Not Equals"){
				$condition[]="NOT(".$details[0].".".$details[1]."='".$tokencond[1]."')";
			}
			else{
				if($tokencond[1] == '') $condition[]="(".$details[0].".".$details[1]." is null or ".$details[0].".".$details[1]."='')";
				$condition[]=$details[0].".".$details[1].$tokencond[0]."'".$tokencond[1]."'";
			}
		}
		return $condition;	// returns an array
	}

	function cond_or($arr, $details){								// recursive function
		echo "cond_or<br>";
		var_dump($arr);
		$whole="";
		$strand="";
		$strval="";
		$valpresent=0;

		if(array_key_exists('Value', $arr)) $valpresent=1;
		if($valpresent == 0){		// all and operations
			for($i=0; $i<count($arr)-1; $i++){
				if (array_key_exists('And', $arr[$i])){	// or ang sunod
					$strand=$this->cond_and($arr[$i]['And'], $details);
					if($whole != "") $whole.=" or ".$strand; 
					else $whole=$strand;
				}
			}
		}
		else{
			$strval=$this->cond_value($arr['Value'], $details);
			// var_dump($strval);
			foreach ($strval as $str) {
				if(! empty($whole)) $whole.=" or ".$str; 
				else $whole=$str;
			}
			for($i=0; $i<count($arr)-1; $i++){
				if (array_key_exists('And', $arr[$i])){	// or ang sunod
					$strand=$this->cond_and($arr[$i]['And'], $details);
					if($whole != "") $whole.=" or ".$strand; 
					else $whole=$strand;
				}
			}
		}

		echo "<br>$whole<br>";

		return "(".$whole.")";
	}

	function cond_and($arr, $details){							// recursive function
		echo "cond_and<br>";
		var_dump($arr);
		$whole="";
		$stror="";
		$strval="";
		$valpresent=0;

		if(array_key_exists('Value', $arr)) $valpresent=1;
		if($valpresent == 0){		// all and operations
			for($i=0; $i<count($arr)-1; $i++){
				if (array_key_exists('Or', $arr[$i])){	// and ang sunod
					$stror=$this->cond_or($arr[$i]['Or'], $details);
					if($whole != "") $whole.=" and ".$stror; 
					else $whole=$stror;
				}
			}
		}
		else{
			$strval=$this->cond_value($arr['Value'], $details);
			// var_dump($strval);
			foreach ($strval as $str) {
				if(! empty($whole)) $whole.=" or ".$str; 
				else $whole=$str;
			}
			for($i=0; $i<count($arr)-1; $i++){
				if (array_key_exists('Or', $arr[$i])){	// and ang sunod
					$stror=$this->cond_or($arr[$i]['Or'], $details);
					if($whole != "") $whole.=" and ".$stror; 
					else $whole=$stror;
				}
			}
		}

		echo "<br>$whole<br>";

		return "(".$whole.")";
	}

	function convert_value($str){
		$tokens=explode(",", $str);
		if($tokens[0] == "Equals") return array("=", $tokens[1]);
		if($tokens[0] == "Not Equals") return array("Not Equals", $tokens[1]);
		if($tokens[0] == "Less Than") return array("<", $tokens[1]);
		if($tokens[0] == "Greater Than") return array(">", $tokens[1]);
		if($tokens[0] == "Less Than or Equal") return array("<=", $tokens[1]);
		if($tokens[0] == "Greater Than or Equal") return array(">=", $tokens[1]);
		if($tokens[0] == "Like") return array(" like ", $tokens[1]);
		if($tokens[0] == "Not Like") return array(" not like ", $tokens[1]);
	}

	function to_table_name($str){
		echo $str."<br>";
		$graduate=array("Student Number" => "student_no", "First Name" => "firstname", "Last Name" => "lastname", "Middle Name" => "midname", "Sex" => "sex", "Birth Date" => "bdate", "Email" => "email", "Mobile No" => "mobileno", "Tel No" => "telno");
		$educationalbg=array("Year Level" => "level", "Batch" => "batch", "Class" => "class", "Course" => "course");
		$school=array("School Name" => "name", "School Address" => "address");
		$work=array("Position" => "position", "Salary" => "salary", "Supervisor" => "supervisor", "Employment Status" => "employmentstatus", "Employment Start Date" => "datestart", "Employment End Date" => "dateend");
		$company=array("Company Name" => "name", "Company Address" => "address");
		$project=array("Project Title" => "project_title", "Project Description" => "projectdesc", "Project Start Date" => "datestart", "Project End Date" => "dateend");
		$publication=array("Publication Title" => "publicationtitle", "Publication Date" => "publicationdate", "Publication Description" => "publicationdesc", "Publisher" => "publicationbody", "Peers" => "publicationpeers");
		$awards=array("Award Title" => "awardtitle", "Awarding Body" => "awardbody", "Awarding Date" => "dategiven");
		$grant=array("Grant Name" => "grant_name", "Grant Awarding Body" => "grantor", "Grant Type" => "granttype", "Grant Effective Year" => "grantyear");
		$others=array("Ability" => "ability", "Association" => "assoc_name", "Language" => "language");

		if(array_key_exists($str, $graduate)) return array("graduate", $graduate[$str]);
		else if(array_key_exists($str, $educationalbg)) return array("educationalbg", $educationalbg[$str]);
		else if(array_key_exists($str, $school)) return array("school", $school[$str]);
		else if(array_key_exists($str, $work)) return array("work", $work[$str]);
		else if(array_key_exists($str, $company)) return array("company", $company[$str]);
		else if(array_key_exists($str, $project)) return array("project", $project[$str]);
		else if(array_key_exists($str, $publication)) return array("publication", $publication[$str]);
		else if(array_key_exists($str, $awards)) return array("awards", $awards[$str]);
		else if(array_key_exists($str, $grant)) return array("grant", $grant[$str]);
		else if($str == "Ability") return array("ability", "ability_name");
		else if($str == "Association") return array("association", "assoc_name");
		else if($str == "Language") return array("language", "language");
		else return false;
	}

	public function query(){					// validate values 
		$str = $this->input->post('values');
		// echo $str;
		ini_set('xdebug.var_display_max_depth', 10);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		

		if($str == null){
			echo "Empty query";
			return;
		}
		$fields=explode("&", $str);
		// var_dump($fields);

		$arr=array();
		for($i=0; $i<count($fields); $i++) {
			$temp=explode(":", $fields[$i]);
			if(isset($temp[1])){
				$arr[$temp[0]]=null;
				// var_dump($temp[1]);
				$this->recursive_bracket_parser($temp[1], 0, $arr/*[count($arr)-1]*/[$temp[0]]);
			}
			else $arr[$temp[0]]=null;
		}

		if(! $arr){
			echo "<br><br>Invalid query.";
			return;
		}

		// var_dump($arr);
		$sql=$this->create_query($arr);
		echo "<br>search for: $sql";
		$results=$this->model_interactive_search->get_data($sql);
		var_dump($results);
	}
}  
