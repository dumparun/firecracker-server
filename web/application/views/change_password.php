<div class="row">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Change Password</h2>
			</div>
			<div class="panel-body">
				<div class="row">

					<div class="col-xs-12 col-md-8 col-md-offset-2">

						<form action="<?php echo base_url("auth/setPassword") ?>"
							method="post" class="form-horizontal" id="changePasswordForm"
							autocomplete="off">
							<div class="form-group">
								<label for="emailInput" class="col-sm-4 text-right">Email</label>
								<div class="col-sm-8">

									<input type="email" class="form-control" id="emailInput"
										placeholder="Email" name="email_id"
										value="<?php echo $_SESSION["user_email"];?>" disabled />
								</div>
							</div>
							<div class="form-group">
								<label for="passwordInput" class="col-sm-4 text-right">Password</label>
								<div class="col-sm-8">
									<input type="hidden" id="passwordHidden" name="hidden_password">
									<input type="password" class="form-control" id="passwordInput"
										placeholder="Password" name="password">
								</div>
							</div>
							<div class="form-group">
								<label for="newPasswordInput" class="col-sm-4 text-right">New
									Password</label>
								<div class="col-sm-8">
									<input type="hidden" id="newPasswordHidden"
										name="hidden_new_password"> <input type="password"
										class="form-control" id="newPasswordInput"
										placeholder="Password" name="new_password" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<label for="confirmNewPasswordInput" class="col-sm-4 text-right">Confirm
									Password</label>
								<div class="col-sm-8">
									<input type="hidden" id="newPasswordConfirmHidden"
										name="hidden_confirm_new_password"> <input type="password"
										class="form-control" id="confirmNewPasswordInput"
										placeholder="Password" name="confirm_new_password"
										maxlength="20">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-8">
									<button type="submit" class="btn btn-primary full-width">Submit</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo javascript_validation('changePasswordForm', $JS_VALIDATION, $JS_SUBMITHANDLER); ?>