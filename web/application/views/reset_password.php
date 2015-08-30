<div class="row row-after-header">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Reset Password</h2>
			</div>
			<div class="panel-body">
				<div class="row">

					<div class="col-xs-12 col-md-8 col-md-offset-2">

						<form action="<?php echo base_url("auth/resetPassword") ?>"
							method="post" class="form-horizontal" id="resetPasswordForm"
							autocomplete="off">
							<div class="form-group">
								<label for="emailInput" class="col-sm-4 text-right">Email</label>
								<div class="col-sm-8">
									<input type="hidden" name="email_hidden"
										value="<?php echo $emailId;?>" /> <input type="email"
										class="form-control" id="emailInput" placeholder="Email"
										name="email_id" value="<?php echo $emailId;?>" disabled />
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
								<label for="passwordConfirmHidden" class="col-sm-4 text-right">Confirm
									Password</label>
								<div class="col-sm-8">
									<input type="hidden" id="passwordConfirmHidden"
										name="hidden_confirm_password"> <input type="password"
										class="form-control" id="confirmPasswordInput"
										placeholder="Password" name="confirm_password">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-8">
									<button type="submit" class="btn btn-default">Submit</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo javascript_validation('resetPasswordForm', $JS_VALIDATION, $JS_SUBMITHANDLER); ?>
