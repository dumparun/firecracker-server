<div class="row" id="viewSchoolContent">
	<div class="col-xs-12">
		<div class="">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<h2 class="">Holiday List</h2>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<div class="row">
					<div class="col-xs-12 col-md-12 margin-bottom50">
						<form method="post"
							action="<?php echo base_url()?>Holiday/addHoliday"
							class="form-horizontal" id="addHolidayform">

							<div class="form-group">
								<div class="col-sm-3 bold col-md-2">Add Holidays</div>


								<div class="col-sm-3 col-md-4">
									<label class="control-label col-md-4">Date <span class="red">*</span>
									</label>
									<div class="col-md-8">
										<input type='text' class="form-control" id='datepicker'
											name="date" required />
									</div>
								</div>
								<div class="col-sm-3 col-md-4">
									<label class="control-label col-md-4">Event <span class="red">*</span>
									</label>
									<div class="col-md-8">
										<input type='text' class="form-control" name="event" required />
									</div>
								</div>
								<div class="col-sm-3 col-md-2">

									<div class="col-sm-4">
										<input type="submit" value="Submit" class="btn btn-danger" />

									</div>
								</div>
							</div>
						</form>

					</div>
				</div>


				<?php if ($holidays != null){ 
						$i = 1;?>
				<div class="row">



					<form action="<?php echo base_url()?>Holiday/updateHoliday"
						method="post" class="form-horizontal" id="updateHolidayform"
						novalidate>
						<div class="row" id="registerSchoolContent">
							<div class="col-xs-12">
								<table
									class="table table-hover gb_table_border table-bordered  gb_table">

									<thead>

										<tr class="bg_color_black white">
											<th>SL.No</th>
											<th>Event</th>
											<th>Date</th>
											<th>Options</th>
										</tr>
									</thead>

									<?php
									$i=1;
								foreach ($holidays as $holiday){?>

									<tr
									<?php if($holiday->status==0){

										echo 'style="color: red"';

									}else{

								echo 'style="color: green"';
							}?>>
										<td style="color: red"><?php echo $i;?></td>
										<td>
											<div class="col-sm-5">
												<span id="viewHolidayEvent<?php echo $holiday->holiday_id?>"><?php echo $holiday->event;?>
												</span> <input type='text'
													id="editHolidayEvent<?php echo $holiday->holiday_id?>"
													class="form-control display-none"
													name="event<?php echo $holiday->holiday_id?>" required />
											</div>
										</td>
										<td>

											<div class="col-sm-5">
												<span id="viewHolidayDate<?php echo $holiday->holiday_id?>"><?php echo $holiday->date;?>
												</span> <input type='text'
													class="form-control display-none "
													name="date<?php echo $holiday->holiday_id?>"
													id='datepicker<?php echo $holiday->holiday_id?>' required />
											</div>
										</td>

										<td>

											<div class="col-sm-5">
												<button type="button"
													onclick="editHoliday('<?php echo $holiday->holiday_id?>');"
													class="glyphicon glyphicon-edit no-bg no-border font-size-20"
													id="editHolidays<?php echo $holiday->holiday_id?>"></button>



												<button type="submit" name="editHolidayButton"
													value="<?php echo $holiday->holiday_id?>"
													class="glyphicon glyphicon-ok-circle no-bg no-border font-size-20 display-none "
													id="saveHolidays<?php echo $holiday->holiday_id?>"></button>
											</div>
										</td>

									</tr>
									<script type="text/javascript">
  $(function () {
    $('#datepicker' + '<?php echo $holiday->holiday_id?>').datepicker({
    	 format: 'yyyy/mm/dd',
    });
  });
 </script>

									<?php $i++;
						}?>

								</table>
							</div>
						</div>

					</form>

				</div>
				<?php }?>
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
