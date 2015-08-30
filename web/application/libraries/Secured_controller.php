<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Secured_Controller extends MY_Controller {
	function __construct () {
		parent::__construct();
		$this->load->service("auth_service");

		if(!$this->auth_service->is_logged_in()){
			$requesturi = urlencode(uri_string().'?'.$this->input->server('QUERY_STRING'));
			redirect('auth/login?ruri='.$requesturi);
		}

	}

}