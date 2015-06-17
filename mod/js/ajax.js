$(document).ready( function() {
	// for clickable rows
	$(document).on("click", ".clickable-row", function(e) {				
		var ev=e;
		var button = ev.target;

		// stop redirecting page if button on row is clicked
		if($(button).hasClass('active') || $(button).hasClass('admin') || $(button).hasClass('approve') || $(button).hasClass('schoolmerge') || $(button).hasClass('companymerge')) {
			ev.stopPropagation();
		}	
		else window.document.location = $(this).data("href");
	});

	// if school merge button is clicked
	$(document).on("click", ".schoolmerge", function(e) {				
		event.preventDefault();

		var origentry =$('#sno').val();									// get the school number of existing school entry
		var schoolmerge = $(this).parent()[0].getAttribute('class');	// get the school number of unapproved school entry
		var string=origentry+"_"+schoolmerge;							// prepare string for ajax call

		$.ajax({														// ajax call for merging entries
			type: "POST",
			url: base_url + 'controller_school/merge_school/'+string,

			success: function(data) {									// redirect to the page of existing school entry if merging is successful
				window.document.location = base_url + "controller_school/index/"+schoolmerge; 
			},
			error: function(err) {
				console.log("error "+err);
			}
		});
	});

	// if company merge button is clicked
	$(document).on("click", ".companymerge", function(e) {
		event.preventDefault();

		var origentry =$('#cno').val();									// get the company number of existing company entry
		var company = $(this).parent()[0].getAttribute('class');		// get the company number of unapproved company entry
		var string=origentry+"_"+company;								// prepare string for ajax call

		$.ajax({														// ajax call for merging entries
			type: "POST",
			url: base_url + 'controller_company/merge_company/'+string,

			success: function(data) {
				window.document.location = base_url + "controller_company/index/"+company; 
			},
			error: function(err) {
				console.log("error "+err);
			}
		});
	});

	// if active button is clicked
	// activating and deactivating an account
	$(document).on("click", ".active", function(e) {	
		event.preventDefault();
		var empno = $(this).parent()[0].getAttribute('class');			// get employee number of account to be activated/deactivated

		$.ajax({
			type: "POST",
			url: base_url + 'controller_users/active/'+empno,
			data: {empno: empno},

			success: function(data) {
				var value = $('#'+empno+" .active")[0].getAttribute('value');								// get the employee number to be updated
				if(value == "Activate") $('#'+empno+" .active")[0].setAttribute('value', "Deactivate");		// change label from Activate to Deactivate
				else $('#'+empno+" .active")[0].setAttribute('value', "Activate");							// change label from Deactivate to Activate
			},
			error: function(err) {
				console.log("error "+err);
			}
		});
	});

	// if admin button is clicked
	// for adding new admin to the new system
	$(document).on("click", ".admin", function(e) {
		event.preventDefault();

		var empno = $(this).parent()[0].getAttribute('class');
		var r = confirm("Are you sure you want to add employee "+empno+" as an admin?");					// checking to make sure not accidental clicking
		if (r == true) {
			console.log(r);
		    $.ajax({
				type: "POST",
				url: base_url + 'controller_users/admin/'+empno,	
				data: {empno: empno},

				success: function(data) {
					$('#'+empno+" .active").parent().remove();												//remove ban button
					$('#'+empno+" .admin").parent().remove();												// remove add admin button
				},
				error: function(err) {
					console.log(err);
				}
			});
		}
	});

	// if country is updated
	$(document).on("change", ".country", function(){
		$(".state_dropdown").html("<option value='-1'>Select state</option>");
	});

	// if country is updated
	$(document).on("blur", ".country", function(){
		loadCountry();
	});

	$(".exportlog").click(function(){
		window.document.location = "export_logs";
	});
});

