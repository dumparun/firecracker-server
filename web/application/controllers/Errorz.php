<?php

/**
 *
 * @author Maganiva
 *
 */
require_once APPPATH . 'libraries/unsecured_view_controller.php';


class Errorz extends Customer_Unsecured_View_Controller
{
	function __construct(){
		parent::__construct();
	}

	public function show_404()
	{
		log_message('info', 'Error_Controller :: Showing 404 error page');

		$this->view_data['error_message'] = "The Page you Requested was not found";
		$this->view_data['error_code'] = "404";
		$this->view_data['title'] = "Error - Page Not Found";
		$this->view_data['nav_class'] = 'navbg3';
		$this->content_view = 'errorz';
	}
	
	public function show_error(){
		log_message('info', 'Error_Controller :: Showing error page');
		$this->view_data['error_message'] = $this->session->flashdata('error_msg');
		$this->view_data['error_code'] = "";
		$this->view_data['title'] = "Error - dil daru dosti";
		$this->view_data['nav_class'] = 'navbg3';
		$this->content_view = 'errorz';
	}
}
