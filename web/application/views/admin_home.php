<div class="row" id="adminHomeContent">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header text-center">
					<h1>School Details</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div
				class="col-xs-12  col-sm-offset-3 col-sm-6 col-md-8 col-md-offset-2">

				<div class="quick-details-view">

					<div class="list-group">
						<a href="<?php echo base_url();?>Schoolmanage/viewAllSchools"
							class="list-group-item list-group-item-success"><span
							class="badge"><?php echo $schoolCount[4]?> </span> Total Schools</a>

						<a
							href="<?php echo base_url();?>Schoolmanage/viewAllSchools?schools=0"
							class="list-group-item list-group-item-success"><span
							class="badge"><?php echo $schoolCount[0]?> </span>Inactive
							Schools</a> <a
							href="<?php echo base_url();?>Schoolmanage/viewAllSchools?schools=1"
							class="list-group-item list-group-item-success"><span
							class="badge"><?php echo $schoolCount[1]?> </span>Active Schools</a>

						<a
							href="<?php echo base_url();?>Schoolmanage/viewAllSchools?schools=2"
							class="list-group-item list-group-item-success"><span
							class="badge"><?php echo $schoolCount[2]?> </span>Newly
							Registered Schools</a> <a
							href="<?php echo base_url();?>Schoolmanage/viewAllSchools?schools=3"
							class="list-group-item list-group-item-success"><span
							class="badge"><?php echo $schoolCount[3]?> </span>Password Reset</a>

					</div>


				</div>
			</div>

		</div>

	</div>
</div>
