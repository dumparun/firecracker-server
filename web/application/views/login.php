<div class="row row-after-header">
	<div class="col-xs-12 col-md-5 col-md-offset-3">
		<div class="panel login_panel margin-top160 login_box_bg">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="gb_logo login_logo"></div>
						</div>
						<div class="col-sm-4 login_box_bg">
							<a href="<?php echo base_url();?>Auth/forgotPassword"
								class="font-11 underline">Forgot passwod? </a>
						</div>

					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">

					<div
						class="col-xs-12  col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">

						<form action="<?php echo base_url("auth/login") ?>" method="post"
							class="form-horizontal" id="loginForm" autocomplete="off">
							<div class="form-group">
								<label for="emailInput" class="col-sm-3 font-15 bold">Email</label>
								<div class="col-sm-9">

									<input type="email" class="form-control" id="emailInput"
										placeholder="Email" name="email_id">
								</div>
							</div>
							<div class="form-group">
								<label for="passwordInput" class="col-sm-3 font-15 bold">Password</label>
								<div class="col-sm-9">
									<input type="hidden" id="passwordHidden" name="hidden_password">
									<input type="password" class="form-control" id="passwordInput"
										placeholder="Password" name="password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6 text-center">
									<input type="hidden" name="redirect"
										value="<?php echo (isset($_GET['ruri']) ? $_GET['ruri'] : "");?>">

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
<?php echo javascript_validation('loginForm', $JS_VALIDATION, $JS_SUBMITHANDLER); ?>