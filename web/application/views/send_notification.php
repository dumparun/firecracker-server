<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Send Notifications</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<form method="post"
						action="<?php echo base_url();?>schoolmanage/sendNotificationToContacts"
						class="form-horizontal" id="sendNotificationForm">
						<div class="col-xs-12">
							<div class="col-xs-6">
								<textarea
									class="float-left notification-textarea full-width form-control"
									rows="3" name="send-notifications"></textarea>

							</div>
							<div class="col-xs-6 student-faculty-ckeck">
								<div class="col-xs-12">
									<select id="select-faculty-student"
										name="select-faculty-student"
										data-placeholder="Select Contact From"><option value="0">Select
											All</option>
										<option value="1">Faculty</option>
										<option value="2">Parent</option>
									</select>
								</div>
								<div class="col-xs-12">
									<div class="faculty-selection hide">
										<div class="radiobox-div">
											<label class="radio-inline"> <input
												class="inlineRadioOptions selectAllFaculty" type="radio"
												name="inlineRadioOptionFaculty" id="" value="1"
												checked="checked">Select All Faculty
											</label> <label class="radio-inline"> <input
												class="inlineRadioOptions" type="radio"
												name="inlineRadioOptionFaculty" id="" value="2">Selected
												Faculties
											</label>
										</div>
										<div class="faculty-view-in-send-notification hide">
											<ul class="not-list faculty-student-list">
												<?php  if($facultyList!=null){ ?>
												<label class="radio-inline full-width select-all-label"><input
													class="select-all-faculty  " type="checkbox"
													name="select-all-faculty" value="">Select All</label>
												<?php
foreach ($facultyList as $faculty){?>
												<li><label class="radio-inline full-width "><input
														class="faculty-list" type="checkbox"
														name="check_faculty_list[]"
														value="<?php echo $faculty->user_id?>"> <?php echo $faculty->faculty_name; ?>
												</label>
												</li>
												<?php }
}else {?>
												<p class="empty-list">No Faculty Found</p>
												<?php }?>
											</ul>
										</div>
									</div>
									<div class="student-selection hide">
										<div class="radiobox-div">
											<label class="radio-inline"> <input
												class="inlineRadioOptions  selectAllFaculty" type="radio"
												name="inlineRadioOptionStudent" id="" value="3"
												checked="checked">Select All Student
											</label> <label class="radio-inline"> <input
												class="inlineRadioOptions" type="radio"
												name="inlineRadioOptionStudent" id="" value="4">Selected
												Students
											</label>
										</div>
										<div class="student-view-in-send-notification hide">
											<ul class="not-list faculty-student-list ">
												<?php if($studentList!=null){ ?>
												<label class="radio-inline full-width select-all-label "><input
													class="select-all-student " type="checkbox"
													name="select-all-student" value="">Select All</label>
												<?php foreach ($studentList as $student){?>
												<li><label class="radio-inline full-width"><input
														class="student-list" type="checkbox"
														name="check_student_list[]"
														value="<?php echo $student->user_id?>"> <?php echo $student->student_name; ?>
												</label></li>
												<?php }
												}else {?>
												<p class="empty-list">No Students Found</p>
												<?php }?>
											</ul>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="col-xs-6">
							<button id="notification-submit"
								class="kindergarden-color white  float-right margin-top-btm-10 send-nofification-button">Send</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php echo javascript_validation('sendNotificationForm', $JS_VALIDATION); ?>