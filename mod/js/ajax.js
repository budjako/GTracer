$(document).ready( function() {

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
		
	$(document).ready(function() {
		$(document).on("click", ".clickable-row", function(e) {
			var ev=e;
			var button = ev.target;
			ev.stopPropagation();
			if($(button).hasClass('ban') || $(button).hasClass('admin') || $(button).hasClass('approve') || $(button).hasClass('delete')) {
				ev.stopPropagation();
			}	
			else window.document.location = $(this).data("href");
		});
	});
});

