<script type="text/javascript">
	var emp_no;
	<?php if(isset($empno)){ ?>
	emp_no = "<?php echo $empno?>";
	<?php }?>
	var base_url = "<?php echo base_url() ?>";
	window.onload = get_data;

	function get_data(){  
		if(emp_no === undefined){
			$.ajax({
				url: base_url+"controller_log/get_log_data",

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
		else{
			$.ajax({
				url: base_url+"controller_log/spec_user",

				type: 'POST',
				data: serialize_form(),

				success: function(result){
					$('#change_here').html("result: ");
					$('#change_here').html(result);
				},
				error: function(err){
					$('#change_here').html("error: ");
					$('#change_here').html(err);
				}
			});
		}
	}
	function serialize_form()
	{
		return $("#sort_list").serialize();
	}

</script>
<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Logs</h3>
		<center class="centersort">
			<div class="sortform">
				<form method="post" id="sort_list" name="sort_list">
					<?php 
						// var_dump($this->session->all_userdata());
						if(isset($empno)) echo "<input type='hidden' value=".$empno." id = 'emp_no' name ='emp_no'></input>" ?>
					<span>Sort by 
						<select id = "sort_by" name ="sort_by" onchange = "get_data();" onload = "get_data();">
							<option value="empno">Employee Number</option>
							<option value="activity">Activity</option>
							<option value="actdetails">Details</option>
							<option value="timeperformed" selected="selected">Time</option>
						</select>
					</span><br>
					<span>	 
						<input type="radio" id="order_by_asc" onchange = "get_data();" value="asc" name="order_by"><label for="order_by_asc">Ascending</label></input>
						<input type="radio" id="order_by_desc" onchange = "get_data();" value="desc" name="order_by" checked="checked"><label for="order_by_desc">Descending</label></input>
					</span>
				</form>
			</div>
		</center>
		<div id="change_here"> </div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
