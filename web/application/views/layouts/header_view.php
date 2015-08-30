<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 header-logo">
				<a href="<?php echo base_url();?>"><img
					src="<?php echo base_url();?>web/themes/default/css/images/geometriboxlogo.png" />
				</a>
			</div>
			<?php if(isset($_SESSION["is_logged_in"]) &&  $_SESSION["is_logged_in"] == true){?>
			<div class="col-xs-12 col-sm-6 col-md-6 text-right">

				<?php if(isset($_SESSION["user_type"]) &&  $_SESSION["user_type"] == 0){

					$userName = "Admin";
				}else{
if(isset($_SESSION["user_name"]) && $_SESSION["user_name"] != null){

				$userName = $_SESSION["user_name"];
}else{
$userName = "User";
}

}?>

				<span class="inlineblock user-name-display">Welcome, <?php echo $userName;?>
					<button class="no-bg no-border user-actions"
						onclick="displayUserActionsMenu(event);">
						<span class="badge  width-height-20" id="userActionBadge"> <span
							class="caret"></span>
						</span>
					</button>
				</span>


				<div
					class="absolute text-center user-actions-menu margin-top-btm-10"
					id="userActions">

					<div class="list-group">
						<a href="<?php echo base_url()?>Auth/changePassword"
							class="list-group-item ">Change Passsword </a> <a
							href="<?php echo base_url()?>Auth/logout" class="list-group-item">Logout</a>
					</div>


				</div>

			</div>
			<?php }?>
		</div>
	</div>
</div>
