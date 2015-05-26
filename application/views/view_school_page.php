<script type="text/javascript">
	<?php 
		if(! $is_approved)
			echo "get_school_data()";
	 ?>

	function get_school_data(){  
		$.ajax({
			url: base_url+"controller_school/get_school_data",
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
		<?php if(isset($info['school_no'])){ ?>
		<h3><?php  echo $info['schoolname'];?></h3>

		<p>
			<!-- if entry is existing, update other entries using the id of this entry then remove current entry-->

			<?php 
				// var_dump($info);
				echo validation_errors();
				$attrib=array('name' => 'schooledit', 'id' => 'schooledit', 'class' => 'form-horizontal');
				echo form_open('controller_school_approval/edit_school', $attrib);
				if(isset($msg)){
					echo $msg;
				}
			?>
				<input type="hidden" id="sno" name="sno" value="<?php echo $info['school_no'] ?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="sname">School Name</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="sname" onblur="validateSchoolName()" value="<?php echo $info['schoolname']?>" />
						<span name="snameerr"></span></br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="country">Country</label>
					<div class="col-sm-10">
						<select class="form-control country"  onblur="validateSchoolCountry()" name="country">
							<option value="<?php echo $info['saddcountrycode']?>" selected="selected"><?php echo $info['saddcountry']?></option>
								<?php
									foreach($list as $element){
										echo "<option value='".$element->alpha_2."'>".$element->name."</option>";
									}
								?>
						</select>
						<span name="saddcountryerr"></span></br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="state">Province/State</label>
					<div class="col-sm-10">
						<select class="form-control state_dropdown"  onblur="validateSchoolProvinceState()" name="state">
                            <option value="<?php echo $info['saddprovincecode']?>" selected="selected"><?php echo $info['saddprovince']?></option>
                        </select>
						<span name="saddprovinceerr"></span></br>
					</div>
				</div>

				<input class="button-search col-sm-offset-2 btn btn-default" type="submit" name="submit" onclick="return validateSchoolEdit()" value="<?php if(! $is_approved) echo "Approve"; else echo "Save"; ?>" />
			</form>
		</p>
		<?php 
			if(! $is_approved){
				echo "<h3>List of Approved School Entries</h3>
					<center class='centersort'>
						<div class='sortform'>
							<form method='post' id='sort_list' name='sort_list'>
								<span>Sort by 
									<select id = 'sort_by' name ='sort_by' onchange = 'get_school_data();'>
										<option value='schoolname' selected='selected'>School Name</option>
										<option value='saddcountry'>Country</option>
										<option value='saddregion'>Region</option>
										<option value='saddprovince'>Province</option>
									</select>
								</span><br>
								<span>	 
									<input type='radio' id='order_by_asc' onchange = 'get_school_data();' value='asc' name='order_by' checked='checked'><label for='order_by_asc'>Ascending</label></input>
									<input type='radio' id='order_by_desc' onchange = 'get_school_data();' value='desc' name='order_by'><label for='order_by_desc'>Descending</label></input>
								</span>
							</form>
						</div>
					</center>
					<div id='change_here'> </div>";
			}
		}
		else { echo "<h3>Entry does not exist.</h3>"; } ?>
	</div>
</div>
<script src="<?php echo base_url() ?>mod/js/validate.js"></script>
<script src="<?php echo base_url() ?>mod/js/ajax.js"></script>
<script type="text/javascript">
	window.onload=loadCountry();

	function loadCountry(){
		var country_id=$('.country').val().trim();
		if(country_id!="-1"){
			loadData('state',country_id);
		}else{
			$(".state_dropdown").html("<option value='-1'>Select state</option>");
		}
	}

	function loadData(loadType,loadId){
		$.ajax({
			type: "POST",
			url: base_url + 'controller_log/get_data/'+loadId,
			dataType: 'json',

			success: function(values){
				var str="";
				for(var i=0; i<values.result.length; i++){
					str+="<option value='" + values.result[i].iso_code + "'>" + values.result[i].name + "</option>\n";
				}
				$("."+loadType+"_dropdown").append(str);
			}
		});
	}
</script>