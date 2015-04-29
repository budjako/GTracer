<div id="content-box" class="fill-space content-box clearfix">
	<div class="inner-content">
		<h3>View Reg Edit Info</h3>
			<div id="content">
				<?php 
					// var_dump($userData);
					// echo "<hr />";
					// var_dump($this->session->all_userdata());
					echo validation_errors();
					$attrib=array('name' => 'editinfo', 'id' => 'editinfo');
					echo form_open('controller_login/edit_info_form', $attrib);
					if(isset($msg)){
						echo $msg;
					}
				?>

					<label for="eno">Employee Number</label>
					<input type="text" name="eno" onblur="validateENo()" value="<?php if(isset($eno)) echo $eno; ?>"/>
					<span name="enoerr"></span></br>
					<label for="fname">First Name</label>
					<input type="text" name="fname" onblur="validateEditFname()" value="<?php if(isset($userData)) echo $userData->given_name; else echo $fname; ?>"/>
					<span name="fnameerr"></span></br>
					<label for="lname">Last Name</label>
					<input type="text" name="lname" onblur="validateEditLname()" value="<?php if(isset($userData)) echo $userData->family_name; else echo $lname; ?>" />
					<span name="lnameerr"></span></br>
					<label type="email">Email Address</label>
					<input type="email" name="email" onblur="validateEditEmail()" value="<?php if(isset($userData)) echo $userData->email; else echo $email; ?>"/>
					<span name="emailerr"></span></br>

					<input type="submit" name="submit" onclick="return validateEditInfo()" value="Save" />
				</form>
			</div>
		<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/validate.js"></script>
	</div>
</div>
