<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3><?php  echo $info['schoolname']; ?></h3>

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
				<input type="hidden" name="sno" value="<?php echo $info['school_no'] ?>" />
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

				<input class="button-search col-sm-offset-2 btn btn-default" type="submit" name="submit" onclick="return validateSchoolEdit()" value="Save" />
			</form>
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
		</p>
	</div>
</div>