/*
	Notes:	
		*	Edit email restrictions - uplbosa.org
*/

// BASIC SEARCH

function validateSearch(){
	if(validateStdNo() && validateFname() && validateMname() && validateLname() && validateEmail()){
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

function validateMname(){
	msg="";
	str=basicsearch.mname.value.trim();
	document.getElementsByName("mnameerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^([A-Za-zñÑ]){1}([A-Za-zñÑ]){1,}(\s([A-Za-zñÑ]){1,})*(\-([A-Za-zñÑ]){1,}){0,1}$/)){ 
		msg="Invalid Input: Must be between 2-50 alpha characters!";
		document.getElementsByName("mnameerr")[0].innerHTML=msg;
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
	else if (!str.match(/^[A-Za-z][A-Za-z-0-9\._]{3,20}@[A-Za-z0-9]{3,8}\.[A-Za-z]{3,5}(\.[A-Za-z]{2,3}){0,1}$/)){  
		msg+="Enter valid email. (@uplbosa.org) // update this!";
		document.getElementsByName("emailerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
}


// EDIT USER INFORMATION

function validateEditInfo(){
	if(validateENo() && validateEditFname() && validateEditLname() /*&& validateEditLname()*/){
		if($("#enolog").text()=="Employee Number is available."){
			return true;
		}
	}
	return false;
}

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

function validateEditEmail(){
	msg="";
	str=editinfo.email.value.trim();
	document.getElementsByName("emailerr")[0].innerHTML=msg;
	if(str=="") return true;
	else if (!str.match(/^[A-Za-z][A-Za-z-0-9\._]{3,20}@cia.uplbosa.org$/)){
		msg="Invalid Input: Must be a valid email address that has a domain of cia.uplbosa.org!";
		document.getElementsByName("emailerr")[0].innerHTML=msg;
	}
	if(msg=="") return true;
	return false;
}