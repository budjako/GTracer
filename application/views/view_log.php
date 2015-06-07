<script type="text/javascript">
	var emp_no;
	<?php if(isset($empno)){ ?>
	emp_no = "<?php echo $empno?>";
	<?php }?>
	var base_url = "<?php echo base_url() ?>";
	window.onload = get_data("empno", "asc");

	function get_data(sort, order){  
		if(emp_no === undefined){
			$.ajax({
				url: base_url+"controller_log/get_log_data/"+sort+"_"+order,
				type: 'POST',

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
				url: base_url+"controller_log/spec_user/"+sort+"_"+order+"_"+emp_no,
				type: 'POST',

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
</script>
<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Logs</h3>
		<div id="change_here"> </div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/ajax.js"></script>
