<!DOCTYPE html>
<html lang="en">
<head>
<title>404 Page Not Found</title>
<style type="text/css">
::selection {
	background-color: #E13300;
	color: white;
}

::moz-selection {
	background-color: #E13300;
	color: white;
}

::webkit-selection {
	background-color: #E13300;
	color: white;
}

body {
	background-color: #fff;
	font: Arial, sans-serif;
}

.full-width {
	width: 100%;
}

.float-left {
	float: left;
}

.float-right {
	float: right;
}

.logo_bm_big,.icon-home {
	background:
		url("<?php echo base_url();?>/web/themes/default/css/images/sprite-customer.png")
		no-repeat;
}

.icon-home {
	margin: 0px !important;
	background-position: -441px -43px;
	width: 27px;
	height: 20px;
}

.display-block {
	display: block;
}

.logo_bm_big {
	background-position: -1px -154px;
	width: 271px;
	height: 82px;
	display: inline-block;
}

.error-div {
	margin: 50px 100px;
}

.content-container {
	width: 100%;
	min-height: 460px;
}

.customer-wrapper {
	width: 980px;
	margin: 0 auto;
	position: relative;
}

.home-btn {
	color: #FFF !important;
	border: 1px solid #FFF;
	margin: 10px 0px 10px 10px;
	display: inline-block;
	padding: 5px;
	background: #800;
	font-size: 12px;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div class="content-container">
		<div class="customer-wrapper">
	<div class="full-width">
				<a href="<?php echo base_url();?>"
					class="float-left">
					<!-- 
					<span class="icon-home" style="display: inline-block;"></span> --><span
					class="home-btn">HOME</span> </a> <a href="<?php echo base_url();?>"
					class="logo_bm_big  float-right"> </a>
			</div>
			<div class="error-div float-left">
				<img
					src="<?php echo base_url();?>web/themes/default/css/images/404-not-found.jpg">
			</div>

		</div>
	</div>
</body>
</html>
