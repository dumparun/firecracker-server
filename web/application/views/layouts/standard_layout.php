<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- fav icon -->
<link rel="icon" type="image/ico"
	href="<?php echo base_url();?>favicon.ico" />
<!-- end -->
<?php if(ENVIRONMENT == 'production'){ ?>

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/tp.<?php echo config_item('js_version') ?>.min.css">

<?php } else { ?>


<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>web/themes/default/thirdpartypackage/jqueryMsgBox/css/msgBoxLight.css" />

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>web/themes/default/thirdpartypackage/chosen/chosen.min.css" />

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/datepicker.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/jquery.loadmask.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/jquery.loadmask.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/mg-custom-style.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('web/themes/default');?>/css/kindergarten-style.css">


<?php } ?>

<!-- JQUERY Min JS -->
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/prod/jquery-2.0.3.min.js"></script>

<!-- JQUERY Min JS -->
<!--[if lte IE 8]> -->
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/prod/jquery-1.9.1.js"></script>
<script
	src="<?php echo base_url();?>web/js/thirdparty/prod/jquery-migrate-1.2.1.min.js"></script>
<!-- <![endif]-->
</head>

<body>
	<?php	
	if (in_array ( 'is_logged_in', $_SESSION )) {
		if ($_SESSION ['is_logged_in'] === true) {

			if ($header_view != null){?>
	<div class="body-outer ">
		<header>
			<?php echo $header_view?>
		</header>

		<?php	}
}
}else{ ?>

		<div class="body-outer login_bg">
			<?php } 
			if (in_array ( 'is_logged_in', $_SESSION )) {
		if ($_SESSION ['is_logged_in'] === true) {
					if ($menu_view != null){?>
			<nav class="navbar navbar-inverse navbar-static-top bg-white">
				<?php echo $menu_view;?>
			</nav>

			<?php
		}
			}
	}
	?>



			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<?php if($error_message != null ){?>
							<div id="errordiv" class="alert alert-danger  alert-dismissible"
								role="alert">
								<button type="button" class="close" data-dismiss="alert"
									aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php echo $error_message;?>
							</div>
							<?php }?>
							<?php if($success_message != null ){?>
							<div id="errordiv" class="alert alert-success  alert-dismissible"
								role="alert">
								<button type="button" class="close" data-dismiss="alert"
									aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php echo $success_message;?>
							</div>
							<?php }?>
							<div class="wrapper">
								<?php echo $content_view?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if (in_array ( 'is_logged_in', $_SESSION )) {
				if ($_SESSION ['is_logged_in'] === true) {
if ($footer_view != null){?>
			<footer class="footer fixed full-width bg-white">

				<div class="wrapper">
					<?php echo $footer_view?>
				</div>

			</footer>

			<?php }
}
}?>
			<?php if(isset($script_data)){
				echo "<script>" . $script_data . "</script>" ;
};?>
		</div>

</body>

<!--  Issue with compression -->
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/prod/jquery.lazyload.min.1.0.0.0.js"></script>
<!--  Issue with compression -->



<?php if(ENVIRONMENT == 'production'){ ?>


<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/prod/plugin.minifiedfiles.<?php echo config_item('js_version') ?>.js"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/themes/default/thirdpartypackage/tp.minifiedfiles.<?php echo config_item('js_version') ?>.js"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/prod/custom.min.<?php echo config_item('js_version') ?>.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/themes/default/thirdpartypackage/highcharts/highcharts.4.1.7.js?v=<?php echo config_item('js_version') ?>"></script>

<?php } else {?>

<script type="text/javascript"
	src="<?php echo base_url('web/themes/default');?>/thirdpartypackage/jqueryMsgBox/jquery.msgBox.min.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/dev/jquery.loadmask.min.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/dev/jquery.ba-outside-events.min.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/dev/sha3.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/themes/default/thirdpartypackage/chosen/chosen.jquery.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/themes/default/thirdpartypackage/highcharts/highcharts.4.1.7.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/auth.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/dashboard.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/general.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/rest.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/dev/jquery.validate.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/jqueryvalidations.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/themes/default/css/bootstrap/js/bootstrap.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/thirdparty/dev/bootstrap-datepicker.js?v=<?php echo config_item('js_version') ?>"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/common-script.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/locality_select.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/locality_search.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/school_manage.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/manage_holiday.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/manage_faculty.js?v=<?php echo config_item('js_version') ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>web/js/custom/manage_students.js?v=<?php echo config_item('js_version') ?>"></script>
<?php } ?>

<script type="text/javascript">
	<!-- this is for image lazy loading -->
	$( window ).load(function() {
	        $("img.lazy").trigger("sporty")
	});
	
	$(function() {
	    $("img.lazy").lazyload({
	        event : "sporty",
	        effect : "fadeIn",
	        //placeholder: "<?php echo base_url("web/themes/default/css/images/loading.gif");?>"
	    });
	});
	</script>

<?php

if (isset ( $script_data )) {
		echo "<script>" . $script_data . "</script>";
	}
	;
	?>
</body>
</html>


