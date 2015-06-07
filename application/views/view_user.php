<script type="text/javascript">
	window.onload = get_data("empno", "asc");

	function get_data(sort, order){  
		$.ajax({
			url: base_url+"controller_users/get_users_data/"+sort+"_"+order,
			type: 'POST',

			success: function(result){
				$('#change_here').html(result);
			},
			error: function(err){
				$('#change_here').html(err);
			}
		});
	}
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="all_alumni">
			<h3>System Users</h3>
			<div id="change_here"> </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
