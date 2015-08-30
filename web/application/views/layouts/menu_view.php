<div class="wrapper">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed"
			data-toggle="collapse" data-target="#navBar" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
	</div>


	<div class="collapse navbar-collapse" id="navBar">
		<ul class="nav navbar-nav">
			<li id="home"><a href="<?php echo base_url()?>home/kinderGartenHome"
				class="text-glow"><span
					class="glyphicon glyphicon-home inlineblock margin-left-right-5"></span>Home
			</a></li>

			<?php if(isset($_SESSION["user_type"])&& $_SESSION["user_type"] ==  0 ){?>
			<li id="registerSchool"><a
				href="<?php echo base_url()?>schoolmanage/schoolRegistration"
				class="text-glow"><span
					class="glyphicon  glyphicon-edit inlineblock margin-left-right-5"></span>Register
					School </a></li>
			<li id="viewSchool"><a
				href="<?php echo base_url()?>schoolmanage/viewAllSchools"
				class="text-glow"><span
					class="glyphicon  glyphicon-cog inlineblock margin-left-right-5"></span>Manage
					Schools</a>
			</li>

			<?php }?>

			<?php if(isset($_SESSION["user_type"])&& $_SESSION["user_type"] ==  1 ){?>
			<li><a class="dropdown-toggle text-glow" data-toggle="dropdown"
				href="#" role="button" aria-haspopup="true" aria-expanded="false">Faculty<span
					class="caret"></span>
			</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url()?>Faculty/addFaculty"
						class="text-glow">Add New Faculty</a>
					</li>
					<li><a href="<?php echo base_url()?>Faculty/manageFaculty"
						class="text-glow">Manage Faculty</a>
					</li>
					<li><a
						href="<?php echo base_url()?>Faculty/uploadFacultyDetailsExcel"
						class="text-glow">Upload Faculty</a>
					</li>
				</ul>
			</li>

			<li><a class="dropdown-toggle text-glow" data-toggle="dropdown"
				href="#" role="button" aria-haspopup="true" aria-expanded="false">Students<span
					class="caret"></span>
			</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url()?>Students/addStudents"
						class="text-glow">Add New Students</a>
					</li>
					<li><a href="<?php echo base_url()?>Students/manageStudents"
						class="text-glow">Manage Students</a>
					</li>
					<li><a
						href="<?php echo base_url()?>Students/uploadStudentsDetailsExcel"
						class="text-glow">Upload Students</a>
					</li>
				</ul>
			</li>

			<li><a class=" text-glow"
				href="<?php echo base_url()?>Holiday/ManageHolidays">Manage Holidays<span></span>
			</a>
			</li>

			<li><a href="<?php echo base_url()?>schoolmanage/sendNotification"
				class="text-glow">Send Notification</a>
			</li>
			<?php }?>

			<li><a id="notification-link" class="relative text-glow"
				href="<?php echo base_url()?>schoolmanage/viewNotification"><span
					class="glyphicon  glyphicon-info-sign inlineblock margin-left-right-5"></span>Notifications</a>
				<!-- 
				<?php if($notificationCount!=0){?>
				<div
					class="notification-box absolute white text-center text-middle ">
					<?php echo $notificationCount;?>
				</div> <?php }?>
				<div class="absolute notification-list hide">
					<ul class="not-list">
						<?php foreach ($notifications as $notification){?>
						<li><?php echo $notification->message;?></li>
						<?php }?>

					</ul>
				</div> --></li>

		</ul>
		<div class="clear"></div>
	</div>
</div>
