<div class="row gb-registration">
	<div class="col-xs-12">

		<div class="panel-body">
			<div class="row">

				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<?php if($faculty == null){

						$redirectURL =  base_url()."Faculty/registerFaculty";
					}else{
$redirectURL =  base_url()."Faculty/updateFaculty";
}?>


					<form method="post" action="<?php echo $redirectURL;?>"
						enctype="multipart/form-data" class="form-horizontal"
						id="registerFacultyForm">


						<div class="form-group">

							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<label class="radio-inline"> <input type="radio"
									name="faculty_type"
									<?php if($faculty!=null && $faculty->faculty_type==0 ){
										echo "checked";
										}?>
									checked value="0"> Teaching
								</label> <label class="radio-inline"> <input type="radio"
									name="faculty_type"
									<?php if($faculty!=null && $faculty->faculty_type==1 ){
										echo "checked";
										}?>
									value="1"> Nonteaching
								</label>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-sm-4">Faculty Name <span
								class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type="text" name="faculty_name" class="form-control"
									value="<?php if($faculty!=null){echo $faculty->faculty_name ;}?>"
									required /> <input type="hidden" name="faculty_id"
									value="<?php if($faculty!=null){echo $faculty->user_id ;}?>" />
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-sm-4">Designation <span
								class="red">*</span>
							</label>
							<div class="col-sm-8">
								<select name="designation" class="form-control">
									<option value="-1"></option>
									<?php foreach ($designation as $designations){?>
									<option value="<?php echo $designations->designation_id;?>"
									<?php echo $faculty != null && $faculty->designation->designation_id == $designations->designation_id ? "selected" :"";?>>
										<?php echo $designations->designation;?>
									</option>
									<?php }?>
									</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Sex <span class="red">*</span>
							</label>
							<div class="col-sm-8">

								<label class="radio-inline"> <input type="radio" name="gender"
									checked value="0"> Male
								</label> <label class="radio-inline"> <input type="radio"
									name="gender" value="1"> Female
								</label>

							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Date Of Birth <span
								class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type='text' class="form-control" id='datepicker'
									value="<?php if($faculty!=null){
											echo $faculty->date_of_birth;
										}?>"
									name="date_of_birth" required />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Mobile <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type="tel" name="mobile_number" class="form-control"
									value="<?php if($faculty!=null){
											echo $faculty->mobile_number;}?>"
									required
}
										maxlength="10" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Alternate Contact Number</label>
							<div class="col-sm-8">
								<input type="text" name="alternate_contact_number"
									value="<?php if($faculty!=null){
											echo $faculty->alternate_number;
										}?>"
									class="form-control" maxlength="10" />
							</div>
						</div>
						<div class="form-group">

							<label class="control-label col-sm-4">Email address <span
								class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type="email" name="email" class="form-control"
									value="<?php
										if($faculty!=null){ echo $faculty->authentication->email_id; }?>"
									required="required" />
							</div>

						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<h2>Address</h2>
							</div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Address 1 <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type="text" name="address_1" class="form-control"
									value="<?php echo $faculty != null ? $faculty->address->address_1 : "";?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Address 2 <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<input type="text" name="address_2" class="form-control"
									value="<?php echo $faculty != null ? $faculty->address->address_2 : "";?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Address 3 </label>
							<div class="col-sm-8">
								<input type="text" name="address_3" class="form-control"
									value="<?php echo $faculty != null ? $faculty->address->address_3 : "";?>" />
							</div>
						</div>



						<div class="form-group">
							<label class="control-label col-sm-4"> </label>
							<div class="col-sm-8 radio">
								<label class="radio-inline"> <input type="radio"
									name="for-locality-select" value="0"
									<?php echo $faculty == null?"checked" : "";?> />Enter pincode
								</label> <label class="radio-inline"> <input type="radio"
									name="for-locality-select" value="1"
									<?php echo $faculty != null? "checked" : "";?> /> Select
									Manually
								</label>
							</div>
						</div>



						<div
							class="form-group forDropDownPincodeSelect <?php echo $faculty == null? "hide" : "";?>">
							<label class="control-label col-sm-4">Country <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<select name="country" class="form-control">
									<option value="1">India</option>
								</select>
							</div>
						</div>


						<div
							class="form-group forDropDownPincodeSelect <?php echo $faculty == null? "hide" : "";?>">
							<label class="control-label col-sm-4">State <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<select name="state"
									class="form-control stateList chosen validate"
									data-child="districtList" id="stateList">
									<option value="-1"></option>
									<?php foreach ($states as $state){?>
									<option value="<?php echo $state->state_id;?>"
									<?php echo $faculty != null && $faculty->address->state_id == $state->state_id ? "selected" :"";?>>
										<?php echo $state->state_name;?>
									</option>

									<?php }?>
								</select>
							</div>
						</div>

						<div
							class="form-group forDropDownPincodeSelect <?php echo $faculty == null? "hide" : "";?>">
							<label class="control-label col-sm-4">District <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<select name="district"
									class="form-control districtList chosen validate"
									id="districtList" data-child="localityList">


									<?php if($faculty != null && $districtsInSelectedState != null){

											foreach ($districtsInSelectedState as $districts){?>

									<option value="<?php echo $districts->district_id;?>"
									<?php echo $faculty->address->district_id == $districts->district_id ? "selected" :"";?>>
										<?php echo $districts->district_name;?>
									</option>

									<?php } 
}?>
								</select>
							</div>
						</div>
						<div
							class="form-group forDropDownPincodeSelect <?php echo $faculty == null? "hide" : "";?>">
							<label class="control-label col-sm-4">Locality <span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<select name="locality"
									class="form-control chosen validate localityList"
									id="localityList" data-child="pincodeAutoFill">

									<?php if($localitiesInSelectedDistrict != null){

											foreach ($localitiesInSelectedDistrict as $localities){?>

									<option value="<?php echo $localities->locality_id;?>"
										data-pincode="<?php echo $localities->pincode;?>"
										<?php echo $faculty->address->locality_id == $localities->locality_id ? "selected" :"";?>>
										<?php echo $localities->locality_name;?>
									</option>

									<?php } 
}?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Pincode <span class="red">*</span>
							</label>
							<div class="col-sm-8">

								<input type="hidden" name="locality_name" id="locality_name" />
								<input type="hidden" name="locality_id" id="locality_id"
									value="<?php echo $faculty != null ? $faculty->address->locality_id : "";?>" />
								<input type="hidden" name="pincode" id="pincode"
									value="<?php echo $faculty != null ? $faculty->address->pincode : "";?>" />
								<input type="text" name="pincode"
									class="locality-search form-control" id="pincodeAutoFill"
									value="<?php echo $faculty != null ? $faculty->address->pincode : "";?>"
									<?php echo $faculty != null ? "readonly":"";?> />
								<div id="localitySearchResults" class="location-search-result"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Image<span class="red">*</span>
							</label>
							<div class="col-sm-8">
								<div class="thumbnail">
									<?php  if($faculty != null ){
										$scr = $faculty->imageURL;
									}else{
											$scr =   base_url()."web/resources/profile/default.png";
										}
										?>
									<img src="<?php echo $scr;?>" alt="Click to Upload"
										id="imgPreview"
										onError="this.onerror=null;this.src='<?php echo base_url();?>web/resources/profile/default.png';">
									<input type="file" name="faculty_image"
										class="form-control hide" id="uploadPhotoID" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-10 col-sm-2">
								<input type="submit" value="Submit" class="btn btn-danger"
									id="submitFacultyRegistration"
									onclick="validateChosenSelectInForm('registerFacultyForm',event);checkIfPincodeValid('registerFacultyForm',event);" />
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  $(function () {
    $('#datepicker').datepicker({
   	 format: 'yyyy/mm/dd',
    });
  });
 </script>
<?php echo javascript_validation('registerFacultyForm', $JS_VALIDATION); ?>