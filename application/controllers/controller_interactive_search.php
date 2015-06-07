<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller_interactive_search extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_interactive_search');	
		$this->load->library('Jquery_pagination');
		$this->load->library('pagination');
	}

	function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		
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
			if (strpos($str, "And", $i) === $i) {
				$array[]['And']=null;
				$op='And';
				$i+=3;
				continue;
			}
			else if (strpos($str, "Or", $i) === $i) {
				$array[]['Or']=null;					// add new item with or as value(another array)
				
				$op='Or';
				$i+=2;
				continue;
			}
			else if (strpos($str, "Val", $i) === $i) {
				if($array==null) $array['Value']=null;
				$op='Value';
				$i+=3;
				continue;
			}
			else if ($str[$i] === '('){
				if($op == "Value") $i = $this->recursive_bracket_parser($str, $i+1, $array['Value']);
				else{
					if(array_key_exists('Value', $array)){
						$i = $this->recursive_bracket_parser($str, $i+1, $array[count($array)-2][$op]);
					}
					else{
						$i = $this->recursive_bracket_parser($str, $i+1, $array[count($array)-1][$op]);
					}
				}
			}
			else if ($str[$i] == ')'){			// end token return to calling function
				$i++;
				if($tempstring != null){
					if(!isset($array)) $array=array();
					$array[]=$tempstring;
				}
				return $i;
			}
			else{
				if($str[$i] == ',' && $tempstring == ""){
					$i++;
					continue;
				}
				$tempstring.=$str[$i];
				$i++;
			}
		}
		return false;
	}

	function create_query($arr, $graphingfactor=null, $mapfactor=null){
		$tables=array();
		$selected=array();
		$sql="";
		$condition=array();
		// echo $mapfactor;
		$selct=$graduate=$school=$company=$work=$educationalbg=0;
		// var_dump($arr);

		// $item as items in array: [0], [1], etc.
		$fields=array_keys($arr);
		foreach ($fields as $item){
			// var_dump($item);
			$details=$this->to_table_name($item);
			if(! in_array($details[0], $tables)) $tables[]=$details[0];		// list of table names involved
			$selected[]=$details[1];										// list of field names involved
			if($selct>0) $sql.=", ";
			$sql.=$details[0].".".$details[1];
			if($details[0] == "graduate") $graduate=1;
			if($details[0] == "company") $company=1;
			if($details[0] == "school") $school=1;
			if($details[0] == "work") $work=1;
			if($details[0] == "educationalbg") $educationalbg=1;
			// echo "$sql<br>";
			// echo "$selct<br>";
			$selct++;
			// set conditions
			// var_dump($arr);
			if($arr[$item]!=null){
				if(array_key_exists('Value', $arr[$item])){		// Single Constraint
					$val=$this->cond_value($arr[$item]['Value'], $details);
					$condition[]=$val[0];
				}
				else if($arr[$item][0]!=null){
					if(array_key_exists('Or', $arr[$item][0])){
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
		if(! in_array("graduate", $tables) && $mapfactor == null && $graphingfactor == null){
			$sql="distinct ".$sql;
		}
		if($mapfactor != null){
			if($mapfactor == "curadd"){
				if(! in_array("graduate", $tables)){
					$tables[]="graduate";
					$graduate=1;
				}
			}
			else if($mapfactor == "cadd"){
				if(! in_array("company", $tables)){
					$tables[]="company";
					$company=1;
				}
				if(! in_array("work", $tables)){
					$tables[]="work";
					$work=1;
				}
			}
			else if($mapfactor == "sadd"){
				if(! in_array("school", $tables)){
					$tables[]="school";
					$school=1;
				}
			}
		}

		for($count2=0; $count2<$tabcount; $count2++){
			if($count2>0) $sql.=", ";
			if($tables[$count2] == "work") $company=2;
			if($tables[$count2] == "educationalbg") $school=2;
			$sql.="`".$tables[$count2]."`";
		}
		if($company == 1 && $graduate == 1){
			$sql.=", `work`";
			$work=1;
		}
		if($school == 1 && $graduate == 1) $sql.=", `educationalbg`";
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
						$sql.="(graduate.student_no=educationalbg.studentno and educationalbg.schoolno=school.school_no)";
						$count4++;
					}
					else if($tables[$count3] != "graduate"){
						if($count4>0) $sql.=" and ";
						$sql.="graduate.student_no=".$tables[$count3].".studentno";
						$count4++;
					}
				}
				if($work==1){
					$sql.=" and work.currentjob=1";
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
			$prev=0;
			// echo "<br>Details unconstrained by an alumni.<br>";
			// echo $work;
			// echo $company;
			if(count($condition)>0) $sql.=" where ";
			if($work>0 && $company>0 && $graduate>0){
				if(count($condition)==0) $sql.=" where ";
				$prev=1;
				$sql.="`work`.companyno=`company`.company_no";
			}
			if($school>0 && $educationalbg>0 && $graduate>0){
				if($prev==0 && count($condition)==0) $sql.=" where ";
				$prev=1;
				$sql.="`school`.school_no=`educationalbg`.schoolno";
			}
			for($i=0; $i<count($condition); $i++) {
				if($i>0 || $prev==1) $sql.=" and ";
				// else $sql.=" where ";
				$sql.=$condition[$i];
			}
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
		// echo "cond_or<br>";
		// var_dump($arr);
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

		// echo "<br>$whole<br>";

		return "(".$whole.")";
	}

	function cond_and($arr, $details){							// recursive function
		// echo "cond_and<br>";
		// var_dump($arr);
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

		// echo "<br>$whole<br>";

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
		// echo $str."<br>";
		$graduate=array("Student Number" => "student_no", "First Name" => "firstname", "Last Name" => "lastname", "Middle Name" => "midname", "Sex" => "sex", "Birth Date" => "bdate", "Email" => "email", "Mobile No" => "mobileno", "Tel No" => "telno");
		$educationalbg=array("Level" => "level", "Batch" => "batch", "Class" => "class", "Course" => "course");
		$school=array("School Name" => "schoolname");
		$work=array("Position" => "position", "Salary" => "salary", "Supervisor" => "supervisor", "Employment Status" => "employmentstatus", "Employment Start Date" => "workdatestart", "Employment End Date" => "workdateend");
		$company=array("Company Name" => "companyname");
		$project=array("Project Title" => "project_title", "Project Description" => "projectdesc", "Project Start Date" => "projectdatestart", "Project End Date" => "projectdateend");
		$publication=array("Publication Title" => "publicationtitle", "Publication Date" => "publicationdate", "Publication Description" => "publicationdesc", "Publisher" => "publicationbody", "Peers" => "publicationpeers");
		$awards=array("Award Title" => "awardtitle", "Awarding Body" => "awardbody", "Awarding Date" => "awarddategiven");
		$grant=array("Grant Name" => "grant_name", "Grant Awarding Body" => "grantor", "Grant Type" => "granttype", "Grant Effective Year" => "grantyear");

		if(array_key_exists($str, $graduate)) return array("graduate", $graduate[$str]);
		else if(array_key_exists($str, $educationalbg)) return array("educationalbg", $educationalbg[$str]);
		else if(array_key_exists($str, $school)) return array("school", $school[$str]);
		else if(array_key_exists($str, $work)) return array("work", $work[$str]);
		else if(array_key_exists($str, $company)) return array("company", $company[$str]);
		else if(array_key_exists($str, $project)) return array("project", $project[$str]);
		else if(array_key_exists($str, $publication)) return array("publication", $publication[$str]);
		else if(array_key_exists($str, $awards)) return array("award", $awards[$str]);
		else if(array_key_exists($str, $grant)) return array("grant", $grant[$str]);
		else if($str == "Ability") return array("ability", "ability_name");
		else if($str == "Association") return array("association", "assoc_name");
		else if($str == "Language") return array("language", "language");
		else return false;
	}

	function to_standard_name($str){
		// echo $str."<br>";
		$graduate=array( "student_no" => "Student Number",  "firstname" => "First Name",  "lastname" => "Last Name",  "midname" => "Middle Name",  "sex" => "Sex",  "bdate" => "Birth Date",  "email" => "Email",  "mobileno" => "Mobile No",  "telno" => "Tel No");
		$educationalbg=array( "level" => "Level",  "batch" => "Batch",  "class" => "Class",  "course" => "Course");
		$school=array( "schoolname" => "School Name",  "schooladdress" => "School Address");
		$work=array( "position" => "Position",  "salary" => "Salary",  "supervisor" => "Supervisor",  "employmentstatus" => "Employment Status",  "workdatestart" => "Employment Start Date",  "workdateend" => "Employment End Date");
		$company=array( "companyname" => "Company Name",  "companyaddress" => "Company Address");
		$project=array( "project_title" => "Project Title",  "projectdesc" => "Project Description",  "projectdatestart" => "Project Start Date",  "projectdateend" => "Project End Date");
		$publication=array( "publicationtitle" => "Publication Title",  "publicationdate" => "Publication Date",  "publicationdesc" => "Publication Description",  "publicationbody" => "Publisher",  "publicationpeers" => "Peers");
		$awards=array( "awardtitle" => "Award Title",  "awardbody" => "Awarding Body",  "awarddategiven" => "Awarding Date");
		$grant=array( "grant_name" => "Grant Name",  "grantor" => "Grant Awarding Body",  "granttype" => "Grant Type",  "grantyear" => "Grant Effective Year");

		if(array_key_exists($str, $graduate)) return array("graduate", $graduate[$str]);
		else if(array_key_exists($str, $educationalbg)) return array("educationalbg", $educationalbg[$str]);
		else if(array_key_exists($str, $school)) return array("school", $school[$str]);
		else if(array_key_exists($str, $work)) return array("work", $work[$str]);
		else if(array_key_exists($str, $company)) return array("company", $company[$str]);
		else if(array_key_exists($str, $project)) return array("project", $project[$str]);
		else if(array_key_exists($str, $publication)) return array("publication", $publication[$str]);
		else if(array_key_exists($str, $awards)) return array("award", $awards[$str]);
		else if(array_key_exists($str, $grant)) return array("grant", $grant[$str]);
		else if($str == "ability_name") return array("ability", "Ability");
		else if($str == "assoc_name") return array("association", "Association Name");
		else if($str == "language") return array("language", "Language");
		else return false;
	}

	public function query_table(){					// validate values 
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		// echo "POST";
		// var_dump($this->input->post());
		$str = addslashes($this->input->post('values')); 
		// echo $str;
		if($str == null){
			// echo "Empty query";
			return;
		}

		// LEXICAL ANALYSIS

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
			// echo "<br><br>Invalid query.";
			return;
		}
		// return;
		// var_dump($arr);
		$sql="select ";
		if(count($fields) == 1) $sql.="distinct ";
		$sql.=$this->create_query($arr);
		$sort_by=$this->to_table_name($this->input->post('sort_by'));
		$sort_by=$sort_by[1];
		// echo $sort_by;
		$order_by=$this->input->post('order_by');
		$sql.=" order by ".$sort_by." ".$order_by;
		// echo "<br>search for: $sql";
		// $sql="select distinct educationalbg.class, course from `educationalbg`";

		$config['base_url'] = base_url().'controller_interactive_search/query_table';
		$config['total_rows'] = $config['total_rows'] = $this->model_interactive_search->get_data_count($sql);
		$config['per_page'] = '20';
		$config['div'] = '#change_here_table';
		$config['additional_param']  = 'serialize_form()';

		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		// echo "<br>Page: $page<br>";
		$data['result'] = $this->model_interactive_search->get_data_paginate($sql, $config['per_page'], $page);
		// var_dump($data['result']);
		//display data from database
		
		//initialize the configuration of the ajax_pagination
		$this->jquery_pagination->initialize($config);
		//create links for pagination
		$data['links'] = $this->jquery_pagination->create_links($sort_by, $order_by);
		// var_dump($data['links']);
		$this->print_results($sort_by, $order_by, $data['result'],$data['links'], $config);
	}

	public function print_results($sort_by, $order_by, $result, $links, $config){
		echo $links;
		// var_dump($result);
		if(! count($result)) echo "<h3>No results.<h3>";
		// var_dump($result);
		if($result!=null){
			$keys=array_keys($result[0]);
			echo "<table class='table table-hover table-bordered'>";
			foreach($keys as $key){

				$key_table=$this->to_standard_name($key);
				$serialised_form=$config['additional_param'];
				if($sort_by=="".$key.""){
					// echo $order_by;
					if($order_by=="asc"){
						// echo "<script type='text/javascript'> $(document).ready( function(){ $('#sortby').val('".$key_table[1]."'); $('#orderby').val('asc'); });</script>";
						echo "<th><a href='javascript:void(0);' onclick=\"$('#sortby').val('".$key_table[1]."'); $('#orderby').val('desc'); console.log('haha1');  $.post('".base_url()."controller_interactive_search/query_table', ".$serialised_form.", function(data){ $('#change_here_table').html(data);  }); return false;\">".$key_table[1]."<span class='caretdown'></span></a></th>";
						
					}
					else if($order_by=="desc"){
						// echo "<script type='text/javascript'>$('#scripts').html($('#sortby').val('".$key_table[1]."');  $('#orderby').val('asc'); );</script>";
						
						// echo "<script type='text/javascript'> $(document).ready( function(){ $('#sortby').val('".$key_table[1]."'); $('#orderby').val('desc'); });</script>";
						echo "<th><a href='javascript:void(0);' onclick=\"$('#sortby').val('".$key_table[1]."'); $('#orderby').val('asc');console.log('haha2');   $.post('".base_url()."controller_interactive_search/query_table', ".$serialised_form.", function(data){ $('#change_here_table').html(data); }); return false;\">".$key_table[1]."<span class='caretup'></span></a></th>";
					}
				}
				else{
					
					// echo "<script type='text/javascript'> $(document).ready( function(){ $('#sortby').val('".$key_table[1]."'); $('#orderby').val('asc'); });</script>";
					// echo "<script type='text/javascript'>$('#scripts').html($('#sortby').val('".$key."');  $('#orderby').val('desc'); );</script>";
					echo "<th><a href='javascript:void(0);' onclick=\"$('#sortby').val('".$key_table[1]."'); $('#orderby').val('desc'); console.log('haha3');  $.post('".base_url()."controller_interactive_search/query_table', ".$serialised_form.", function(data){ $('#change_here_table').html(data);  }); return false;\">".$key_table[1]."<span class='caretdown'></span></a></th>";
				}

			}
		}
		foreach ($result as $row){

			echo "<tr>";
			foreach($keys as $key){
				echo "<td>".$row[$key]."</td>";
			}
			echo "</tr>";
		} 
		echo "</table>";
		echo $links;
	}

	public function query_chart(){
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		// echo "POST";
		$this->input->post('serialised_form');
		// var_dump($this->input->post());
		$str = addslashes($this->input->post('values')); 
		// echo $str;
		if($str == null){
			// echo "Empty query";
			return;
		}

		// LEXICAL ANALYSIS
		$graphingfactor=$this->to_table_name($this->input->post('chartgraphingfactor'));
		$graphingfactor=$graphingfactor[1];		// index 0 is table name, 1 is field name
		$fields=explode("&", $str);

		$arr=array();
		for($i=0; $i<count($fields); $i++) {
			$temp=explode(":", $fields[$i]);
			if(isset($temp[1])){
				$arr[$temp[0]]=null;
				$this->recursive_bracket_parser($temp[1], 0, $arr/*[count($arr)-1]*/[$temp[0]]);
			}
			else $arr[$temp[0]]=null;
		}

		if(! $arr){
			// echo "<br><br>Invalid query.";
			return;
		}

		$sql="select count(*) as `num`, ";
		$sql.=$this->create_query($arr, $graphingfactor);
		// echo "no group by sql: ".
		$sql.=" group by `".$graphingfactor."`";
		// echo "<br>search for: $sql";


		$data['result'] = $this->model_interactive_search->get_data($sql);
		// var_dump($data['result']);
		$retval['categories']=array();
		$retval['count']=array();
		$retval['factor']=array($this->input->post('chartgraphingfactor'));
		$retval['graphtype']=array($this->input->post('graphtype'));

		foreach($data['result'] as $result){
			$retval['categories'][]=$result[$graphingfactor];
			$retval['count'][]=$result['num'];
		}

		// var_dump($retval);
		echo json_encode($retval);
	}


	public function query_map(){	// results on country level
		if($this->session->userdata('logged_in') == FALSE){
			redirect('controller_login', 'refresh');// redirect to controller_search_book
		}
		// var_dump($this->input->post());
		$str = addslashes($this->input->post('values')); 
		// // echo $str;
		if($str == null){
			// echo "Empty query";
			return;
		}

		// // LEXICAL ANALYSIS
		$mapfactor=$this->input->post('mapfactor');
		$fields=explode("&", $str);

		$arr=array();
		for($i=0; $i<count($fields); $i++) {
			$temp=explode(":", $fields[$i]);
			if(isset($temp[1])){
				$arr[$temp[0]]=null;
				$this->recursive_bracket_parser($temp[1], 0, $arr/*[count($arr)-1]*/[$temp[0]]);
			}
			else $arr[$temp[0]]=null;
		}

		if(! $arr){
			// echo "<br><br>Invalid query.";
			return;
		}

		$sql="select count(*) as `num`, ";
		if($mapfactor == "curadd"){
			$sql.="graduate.curaddcountry as country, graduate.curaddcountrycode as countrycode, graduate.curaddregion as region, graduate.curaddregioncode as regioncode, graduate.curaddprovince as province, graduate.curaddprovincecode as provincecode, ";
		}
		else if($mapfactor == "cadd"){
			$sql.="company.caddcountry as country, company.caddcountrycode as countrycode, company.caddregion as region, company.caddregioncode as regioncode, company.caddprovince as province, company.caddprovincecode as provincecode, ";
		}
		else if($mapfactor == "sadd"){
			$sql.="school.saddcountry as country, school.saddcountrycode as countrycode, school.saddregion as region, school.saddregioncode as regioncode, school.saddprovince as province, school.saddprovincecode as provincecode, ";
		}
		$sql.=$this->create_query($arr, false, $mapfactor);
		// echo "no group by sql: ".
		// concatenate where in sql
		$sql.=" group by country, countrycode, region, regioncode, province, provincecode";

		// echo $sql;
		$data['result'] = $this->model_interactive_search->get_data($sql);
		// var_dump($data['result']);	// return a country level json
		$data['country']=array();
		$data['region']=array();
		$data['province']=array();

		foreach ($data['result'] as $item) {
			if(isset($data['country'][$item['country']])){
				$data['country'][$item['country']]+=$item['num'];
			}
			else{
				$data['country'][$item['country']]=$item['num'];
			}
		}
		foreach ($data['result'] as $item) {
			if(isset($data['province'][$item['province']])){
				$data['province'][$item['province']]+=$item['num'];
			}
			else{
				$data['province'][$item['province']]=$item['num'];
			}
		}
		// var_dump($data);
		echo json_encode($data);
	}

}	
