<script type="text/javascript">

	$(document).ready( function() {
		
		$("#eno").blur(function (){ 
			
			if($('#eno').val().trim() != ""){
				if(! validateENo()){
					$('#enolog').text("");
					return false;
				}
				var eno=$('#eno').val().trim();
				$.ajax({
					url: base_url+"controller_login/eno_available/"+eno,
					type: 'POST',

					success: function(result){
						$('#enolog').text(result);
					},
					error: function(err){
						$('#enolog').text(err);
					}
				});
			}
		});
	});
</script>

<div id="content-box" class="fill-space content-box clearfix">
	<div class="inner-content">
		<div id="content">
			<h3>User Information</h3>
			<p>
				<?php 
					echo validation_errors();
					$attrib=array('name' => 'editinfo', 'id' => 'editinfo', 'class' => 'form-horizontal');
					echo form_open('controller_login/edit_info_form', $attrib);
					if(isset($msg)){
						echo $msg;
					}
				?>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="eno">Employee Number</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="eno" id="eno"/>
							<span id="enolog"></span><span name="enoerr"></span></br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="fname">First Name</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="fname" onblur="validateEditFname()" value="<?php if(isset($userinfo)) echo $userinfo->given_name; else echo $fname; ?>"/>
							<span name="fnameerr"></span></br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="lname">Last Name</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="lname" onblur="validateEditLname()" value="<?php if(isset($userinfo)) echo $userinfo->family_name; else echo $lname; ?>" />
							<span name="lnameerr"></span></br>
						</div>
					</div>

					<input type="submit" name="submit" class="button-search col-sm-offset-2 btn btn-default" onclick="return validateEditInfo()" value="Save" />
				</form>
			</p>
		</div>
		<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/validate.js"></script>
	</div>
</div>

