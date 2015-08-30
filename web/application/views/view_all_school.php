<div class="row" id="viewSchoolContent">
	<div class="col-xs-12">
		<!-- Default panel contents -->
		<div class="row">
			<div class="col-xs-12  col-md-12 ">
				<div class="col-xs-12  col-md-6 ">
					<div class="row">
						<div class="col-xs-12  col-md-12 ">
							<div class=" inlineblock text-middle gb_searchbox-width65">

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1"><span
										class="glyphicon glyphicon-search"></span> </span> <input
										type="text" class="form-control" id="searchSchoolByName"
										placeholder="Search school by name">

									<div id="searchSchoolResult"></div>
								</div>
							</div>
							<button type="button" class="btn btn-warning inlineblock">Search</button>
						</div>
					</div>


					<div class=" col-md-6  text-right black">
						<select class="chosen" onchange="fetchSchoolWithStatus(event);"
							id="schoolFilterByStatus">
							<option value="null"
							<?php echo $status === null ? "selected" : "";?>>All</option>
							<option value="0" <?php echo $status === "0" ? "selected" : "";?>>Inactive</option>
							<option value="1" <?php echo $status == 1 ? "selected" : "";?>>Active</option>
							<option value="2" <?php echo $status == 2 ? "selected" : "";?>>New</option>
							<option value="3" <?php echo $status == 3 ? "selected" : "";?>>Reset
								Password</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12  col-md-12 ">
					<div class="panel-body">




						<?php if ($schoolList != null){ 
						$i = 1;?>
						<div class="row">



							<div class="col-xs-12">
								<div class="table-responsive">

									<table
										class="table table-hover table-bordered table-striped font-12"
										id="schoolListing">

										<thead>
											<tr class="info">
												<th>SL.No</th>
												<th>Name</th>
												<th>Email</th>
												<th class="text-center">School Type</th>
												<th class="text-center">Mobile Number</th>
												<th>Principal Name</th>
												<th class="text-center">Principal Number</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>

										<?php foreach ($schoolList as $school){?>

										<tr id="viewSchool<?php echo $school->user_id;?>"
											class="pointer viewSchoolRow">
											<td><?php echo $i;?>
											</td>
											<td><?php echo $school->school_name;?>
											</td>
											<td><?php echo $school->authentication->email_id;?>
											</td>
											<td class="text-center"><?php echo $school->school_type == 1 ? "KG" : "";?>
											</td>
											<td class="text-center"><?php echo $school->mobile_number;?>
											</td>
											<td><?php echo $school->principal_name;?></td>
											<td class="text-center"><?php echo $school->principal_number;?>
											</td>
											<td><?php 
											$colorClass ="";
											if($school->authentication->status == 0){
										$colorClass ="red";
									}
									if($school->authentication->status == 1){
													$colorClass ="green";
												}

												?> <span class="<?php echo $colorClass;?>"> <?php echo $school->statusText;?>
											</span>
											</td>
											<td><div>
													<form
														action="<?php echo base_url();?>schoolmanage/viewSchool"
														method="post" class="inline"
														id="viewSchoolDetailsForm<?php echo $school->user_id;?>">
														<input type="hidden"
															value="<?php echo $school->user_id;?>" name="school_id" />
														<button type="submit"
															class="glyphicon glyphicon-eye-open no-bg no-border font-size-20 gb-blue"
															role="button"></button>

													</form>
													<?php if($school->authentication->status == 0){
														$formURL  = "schoolmanage/activateSchool";
														$actionType = 0;
													}else{
$actionType = 1;
$formURL  = "schoolmanage/deactivateSchool";

											}
											?>
													<form action="<?php echo base_url().$formURL;?>"
														method="post" class="inline">
														<input type="hidden"
															value="<?php echo $school->user_id;?>" name="school_id" />

														<?php if($school->authentication->status == 0){?>
														<button type="submit"
															data-name="<?php echo $school->school_name;?>"
															class="glyphicon glyphicon-ok-circle no-bg no-border font-size-20 green"
															role="button"></button>


														<?php }else{?>
														<button type="submit"
															data-name="<?php echo $school->school_name;?>"
															data-buttontype="<?php echo $actionType;?>"
															class="glyphicon glyphicon-remove-circle no-bg no-border font-size-20 red"
															role="button"></button>

														<?php }?>
													</form>

												</div></td>
										</tr>
										<?php $i++;
						}?>

									</table>
								</div>
							</div>

						</div>
						<?php if($i < $totalCountOfSchools){?>
						<div class="row">
							<div class="col-xs-12 text-center">
								<input type="hidden" id="schoolListStatus"
									value="<?php echo $status?>" /> <input type="hidden"
									id="totalSchoolCount" value="<?php echo $totalCountOfSchools?>" />
								<input type="hidden" id="itemsInPage"
									value="<?php echo $itemsInPage?>" /> <a href=""
									class="btn btn-primary btn-sm" id="fetchMoreResults"
									role="button" data-page="<?php echo $pageNo;?>">Show More</a>
							</div>
						</div>
						<?php }
}else{?>
						<div class="row">
							<div class="col-xs-12">

								<div class="alert alert-info" role="alert">
									<p>No Schools to display.</p>
								</div>
							</div>
						</div>
						<?php }?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
