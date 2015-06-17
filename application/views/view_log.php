<!--
	Shows the list of all logs
-->

<script type="text/javascript">
	var emp_no;
	<?php if(isset($empno)){ ?>
		emp_no = "<?php echo $empno?>";
	<?php }?>
	window.onload = get_data("timeperformed", "desc");					// perform get_data after the page completely loads

	function get_data(sort, order){  
		if(emp_no === undefined){										// if there is no specified employee number, get all logs
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
		else{															// if there is a specified employee number, get the logs for that employee only
			$.ajax({
				url: base_url+"controller_log/spec_user/"+sort+"_"+order+"_"+emp_no,
				type: 'POST',

				success: function(result){
					$('#change_here').html(result);
				},
				error: function(err){
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
