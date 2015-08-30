<?php

/**
 *
 * @author Maganiva
 *
 */

require APPPATH . 'entities/response_status.php';
require APPPATH . 'entities/generic_response.php';

class Upload extends Unsecured_data_Controller {

	function __construct() {

		parent::__construct ();

	}

	public function uploadProfile() {

		$sessionKey = $_POST ['sessionKey'];
		$details =  $this->auth_service->fetchwithSessionKey($sessionKey);
		move_uploaded_file($_FILES[$userId]["tmp_name"], APPPATH . '../resources/profile/' . $details->user_id . '.png' );

		$status = new ResponseStatus ( 0, "Success" );
		$response = new GenericResponse ();
		$response->status = $status;
		$response->userId =  $details->user_id;

		$this->view_data ['JSON'] = json_encode ( $response );

	}

}
