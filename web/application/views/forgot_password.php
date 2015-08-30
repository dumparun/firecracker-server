<div class="row row-after-header">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="text-center">Password Recovery</h4>
			</div>
			<div class="panel-body">
				<div class="row">

					<div
						class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">

						<form action="<?php echo base_url("auth/passwordRecovery") ?>"
							method="post" class="form-horizontal" id="forgotPasswordForm"
							autocomplete="off">
							<div class="form-group">
								<label for="emailInput" class="col-sm-2">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" placeholder="Email"
										name="email_id">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10 text-center">
									<button type="submit" class="btn btn-danger">Submit</button>
								</div>
							</div>

						</form>



					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo javascript_validation('forgotPasswordForm', $JS_VALIDATION); ?>