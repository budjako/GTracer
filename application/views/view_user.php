<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";
	window.onload = get_data;

	function get_data(){  
		$.ajax({
			url: base_url+"controller_users/get_users_data", 

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
			<h3>System Users</h3>
			<center class="centersort">
				<div class="sortform">
					<form method="post" id="sort_list" name="sort_list">
						<span>Sort by 
							<select id = "sort_by" name ="sort_by" onchange = "get_data();" onload = "get_data();">
								<option value="emp_no" selected="selected">Employee Number</option>
								<option value="name">Name</option>
								<option value="email">Email</option>
							</select>
						</span><br>
						<span>	 
							<input type="radio" id="order_by_asc" onchange = "get_data();" value="asc" name="order_by" checked="checked"><label for="order_by_asc">Ascending</label></input>
							<input type="radio" id="order_by_desc" onchange = "get_data();" value="desc" name="order_by"><label for="order_by_desc">Descending</label></input>
						</span>
					</form>
				</div>
			</center>
			<div id="change_here"> </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/script.js"></script>
