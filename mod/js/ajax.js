$(document).ready( function() {

	$(document).on("click", ".ban", function(e) {
		event.preventDefault();

		var empno = $(this).parent()[0].getAttribute('class');

		$.ajax({
			type: "POST",
			url: "ban/"+empno,
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
			url: "admin/"+empno,
			data: {empno: empno},

			success: function(data) {
				$('#'+empno+" .ban").parent().remove();				//remove ban button
				$('#'+empno+" .admin").parent().remove();			// remove add admin button
			},
			error: function(err) {
				console.log(err);
Number			}
		});
	});

	// $(".enosort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/emp_no/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".namesort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/name/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".emailsort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/email/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".snosort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/student_no/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".lsort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/lastname/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".fsort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/firstname/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	// $(".msort").click(function(){
	// 	event.preventDefault();

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "set_order_sort/midname/asc",
	// 		success: function(data){
	// 			console.log(data);
	// 			window.document.location  = 'index';
	// 		},
	// 		error: function(err) {
	// 			console.log(err);
	// 		}
	// 	});
	// });

	$(".exportlog").click(function(){
		// event.preventDefault();

		// console.log("export logs");
		// $.ajax({
		// 	type: "POST",
		// 	url: "export_logs",
		// 	success: function(data){
		// 		console.log(data);
		// 	}
		// });
		window.document.location = "export_logs";
	});
});