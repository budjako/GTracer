<script type="text/javascript">
	window.onload=get_data_school(); 

	function get_data_school(){  
		$.ajax({
			url: base_url+"controller_school_approval/get_school_requests",
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
		$(document).on("click", ".approve", function(event){
			event.preventDefault();
			var school_no = $(this).parent()[0].getAttribute('class');
			var item=$(this);
			
			$.ajax({
				url: base_url+"controller_school_approval/school_approve/"+school_no,
				type: 'POST',

				success: function(result){
					console.log(result);
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
			<h3>Approval of School Entries</h3>
			<div id="change_here_school"> </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/script.js"></script>
