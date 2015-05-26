$(document).ready( function() {
		
	$(document).on("click", ".clickable-row", function(e) {
		var ev=e;
		var button = ev.target;
		if($(button).hasClass('ban') || $(button).hasClass('admin') || $(button).hasClass('approve') || $(button).hasClass('delete') || $(button).hasClass('schoolmerge') || $(button).hasClass('companymerge')) {
			ev.stopPropagation();
		}	
		else window.document.location = $(this).data("href");
	});

	$(document).on("click", ".schoolmerge", function(e) {
		event.preventDefault();

		var origentry =$('#sno').val();
		var schoolmerge = $(this).parent()[0].getAttribute('class');
		var string=origentry+"_"+schoolmerge;

		$.ajax({
			type: "POST",
			url: base_url + 'controller_school/merge_school/'+string,

			success: function(data) {
				window.document.location = base_url + "controller_school/index/"+schoolmerge; 
			},
			error: function(err) {
				console.log("error "+err);
			}
		});
	});

	$(document).on("click", ".companymerge", function(e) {
		event.preventDefault();

		var origentry =$('#cno').val();
		var company = $(this).parent()[0].getAttribute('class');
		var string=origentry+"_"+company;

		$.ajax({
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

	$(document).on("click", ".ban", function(e) {
		event.preventDefault();

		var empno = $(this).parent()[0].getAttribute('class');

		$.ajax({
			type: "POST",
			url: base_url + 'controller_users/ban/'+empno,
			data: {empno: empno},

			success: function(data) {
				var value = $('#'+empno+" .ban")[0].getAttribute('value');
				if(value == "Ban") $('#'+empno+" .ban")[0].setAttribute('value', "Unban");
				else $('#'+empno+" .ban")[0].setAttribute('value', "Ban");
			},
			error: function(err) {
				console.log("error "+err);
			}
		});
	});

	$(document).on("click", ".admin", function(e) {
		event.preventDefault();

		var empno = $(this).parent()[0].getAttribute('class');

		$.ajax({
			type: "POST",
			url: base_url + 'controller_users/admin/'+empno,
			data: {empno: empno},

			success: function(data) {
				$('#'+empno+" .ban").parent().remove();				//remove ban button
				$('#'+empno+" .admin").parent().remove();			// remove add admin button
			},
			error: function(err) {
				console.log(err);
			}
		});
	});

	$(document).on("click", ".delete", function(e) {
		event.preventDefault();

		var empno = $(this).parent()[0].getAttribute('class');
		var item=$(this);
		console.log(item);

		$.ajax({
			type: "POST",
			url: base_url + 'controller_users/delete_acct/'+empno,
			data: {empno: empno},

			success: function(data) {
				$('#'+empno+" .ban").parent().remove();				//remove ban button
				$('#'+empno+" .admin").parent().remove();			// remove add admin button
				item.addClass("disabled-button");
				item.val("Deleted");
				item.attr("disabled", "disabled");
			},
			error: function(err) {
				console.log(err);
			}
		});
	});

	$(document).on("change", ".country", function(){
		$(".state_dropdown").html("<option value='-1'>Select state</option>");
	});

	$(document).on("blur", ".country", function(){
		loadCountry();
	});

	$(".exportlog").click(function(){
		window.document.location = "export_logs";
	});
});

