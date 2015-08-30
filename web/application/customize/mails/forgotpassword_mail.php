<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Build Mantra</title>
<style type="text/css">
#outlook a {
	padding: 0;
}

body {
	width: 100% !important;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
	margin: 0;
	padding: 0;
}

.ExternalClass {
	width: 100%;
} /* Force Hotmail to display emails at full width */
.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div
	{
	line-height: 100%;
}

#backgroundTable {
	margin: 0;
	padding: 0;
	width: 100% !important;
	line-height: 100% !important;
}

img {
	outline: none;
	text-decoration: none;
	-ms-interpolation-mode: bicubic;
}

a img {
	border: none;
}

.image_fix {
	display: block;
}

p {
	margin: 1em 0;
}

h1,h2,h3,h4,h5,h6 {
	color: black !important;
}

h1 a,h2 a,h3 a,h4 a,h5 a,h6 a {
	color: blue !important;
}

h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active
	{
	color: red !important;
}

h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited
	{
	color: purple !important;
}

table td {
	border-collapse: collapse;
}

table {
	border-collapse: collapse;
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
}

a {
	color: orange;
}

@media only screen and (max-device-width: 480px) {
	/* Part one of controlling phone number linking for mobile. */
	a[href^="tel"],a[href^="sms"] {
		text-decoration: none;
		color: blue; /* or whatever your want */
		pointer-events: none;
		cursor: default;
	}
	.mobile_link a[href^="tel"],.mobile_link a[href^="sms"] {
		text-decoration: default;
		color: orange !important;
		pointer-events: auto;
		cursor: default;
	}
}

@media only screen and (min-device-width: 768px) and (max-device-width:
	1024px) {
	a[href^="tel"],a[href^="sms"] {
		text-decoration: none;
		color: blue; /* or whatever your want */
		pointer-events: none;
		cursor: default;
	}
	.mobile_link a[href^="tel"],.mobile_link a[href^="sms"] {
		text-decoration: default;
		color: orange !important;
		pointer-events: auto;
		cursor: default;
	}
}

@media only screen and (-webkit-min-device-pixel-ratio: 2) {
}

@media only screen and (-webkit-device-pixel-ratio:.75) {
	/* Put CSS for low density (ldpi) Android layouts in here */
}

@media only screen and (-webkit-device-pixel-ratio:1) {
	/* Put CSS for medium density (mdpi) Android layouts in here */
}

@media only screen and (-webkit-device-pixel-ratio:1.5) {
	/* Put CSS for high density (hdpi) Android layouts in here */
}
</style>
</head>
<body>
	<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
		<tr>
			<td>
				<table cellpadding="4" cellspacing="0" border="0">

					<tr>
						<td>

							<p style="text-align: justify;">
								<b style="color: #800;">Greetings from Kindergarten -</b>
							</p>
						</td>
					</tr>
					<tr>
						<td><h4>
								Hello,
								<?php echo $firstName?>
							</h4></td>
					</tr>
					<tr>
						<td>
							<div>
								<p>Please click on the link below to choose a new password</p>
							</div>
						</td>
					</tr>
					<tr>
						<td><a href="<?php echo $loginUrl ?>" target="_blank">Link to
								reset password</a></td>
					</tr>
					<tr>
						<td><p>If you did not request a password reset, then please ignore
								this email.</P>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>

				</table> <br /> <br />


			</td>
		</tr>
	</table>

</body>
</html>
