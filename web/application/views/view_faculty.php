<div class="row">

	<div class="col-xs-12">


		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<h2 class="text-center">Faculty Details</h2>
			</div>
			<div class="panel-body"></div>




			<div class="row">
				<div class="col-md-2 text-center">
					<img alt="<?php echo $faculty->faculty_name;?>"
						src="<?php echo $faculty->imageURL;?>"
						title="<?php echo $faculty->faculty_name;?>"
						onError="this.onerror=null;this.src='<?php echo base_url();?>web/resources/profile/default.png';">
				</div>
				<div class="col-md-6">

					<h4 class="text-center margin-top-btm-10">Student Details</h4>
					<div class="table-responsive">
						<table class="table table-striped table-hover font-12">

							<tr>
								<td class="text-right bold" width="40%">Student Name</td>
								<td width="20px">:</td>
								<td><?php echo $faculty->faculty_name;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Designation</td>
								<td width="20px">:</td>
								<td><?php echo $faculty->designation->designation;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Mobile Number</td>
								<td width="20px">:</td>
								<td><?php echo $faculty->mobile_number;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Sex</td>
								<td width="20px">:</td>
								<td><?php if($faculty->sex==0){
									echo "Male";
								}else {

echo "Female";


								}?></td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Date Of Birth</td>
								<td width="20px">:</td>
								<td><?php echo $faculty->date_of_birth;?>
								</td>
							</tr>
							<tr>
								<td class="text-right bold" width="40%">Alternate Number</td>
								<td width="20px">:</td>
								<td><?php echo $faculty->alternate_number;?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">Street 1</td>
								<td>:</td>
								<td><?php echo $faculty->address->address_1;?></td>
							</tr>



							<tr>
								<td class="text-right bold">Street 2</td>
								<td>:</td>
								<td><?php echo $faculty->address->address_2;?></td>
							</tr>


							<tr>
								<td class="text-right bold">Street 3</td>
								<td>:</td>
								<td><?php echo $faculty->address->address_3;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Country</td>
								<td>:</td>
								<td><?php echo $faculty->address->country_id == 1 ? "India":"";?>
								</td>
							</tr>

							<tr>
								<td class="text-right bold">State</td>
								<td>:</td>
								<td><?php echo $faculty->address->state->state_name;?></td>
							</tr>
							<tr>
								<td class="text-right bold">District</td>
								<td>:</td>
								<td><?php echo $faculty->address->district->district_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Locality</td>
								<td>:</td>
								<td><?php echo $faculty->address->locality->locality_name;?></td>
							</tr>

							<tr>
								<td class="text-right bold">Pincode</td>
								<td>:</td>
								<td><?php echo $faculty->address->pincode;?></td>
							</tr>



						</table>
					</div>



				</div>
			</div>




		</div>

	</div>
</div>
