<script type="text/javascript">
	window.onload=get_data_company();

	function get_data_company(){  
		$.ajax({
			url: base_url+"controller_company_approval/get_company_requests",
			type: 'POST',

			success: function(result){
				$('#change_here_company').html(result);
			},
			error: function(err){
				$('#change_here_company').html(err);
			}
		});
	}

	$(document).ready(function(){
		$(document).on("click", ".approve", function(event){
			event.preventDefault();
			var company_no = $(this).parent()[0].getAttribute('class');
			var item=$(this);
			
			$.ajax({
				url: base_url+"controller_company_approval/company_approve/"+company_no,
				type: 'POST',

				success: function(result){
					item.addClass("disabled-button");
					item.val("Approved");
					item.attr("disabled", "disabled");
				},
				error: function(err){
					$('#change_here_company').html(err);
				}
			});
		})
	})
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="all_alumni">
			<h3>Approval of Company Entries</h3>
			<div id="change_here_company"> </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/script.js"></script>
