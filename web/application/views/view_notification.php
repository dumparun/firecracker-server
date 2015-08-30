<div class="row" id="viewSchoolContent">
	<div class="col-xs-12">
		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<h2 class="text-center">Notifications</h2>
			</div>
			<div class="panel-body">
				<div class="row">



					<div class="col-xs-12">
						<?php $newMessageCount=$notificationCount; if($notifications!=null){?>
						<div class="table-responsive">

							<table
								class="table table-striped table-hover font-12 table-notification"
								id="">
								<thead>
									<?php foreach ($notifications as $notificationItem){
										?>
									<tr
										class="table-notification-tr <?php if($newMessageCount>0){ $newMessageCount--;?>
										new-message <?php }?>">
										<th><table>
												<tr>
													<th><?php echo $notificationItem->email_id;?></th>

												</tr>
												<tr>
													<th class="notification-message text-justify normal"><?php echo $notificationItem->message;?>
													</th>
												</tr>
												<tr>
													<th class="font-12"><?php echo date('M j Y g:i A', strtotime($notificationItem->timestamp));?>
													</th>

												</tr>
											</table>
										</th>
										<th class="float-right"><?php if($notificationItem->user_type==1){
											echo "School";
										}else if($notificationItem->user_type==2){
echo "faculty";
}?>
										</th>

									</tr>
									<?php }
}else{ ?>
									<p class="empty-list">No Notifications</p>

									<?php }?>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
