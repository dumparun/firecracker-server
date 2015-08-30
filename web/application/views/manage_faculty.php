
<div class="row" id="registerSchoolContent">
	<div class="">
		<!-- Default panel contents -->
		<div class="row margin-top-btm-50">
			<div class="col-xs-12  col-md-12 ">
				<div class="col-xs-12  col-md-6 ">

					<div class="row">
						<div class="col-xs-12  col-md-12 ">
							<div class=" inlineblock text-middle gb_searchbox-width65">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon2"> <span
										class="glyphicon glyphicon-search"></span>
									</span> <input type="text" class="form-control"
										id="searchFacultyByName" placeholder="Search faculty by name">

									<div id="searchFacultyResult"></div>
								</div>
							</div>
							<button type="button" class="btn btn-warning inlineblock">Search</button>
						</div>
					</div>
				</div>

				<div class=" col-md-6  text-right black">
					<select class="chosen" onchange="fetchFacultyWithStatus(event);"
						id="facultyFilterByStatus">
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
	</div>
	<?php if ($faculty != null){ 
						$i = 1;?>
	<div class="row">
		<div class="col-xs-12">
			<table
				class="table table-hover gb_table_border table-bordered  gb_table"
				id="facultyListing">
				<!-- On rows -->
				<tr class="bg_color_black white">

					<th>Name</th>
					<th>Email Id</th>
					<th>Mobile Number</th>
					<th>Designation</th>
					<th>Status</th>
					<th>Options</th>
				</tr>


				<?php foreach ($faculty as $faculties){?>

				<tr>
					<td><a
						href="<?php echo base_url()?>Faculty/addFaculty?userId=<?php echo $faculties->user_id; ?>"><?php echo $faculties->faculty_name;?>
					</a>
					</td>

					<td><a
						href="<?php echo base_url()?>Faculty/addFaculty?userId=<?php echo $faculties->user_id; ?>">
							<?php echo $faculties->email_id;?>
					</a>
					</td>
					<td><a
						href="<?php echo base_url()?>Faculty/addFaculty?userId=<?php echo $faculties->user_id; ?>">
							<?php echo $faculties->mobile_number;?>

					</a>
					</td>
					<td><a
						href="<?php echo base_url()?>Faculty/addFaculty?userId=<?php echo $faculties->user_id; ?>">

							<?php  	echo $faculties->designation; 	?>
					</a>
					</td>
					<td><?php if($faculties->status=="2"){?> <span class="green">New</span>
						<?php }else if($faculties->status=="1"){ ?> <span class="red">Active</span>
						<?php }else if($faculties->status=="0"){ ?> <span class="green">Inactive</span>
						<?php }?>
					</td>

					<td><div>
							<form action="<?php echo base_url()?>Faculty/addFaculty"
								method="post" class="inline">
								<button type="submit"
									class="glyphicon glyphicon-edit no-bg no-border font-size-20 gb-blue"
									role="button"></button>
								<input type="hidden" value="<?php echo $faculties->user_id;?>"
									name="userId" />
							</form>
							<form action="<?php echo base_url()?>Faculty/viewFaculty"
								method="post" class="inline">
								<button type="submit"
									class="glyphicon glyphicon-eye-open no-bg no-border font-size-20 gb-blue"
									role="button"></button>
								<input type="hidden" value="<?php echo $faculties->user_id;?>"
									name="userId" />
							</form>
							<?php if($faculties->status=="1" || $faculties->status=="2"){?>
							<form action="<?php echo base_url();?>Faculty/mangeFacultyStatus"
								method="post" class="inline">
								<input type="hidden" value="<?php echo $faculties->user_id;?>"
									name="userId" /> <input type="hidden"
									value="<?php echo $faculties->status;?>" name="status" />
								<button type="submit"
									class="glyphicon glyphicon-remove-circle no-bg no-border font-size-20 red"
									role="button"></button>
							</form>
							<?php }else  if($faculties->status=="0"){?>
							<form action="<?php echo base_url();?>Faculty/mangeFacultyStatus"
								method="post" class="inline">
								<input type="hidden" value="<?php echo $faculties->user_id;?>"
									name="userId" /> <input type="hidden"
									value="<?php echo $faculties->status;?>" name="status" />
								<button type="submit"
									class="glyphicon glyphicon-ok-circle no-bg no-border font-size-20 green"
									role="button"></button>
							</form>
							<?php }?>
						</div>
					</td>
				</tr>
				<?php $i++; 
}?>
			</table>
		</div>
	</div>
	<?php if($i < $totalCountOfFaculty){?>
	<div class="row">
		<div class="col-xs-12 text-center">
			<input type="hidden" id="facultyListStatus"
				value="<?php echo $status?>" /> <input type="hidden"
				id="totalfacultyCount" value="<?php echo $totalCountOfFaculty?>" />
			<input type="hidden" id="itemsInPage"
				value="<?php echo $itemsInPage?>" /> <a href=""
				class="btn btn-primary btn-sm" id="fetchMoreFaculty" role="button"
				data-page="<?php echo $pageNo;?>">Show More</a>
		</div>
	</div>
	<?php }


	 }else{?>
	<div class="row">
		<div class="col-xs-12">

			<div class="alert alert-info" role="alert">
				<p>No Faculty to display.</p>
			</div>
		</div>
	</div>
	<?php }?>
</div>
