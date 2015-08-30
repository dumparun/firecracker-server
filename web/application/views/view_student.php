<div class="row">

	<div class="col-xs-12">


		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<h2 class="text-center">Student Details</h2>
			</div>
			<div class="panel-body"></div>




			<div class="row">
				<div class="col-md-2 text-center">
					<img alt="<?php echo $student->student_name;?>"
						src="<?php echo $student->imageURL;?>"
						title="<?php echo $student->student_name;?>"
						onError="this.onerror=null;this.src='<?php echo base_url();?>web/resources/profile/default.png';">
				</div>
				<div class="col-md-6">

					<h4 class="text-center margin-top-btm-10">Student Details</h4>
					<div class="table-responsive">
						<table class="table table-striped table-hover font-12">

							<tr>
								<td class="text-right bold" width="40%">Student Name</td>
								<td width="20px">:</td>
								<td><?php echo $student->student_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Fathers Name</td>
								<td width="20px">:</td>
								<td><?php echo $student->fathers_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Mobile Number</td>
								<td width="20px">:</td>
								<td><?php echo $student->mobile_number;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Mothers Name</td>
								<td width="20px">:</td>
								<td><?php echo $student->mothers_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Guardians Name</td>
								<td width="20px">:</td>
								<td><?php echo $student->guardians_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Fathers Occupation</td>
								<td width="20px">:</td>
								<td><?php echo $student->fathers_occupation;?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold" width="40%">Alternate Number</td>
								<td width="20px">:</td>
								<td><?php echo $student->alternate_number;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Emergency Contact Number</td>
								<td width="20px">:</td>
								<td><?php echo $student->emergency_contact_number;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Guardians contact number</td>
								<td width="20px">:</td>
								<td><?php echo $student->mothers_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Mothers Name</td>
								<td width="20px">:</td>
								<td><?php echo $student->mothers_name;?>
								</td>
							</tr>






							<tr>
								<td class="text-right bold">Street 1</td>
								<td>:</td>
								<td><?php echo $student->address->address_1;?></td>
							</tr>



							<tr>
								<td class="text-right bold">Street 2</td>
								<td>:</td>
								<td><?php echo $student->address->address_2;?></td>
							</tr>


							<tr>
								<td class="text-right bold">Street 3</td>
								<td>:</td>
								<td><?php echo $student->address->address_3;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Country</td>
								<td>:</td>
								<td><?php echo $student->address->country_id == 1 ? "India":"";?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">State</td>
								<td>:</td>
								<td><?php echo $student->address->state->state_name;?></td>
							</tr>
							<tr>
								<td class="text-right bold">District</td>
								<td>:</td>
								<td><?php echo $student->address->district->district_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Locality</td>
								<td>:</td>
								<td><?php echo $student->address->locality->locality_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Pincode</td>
								<td>:</td>
								<td><?php echo $student->address->pincode;?></td>
							</tr>



							<!-- <tr>
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
							</tr>-->

						</table>
					</div>



				</div>
			</div>




		</div>

	</div>
</div>
