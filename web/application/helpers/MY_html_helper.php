<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('error_message'))
{
	function error_message($message = 'Please check the page for errors and submit again', $header = 'Error')
	{
		return $error = '<div class="error reject"><a class="hide_error" data-dismiss="alert" href="#"></a>'.
				 	     	'<div>'.
					        	'<h2>'.$header.'</h2>'.
					        		'<p>'.$message.'</p>'.
					         '</div>'.
					     '</div>';
	}
}


if ( ! function_exists('exception_message'))
{
	function exception_message($message = 'Please check the page for errors and submit again', $header = 'Error')
	{

		return $error = '<div class="error reject"><a class="hide_error" data-dismiss="alert" href="#"></a>'.

				'<div>'.
				'<h2>'. "Error Code: " . $header.'</h2>'.
				'<p>'.$message.'</p>'.
				'</div>'.
				'</div>';
	}
}
					
if ( ! function_exists('helptip'))
{
	function helptip($message = '')
	{
		return $helptip = '<a class="helptip" title="'.$message.'"></a>';
	}
}
/* End of file My_html_helper.php */