<!--
	Page that enables the user to search an alumnus or a group of alumni using only the student number, first name, last name and email address
-->

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Basic Search</h3>
		<?php 
			echo validation_errors();						// show errors on search values
			$attrib=array('name' => 'basicsearch', 'id' => 'basicsearch', 'class' => 'form-horizontal');
			echo form_open('controller_basic_search/search_form', $attrib);			
			if(isset($msg)){
				echo $msg;
			}
		?>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="stdno">Student Number</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="stdno" onblur="validateStdNo()" />
					<span name="stdnoerr"></span></br>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="fname">First Name</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="fname" onblur="validateFname()" />
					<span name="fnameerr"></span></br>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="lname">Last Name</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="lname" onblur="validateLname()" />
					<span name="lnameerr"></span></br>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="email">Email</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="email" onblur="validateEmail()" />
					<span name="emailerr"></span></br>
				</div>
			</div>

			<input class="button-search col-sm-offset-2 btn btn-default" type="submit" name="submit" onclick="return validateSearch()" value="Search" />
		</form>
		<script src="<?php echo base_url() ?>mod/js/validate.js"></script>				<!-- validate values supplied -->
	</div>
</div>