<div class="row" id="registerSchoolContent">
	<div class="col-xs-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="text-center">
					<?php if($school == null){?>
					Register School
					<?php }else{?>
					Edit School
					<?php }?>
					<span class="glyphicon glyphicon-edit"></span>
				</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php if($school == null){
						$redirectURL =  base_url()."schoolmanage/registerSchool";
					}else{
$redirectURL =  base_url()."schoolmanage/updateSchool";
}?>
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<form method="post" action="<?php echo $redirectURL;?>"
							enctype="multipart/form-data" class="form-horizontal"
							id="registerSchoolForm" autocomplete="off">

							<div class="form-group">
								<label class="control-label col-sm-4">School Name <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="school_name" class="form-control"
										value="<?php echo $school == null ? "":$school->school_name;?>" />
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-sm-4">Type of School <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<select name="school_type" class="form-control">
										<option value="1"
										<?php echo $school != null && $school->school_type  == 1 ? "selected":"";?>>KG</option>
									</select>
								</div>
							</div>



							<div class="form-group">
								<label class="control-label col-sm-4">Chairman/Principal Name <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="chairman_principal_name"
										class="form-control"
										value="<?php echo $school != null ? $school->principal_name : "";?>" />
								</div>
							</div>

							<div class="form-group">

								<label class="control-label col-sm-4">Mobile<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="chairman_principal_number"
										class="form-control" maxlength="10"
										value="<?php echo $school != null ? $school->principal_number : "";?>" />
								</div>

							</div>



							<div class="form-group">
								<label class="control-label col-sm-4">Address 1 <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="address_1" class="form-control"
										value="<?php echo $school != null ? $school->address->address_1 : "";?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-4">Address 2 <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="address_2" class="form-control"
										value="<?php echo $school != null ? $school->address->address_2 : "";?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-4">Address 3 </label>
								<div class="col-sm-8">
									<input type="text" name="address_3" class="form-control"
										value="<?php echo $school != null ? $school->address->address_3 : "";?>" />
								</div>
							</div>



							<div class="form-group">
								<label class="control-label col-sm-4"> </label>
								<div class="col-sm-8 radio">
									<label class="radio-inline"> <input type="radio"
										name="for-locality-select" value="0"
										<?php echo $school == null?"checked" : "";?> />Enter pincode
									</label> <label class="radio-inline"> <input type="radio"
										name="for-locality-select" value="1"
										<?php echo $school != null? "checked" : "";?> /> Select
										Manually
									</label>
								</div>
							</div>



							<div
								class="form-group forDropDownPincodeSelect <?php echo $school == null? "hide" : "";?>">
								<label class="control-label col-sm-4">Country<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<select name="country" class="form-control">
										<option value="1">India</option>
									</select>
								</div>
							</div>


							<div
								class="form-group forDropDownPincodeSelect <?php echo $school == null? "hide" : "";?>">
								<label class="control-label col-sm-4">State<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<select name="state"
										class="form-control stateList chosen validate"
										data-child="districtList" id="stateList">
										<option value="-1"></option>
										<?php foreach ($states as $state){?>
										<option value="<?php echo $state->state_id;?>"
										<?php echo $school != null && $school->address->state_id == $state->state_id ? "selected" :"";?>>
											<?php echo $state->state_name;?>
										</option>

										<?php }?>
									</select>
								</div>
							</div>

							<div
								class="form-group forDropDownPincodeSelect <?php echo $school == null? "hide" : "";?>">
								<label class="control-label col-sm-4">District<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<select name="district"
										class="form-control districtList chosen validate"
										id="districtList" data-child="localityList">


										<?php if($school != null && $districtsInSelectedState != null){

											foreach ($districtsInSelectedState as $districts){?>

										<option value="<?php echo $districts->district_id;?>"
										<?php echo $school->address->district_id == $districts->district_id ? "selected" :"";?>>
											<?php echo $districts->district_name;?>
										</option>

										<?php } 
}?>
									</select>
								</div>
							</div>


							<div
								class="form-group forDropDownPincodeSelect <?php echo $school == null? "hide" : "";?>">
								<label class="control-label col-sm-4">Locality<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<select name="locality"
										class="form-control chosen validate localityList"
										id="localityList" data-child="pincodeAutoFill">

										<?php if($localitiesInSelectedDistrict != null){

											foreach ($localitiesInSelectedDistrict as $localities){?>

										<option value="<?php echo $localities->locality_id;?>"
											data-pincode="<?php echo $localities->pincode;?>"
											<?php echo $school->address->locality_id == $localities->locality_id ? "selected" :"";?>>
											<?php echo $localities->locality_name;?>
										</option>

										<?php } 
}?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-4">Pincode<span class="red">*</span>
								</label>
								<div class="col-sm-8">

									<input type="hidden" name="locality_name" id="locality_name" />
									<input type="hidden" name="locality_id" id="locality_id"
										value="<?php echo $school != null ? $school->address->locality_id : "";?>" />
									<input type="hidden" name="pincode" id="pincode"
										value="<?php echo $school != null ? $school->address->pincode : "";?>" />
									<input type="text" name="pincode"
										class="locality-search form-control" id="pincodeAutoFill"
										value="<?php echo $school != null ? $school->address->pincode : "";?>"
										<?php echo $school != null ? "readonly":"";?> />
									<div id="localitySearchResults" class="location-search-result"></div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-4">Mobile<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="mobile_number" class="form-control"
										maxlength="10"
										value="<?php echo $school != null ? $school->mobile_number : "";?>" />
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-sm-4">Phone<span class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="tel" name="phone_number" class="form-control"
										maxlength="10"
										value="<?php echo $school != null ? $school->phone_number : "";?>" />
								</div>
							</div>



							<div class="form-group">

								<label class="control-label col-sm-4">Email address <span
									class="red">*</span>
								</label>
								<div class="col-sm-8">
									<input type="email" name="email_address" class="form-control"
										required="required"
										<?php echo $school != null ?"disabled":"";?>
										value="<?php echo $school != null ? $school->authentication->email_id : "";?>" />
								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-sm-4">Working days and hours<span
									class="red">*</span>
								</label>


								<?php if($workingDaysDetailsArray == null){?>

								<div class="col-sm-8">

									<div class="row" id="workingDaysHolder">
										<div class="col-md-12">

											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="1"
													name="working_days[]"> Monday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="2"
													name="working_days[]"> Tuesday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="3"
													name="working_days[]"> Wednesday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="4"
													name="working_days[]"> Thursday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="5"
													name="working_days[]"> Friday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="6"
													name="working_days[]"> Saturday
												</label>
											</div>
											<div class="checkbox inlineblock">
												<label> <input type="checkbox" value="7"
													name="working_days[]"> Sunday
												</label>
											</div>

										</div>

										<div class="col-md-12 " style="border-bottom: 1px solid #000;">
											<div class="pad-top-btm-10">

												<select class="select chosen " style="width: 100px;"
													name="working_starting_hours">
													<?php for($i = 0; $i <= 24	 ; $i++){ ?>
													<option value="<?php echo $i;?>">
														<?php echo sprintf("%02d", $i);?>
													</option>
													<?php }?>
												</select> <select class="select chosen "
													style="width: 100px;" name="working_starting_minutes">
													<?php for($i = 0; $i <= 60	 ; $i++){ ?>
													<option value="<?php echo $i;?>">
														<?php echo sprintf("%02d", $i);?>
													</option>
													<?php }?>
												</select> <span class="font-11 bold margin-top-btm-10">TO</span>
												<select class="select chosen " style="width: 100px;"
													name="working_ending_hours">
													<?php for($i = 00; $i <= 24 ; $i++){ ?>
													<option value="<?php echo $i;?>">
														<?php echo sprintf("%02d", $i);?>
													</option>
													<?php }?>
												</select> <select class="select chosen "
													style="width: 100px;" name="working_ending_minutes">
													<?php for($i = 0; $i <= 60	 ; $i++){ ?>
													<option value="<?php echo $i;?>">
														<?php echo sprintf("%02d", $i);?>
													</option>
													<?php }?>
												</select>
											</div>
										</div>

									</div>


									<div class="text-right">
										<a href="#" class="font-11 underline"
											onclick="addMoreWorkingDays(event);">Add More</a>
									</div>

								</div>

								<?php }else{?>


								<div class="col-sm-8">
									<?php for ($k = 1; $k < 8 ;$k++){
										switch ($k){

											case 1 :
												$day =  "Monday";
												break;
											case 2 :
												$day =  "Tuesday";
												break;
											case 3 :
												$day =  "Wednesday";
												break;
											case 4 :
												$day =  "Thursday";
												break;
											case 5 :
												$day =  "Friday";
												break;
											case 6 :
												$day =  "Saturday";
												break;

											case 7 :
												$day =  "Sunday";
												break;
											default :
												$day =  "NA";
												break;
									}
									?>
									<div>
										<div class="checkbox">
											<label> <input type="checkbox" value="<?php echo $k;?>"
												name="working_days_single[]"
												<?php echo $workingDaysDetailsArray !=null && isset($workingDaysDetailsArray[$k]) ? "checked" : "";?>>
												<?php echo $day;?>
											</label>
										</div>

										<div class="margin-top-btm-10">
											<select class="select chosen " style="width: 100px;"
												name="working_starting_hours<?php echo $k;?>">
												<?php for($i = 0; $i <= 24	 ; $i++){ ?>
												<option value="<?php echo $i;?>"
												<?php echo $workingDaysDetailsArray !=null && $workingDaysDetailsArray[$k][0] == $i ? "selected" : "";?>>
													<?php echo sprintf("%02d", $i);?>
												</option>
												<?php }?>
											</select> <select class="select chosen "
												style="width: 100px;"
												name="working_starting_minutes<?php echo $k;?>">
												<?php for($i = 0; $i <= 60	 ; $i++){ ?>
												<option value="<?php echo $i;?>"
												<?php echo $workingDaysDetailsArray !=null && $workingDaysDetailsArray[$k][1] == $i ? "selected" : "";?>>
													<?php echo sprintf("%02d", $i);?>
												</option>
												<?php }?>
											</select> <span class="font-11 bold">TO</span> <select
												class="select chosen " style="width: 100px;"
												name="working_ending_hours<?php echo $k;?>">
												<?php for($i = 00; $i <= 24 ; $i++){ ?>
												<option value="<?php echo $i;?>"
												<?php echo $workingDaysDetailsArray !=null && $workingDaysDetailsArray[$k][2] == $i ? "selected" : "";?>>
													<?php echo sprintf("%02d", $i);?>
												</option>
												<?php }?>
											</select> <select class="select chosen "
												style="width: 100px;"
												name="working_ending_minutes<?php echo $k;?>">
												<?php for($i = 0; $i <= 60	 ; $i++){ ?>
												<option value="<?php echo $i;?>"
												<?php echo $workingDaysDetailsArray !=null && $workingDaysDetailsArray[$k][3] == $i ? "selected" : "";?>>
													<?php echo sprintf("%02d", $i);?>
												</option>
												<?php }?>
											</select>

										</div>


									</div>

									<?php }?>


								</div>



								<?php }?>

							</div>


							<div class="form-group">

								<label class="control-label col-sm-4">Image<span class="red">*</span>
								</label>
								<div class="col-sm-8">

									<div class="thumbnail">
										<?php 

										if($school != null ){
											$scr = $school->imageURL;
										}else{
											$scr =   base_url()."web/resources/profile/default.png";
										}
										?>
										<img src="<?php echo $scr;?>" alt="Click to Upload"
											id="imgPreview"
											onError="this.onerror=null;this.src='<?php echo base_url();?>web/resources/profile/default.png';">
										<input type="file" name="school_image"
											class="form-control hide" id="uploadPhotoID" />
									</div>


								</div>

							</div>

							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-8">
									<input type="hidden" name="school_id"
										value="<?php echo $school != null? $school->user_id: "0";?>" />
									<input type="submit" value="Submit" class="btn btn-primary"
										id="submitSchholRegistration"
										onclick="validateChosenSelectInForm('registerSchoolForm',event);checkIfPincodeValid('registerSchoolForm',event);" />
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo javascript_validation('registerSchoolForm', $JS_VALIDATION); ?>