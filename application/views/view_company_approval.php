<!--
	Shows the list of all companies that are yet to be approved
-->

<script type="text/javascript">
	window.onload=get_data("companyname", "asc");						// perform get_data after the page completely loads

	function get_data(sort, order){  
		$.ajax({														// ajax call on getting the list of companies that are yet to be approved
			url: base_url+"controller_company_approval/get_company_requests/"+sort+"_"+order,
			type: 'POST',

			success: function(result){									// show results
				$('#change_here_company').html(result);
			},
			error: function(err){										// show error on call
				$('#change_here_company').html(err);
			}
		});
	}

	$(document).ready(function(){
		$(document).on("click", ".approve", function(event){			// function to be executed when a company is approved
			event.preventDefault();
			var company_no = $(this).parent()[0].getAttribute('class');
			var item=$(this);
			
			$.ajax({
				url: base_url+"controller_company_approval/company_approve/"+company_no,
				type: 'POST',

				success: function(result){								// if approving was successfully updated on the server, update values 
					item.addClass("disabled-button");					// button's css updated to disabled
					item.val("Approved");								// update value on button. state that the company is already approved
					item.attr("disabled", "disabled");					// change button attribute to be disabled
				},
				error: function(err){
					$('#change_here_company').html(err);				// on error, state error
				}
			});
		})
	})
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="all_alumni">
			<h3>Approval of Company Entries</h3>
			<div id="change_here_company"> </div>						<!-- List of unapproved companies will be shown here -->
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
