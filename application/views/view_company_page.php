<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3><?php  echo $info['companyname']; ?></h3>

		<p>

			<?php 
				// var_dump($info);
				echo validation_errors();
				$attrib=array('name' => 'companyedit', 'id' => 'companyedit', 'class' => 'form-horizontal');
				echo form_open('controller_company_approval/edit_company', $attrib);
				if(isset($msg)){
					echo $msg;
				}
			?>
				<input type="hidden" name="cno" value="<?php echo $info['company_no'] ?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="cname">Company Name</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="cname" onblur="validateCompanyName()" value="<?php echo $info['companyname']?>" />
						<span name="cnameerr"></span></br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="ctype">Company Type</label>
					<div class="col-sm-10">
						<select class="form-control ctype"  onblur="validateCompanyType()" name="ctype">
							<?php if($info['companytype'] == 0){?>
	                            <option value="0" selected="selected"> Self-employed/Private </option>
	                            <option value="1"> Government </option>
	                        <?php } else if($info['companytype'] == 1){?>
	                            <option value="0"> Self-employed/Private </option>
	                            <option value="1" selected="selected"> Government </option>
	                        <?php } ?>
						</select>
						<span name="ctypeerr"></span></br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="country">Country</label>
					<div class="col-sm-10">
						<select class="form-control country"  onblur="validateCompanyCountry()" name="country">
							<option value="<?php echo $info['caddcountrycode']?>" selected="selected"><?php echo $info['caddcountry'] ?></option>
								<?php
									foreach($list as $element){
										echo "<option value='".$element->alpha_2."'>".$element->name."</option>";
									}
								?>
						</select>
						<span name="caddcountryerr"></span></br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="state">Province/State</label>
					<div class="col-sm-10">
						<select class="form-control state_dropdown"  onblur="validateCompanyProvinceState()" name="state">
                            <option value="<?php echo $info['caddprovincecode']?>" selected="selected"><?php echo $info['caddprovince']?></option>
                        </select>
						<span name="caddprovinceerr"></span></br>
					</div>
				</div>

				<input class="button-search col-sm-offset-2 btn btn-default" type="submit" name="submit" onclick="return validateCompanyEdit()" value="Save" />
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

