<!--
	Shows the list of all schools that are yet to be approved
-->

<script type="text/javascript">
	window.onload=get_data("schoolname", "asc");						// perform get_data after the page completely loads

	function get_data(sort, order){  
		$.ajax({														// ajax call on getting the list of schools that are yet to be approved
			url: base_url+"controller_school_approval/get_school_requests/"+sort+"_"+order,
			type: 'POST',

			success: function(result){
				$('#change_here_school').html(result);
			},
			error: function(err){
				$('#change_here_school').html(err);
			}
		});
	}

	$(document).ready(function(){
		$(document).on("click", ".approve", function(event){			// function to be executed when a school is approved
			event.preventDefault();
			var school_no = $(this).parent()[0].getAttribute('class');
			var item=$(this);
			
			$.ajax({
				url: base_url+"controller_school_approval/school_approve/"+school_no,
				type: 'POST',

				success: function(result){								// if approving was successfully updated on the server, update values 
					item.addClass("disabled-button");					// button's css updated to disabled
					item.val("Approved");								// update value on button. state that the school is already approved
					item.attr("disabled", "disabled");					// change button attribute to be disabled
				},
				error: function(err){
					$('#change_here_school').html(err);					// on error, state error
				}
			});
		})
	})
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="all_alumni">
			<h3>Approval of School Entries</h3>
			<div id="change_here_school"> </div>						<!-- List of unapproved schools will be shown here -->
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
