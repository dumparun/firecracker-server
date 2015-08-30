<div class="row">

	<div class="col-xs-12">


		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<h2 class="text-center">School Details</h2>
			</div>
			<div class="panel-body"></div>




			<div class="row">

				<div class="col-md-2 text-center">
					<img alt="<?php echo $school->school_name;?>"
						src="<?php echo $school->imageURL;?>"
						title="<?php echo $school->school_name;?>"
						onError="this.onerror=null;this.src='<?php echo base_url();?>web/resources/profile/default.png';">
				</div>
				<div class="col-md-6">

					<h4 class="text-center margin-top-btm-10">School Details</h4>
					<div class="table-responsive">
						<table class="table table-striped table-hover font-12">

							<tr>
								<td class="text-right bold" width="40%">School Name</td>
								<td width="20px">:</td>
								<td><?php echo $school->school_name;?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">School Type</td>
								<td>:</td>
								<td><?php echo $school->school_type == 1 ? "KinderGarten": $school->school_type;?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">Street 1</td>
								<td>:</td>
								<td><?php echo $school->address->address_1;?></td>
							</tr>



							<tr>
								<td class="text-right bold">Street 2</td>
								<td>:</td>
								<td><?php echo $school->address->address_2;?></td>
							</tr>


							<tr>
								<td class="text-right bold">Street 3</td>
								<td>:</td>
								<td><?php echo $school->address->address_3;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Country</td>
								<td>:</td>
								<td><?php echo $school->address->country_id == 1 ? "India":"";?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">State</td>
								<td>:</td>
								<td><?php echo $school->address->state->state_name;?></td>
							</tr>
							<tr>
								<td class="text-right bold">District</td>
								<td>:</td>
								<td><?php echo $school->address->district->district_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Locality</td>
								<td>:</td>
								<td><?php echo $school->address->locality->locality_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Pincode</td>
								<td>:</td>
								<td><?php echo $school->address->pincode;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Phone Number</td>
								<td>:</td>
								<td><?php echo $school->phone_number ;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Mobile Number</td>
								<td>:</td>
								<td><?php echo $school->mobile_number ;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Principal/chairman Name</td>
								<td>:</td>
								<td><?php echo $school->principal_name ;?></td>
							</tr>
							<tr>
								<td class="text-right bold">Principal's Number</td>
								<td>:</td>
								<td><?php echo $school->principal_number ;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Status</td>
								<td>:</td>
								<td><?php 	$colorClass ="";
								if($school->authentication->status == 0){
										$colorClass ="red";
									}
									if($school->authentication->status == 1){
													$colorClass ="green";
												}?> <span class="<?php echo $colorClass;?>"> <?php echo $school->statusText;?>
								</span></td>
							</tr>

							<tr>
								<td class="text-right">
									<form
										action="<?php echo base_url();?>Schoolmanage/schoolRegistration"
										method="post">
										<input type="hidden" name="school_id"
											value="<?php echo $school->user_id;?>">
										<button class="btn btn-default">Edit</button>
									</form>
								</td>
								<td></td>
								<td>
									<form
										action="<?php echo base_url();?>Schoolmanage/viewAllSchools"
										method="post">
										<button type="submit" class="btn btn-default">Go Back</button>
									</form>
								</td>
							</tr>

						</table>
					</div>



				</div>
				<?php if( $school->working_days != null){?>
				<div class="col-md-4">
					<h4 class="text-center margin-top-btm-10">Working Days</h4>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Monday</td>
								<td><?php echo $school->working_days->monday == null? "Holiday" : $school->working_days->monday; ?>
								</td>
							</tr>
							<tr>
								<td>Tuesday</td>
								<td><?php echo $school->working_days->tuesday == null? "Holiday" : $school->working_days->tuesday; ?>
								</td>
							</tr>
							<tr>
								<td>Wednesday</td>
								<td><?php echo $school->working_days->wednesday == null? "Holiday" : $school->working_days->wednesday; ?>
								</td>
							</tr>

							<tr>
								<td>Thursday</td>
								<td><?php echo $school->working_days->thursday == null? "Holiday" : $school->working_days->thursday; ?>
								</td>
							</tr>
							<tr>
								<td>Friday</td>
								<td><?php echo $school->working_days->friday == null? "Holiday" : $school->working_days->friday; ?>
								</td>
							</tr>
							<tr>
								<td>Saturday</td>
								<td><?php echo $school->working_days->saturday == null? "Holiday" : $school->working_days->saturday; ?>
								</td>
							</tr>
							<tr>
								<td>Sunday</td>
								<td><?php echo $school->working_days->sunday == null? "Holiday" : $school->working_days->sunday; ?>
								</td>
							</tr>

						</table>
					</div>
				</div>
				<?php }?>
			</div>




		</div>

	</div>
</div>
