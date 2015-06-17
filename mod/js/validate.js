/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

// BASIC SEARCH

// validate basic search values
function validateSearch(){
	if(validateStdNo() && validateFname() && validateLname() && validateEmail()){
		return true;
	}
	else{
		return false;
	}
}

function validateStdNo(){
	msg="";
	str=basicsearch.stdno.value.trim();
	document.getElementsByName("stdnoerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[12][0-9]{3}\-[0-9]{5}$/)){
		msg="Invalid Input: Must be xxxx-xxxxx";
		document.getElementsByName("stdnoerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

function validateFname(){
	msg="";
	str=basicsearch.fname.value.trim();
	document.getElementsByName("fnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*\.?((\.\s[A-Za-zñÑ]{2}[A-Za-zñÑ\s]*\.?)|(\s[A-Za-zñÑ][A-Za-zñÑ]{1,2}\.)|(-[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*))*$/)){ 
		msg="Invalid Input: Must be between 2-50 alpha characters!";
		document.getElementsByName("fnameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

function validateLname(){
	msg="";
	str=basicsearch.lname.value.trim();
	document.getElementsByName("lnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^([A-Za-zñÑ]){1}([A-Za-zñÑ]){1,}(\s([A-Za-zñÑ]){1,})*(\-([A-Za-zñÑ]){1,}){0,1}$/)){ 
		msg="Invalid Input: Must be between 2-50 alpha characters!";
		document.getElementsByName("lnameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

function validateEmail(){
	msg="";
	str=basicsearch.email.value.trim();
	document.getElementsByName("emailerr")[0].innerHTML=msg;

	if(str=="") return true;
	else if (!str.match(/^[A-Za-zñÑ][A-Za-zñÑ\-0-9\._]{3,20}@[A-Za-zñÑ0-9]{3,8}\.[A-Za-zñÑ]{3,5}(\.[A-Za-zñÑ]{2,3}){0,1}$/)){  
		msg+="Enter valid email.";
		document.getElementsByName("emailerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
}


// EDIT USER INFORMATION

// validate initial information of user
function validateEditInfo(){
	if(validateENo() && validateEditFname() && validateEditLname()){
		if($("#enolog").text()=="Employee Number is available."){
			return true;
		}
	}
	return false;
}

// validate employee number
function validateENo(){
	msg="";
	str=editinfo.eno.value.trim();
	document.getElementsByName("enoerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[0-9]{9}$/)){
		msg="Invalid Input: Must be 9 numeric characters!";
		document.getElementsByName("enoerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate first name
function validateEditFname(){
	msg="";
	str=editinfo.fname.value.trim();
	document.getElementsByName("fnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*\.?((\.\s[A-Za-zñÑ]{2}[A-Za-zñÑ\s]*\.?)|(\s[A-Za-zñÑ][A-Za-zñÑ]{1,2}\.)|(-[A-Za-zñÑ]{1}[A-Za-zñÑ\s]*))*$/)){ 
		msg="Invalid Input: Must be between 2-50 alpha characters!";
		document.getElementsByName("fnameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate last name
function validateEditLname(){
	msg="";
	str=editinfo.lname.value.trim();
	document.getElementsByName("lnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^([A-Za-zñÑ]){1}([A-Za-zñÑ]){1,}(\s([A-Za-zñÑ]){1,})*(\-([A-Za-zñÑ]){1,}){0,1}$/)){ 
		msg="Invalid Input: Must be between 2-50 alpha characters!";
		document.getElementsByName("lnameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate update values of school details
function validateSchoolEdit(){
	if(validateSchoolName() && validateSchoolCountry() && validateSchoolProvinceState()) return true;
	return false;
}

//validate school name
function validateSchoolName(){
	msg="";
	str=schooledit.sname.value.trim();
	document.getElementsByName("snameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[A-Za-zñÑ\s][A-Za-zñÑ0-9\s]+$/)){ 
		msg="Invalid Input: Alphanumeric characters only!";
		document.getElementsByName("snameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate school's country iso code
function validateSchoolCountry(){
	msg="";
	str=schooledit.country.value.trim();
	document.getElementsByName("saddcountryerr")[0].innerHTML=msg;
	if(str=="-1"){ 
		msg="Required!";
		document.getElementsByName("saddcountryerr")[0].innerHTML=msg;
	}
	else if (!str.match(/^[A-Z]{2}$/)){ 
		msg="Invalid Input: Alpha characters only!";
		document.getElementsByName("saddcountryerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}


//validate school's province iso code
function validateSchoolProvinceState(){
	msg="";
	str=schooledit.state.value.trim();
	document.getElementsByName("saddprovinceerr")[0].innerHTML=msg;
	if(str=="-1") return true;
	else if (!str.match(/^[A-Z]{2}[\-\_][A-Z0-9]{2,3}$/)){ 
		msg="Invalid Input: Alphanumeric (with - and _) characters only!";
		document.getElementsByName("saddprovinceerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate update value of company details
function validateCompanyEdit(){
	if(validateCompanyName() && validateCompanyType() && validateCompanyCountry() && validateCompanyProvinceState()) return true;
	return false;
}

// validate company name
function validateCompanyName(){
	msg="";
	str=companyedit.cname.value.trim();
	document.getElementsByName("cnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[A-Za-zñÑ\s][A-Za-zñÑ0-9\s]+$/)){ 
		msg="Invalid Input: Alphanumeric characters only!";
		document.getElementsByName("cnameerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate company type
function validateCompanyType(){
	msg="";
	str=companyedit.ctype.value.trim();
	document.getElementsByName("ctypeerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[01]$/)){ 
		msg="Invalid Input!";
		document.getElementsByName("ctypeerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate company's country iso code
function validateCompanyCountry(){
	msg="";
	str=companyedit.country.value.trim();
	document.getElementsByName("caddcountryerr")[0].innerHTML=msg;
	if(str=="-1"){ 
		msg="Required!";
		document.getElementsByName("caddcountryerr")[0].innerHTML=msg;
	}
	else if (!str.match(/^[A-Z]{2}$/)){ 
		msg="Invalid Input: Alpha characters only!";
		document.getElementsByName("caddcountryerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}

// validate company's state/province iso code
function validateCompanyProvinceState(){
	msg="";
	str=companyedit.state.value.trim();
	document.getElementsByName("caddprovinceerr")[0].innerHTML=msg;
	if(str=="-1") return true;
	else if (!str.match(/^[A-Z]{2}[\-\_][A-Z0-9]{2,3}$/)){ 
		msg="Invalid Input: Alphanumeric (with - and _) characters only!";
		document.getElementsByName("caddprovinceerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}