<script type="text/javascript">
	window.onload = get_data("studentno", "asc");

	function get_data(sort, order){  
		$.ajax({
			url: base_url+"controller_list_alumni/get_alumni_data/"+sort+"_"+order,

			type: 'POST',
			data: serialize_form(),

			success: function(result){
				$('#change_here').html(result);
			},
			error: function(err){
				$('#change_here').html(err);
			}
		});
	}

	function serialize_form()
	{
		return $("#sort_list").serialize();
	}
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="all_alumni">
			<h3>List of All Alumni</h3>
			<div id="change_here"> </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
