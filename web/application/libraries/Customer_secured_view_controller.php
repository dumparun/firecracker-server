<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


/**
 *
 * @author Maganiva
 *
 *
*/
require_once APPPATH . 'libraries/Secured_view_controller.php';

class Customer_Secured_View_Controller extends Secured_View_Controller {


	function __construct() {

		parent::__construct ();
	}


	public function _output($output) {

		$this->_setup_registerform_validation ();
		if (!isset($_SESSION['menuitems'] )) {
			$this->_getCategoryAndSubCategory ();
		}

		return parent::_output ( $output );

	}


	private function _getCategoryAndSubCategory() {

		if( !isset($_SESSION['localityName'])){
			$_SESSION['pincode'] = null;
			$_SESSION['localityName'] = null;
			$_SESSION['localityId'] = null;
		}

	}


	private function _setup_registerform_validation (){
		log_message ( 'info', 'auth_Controller :: _setup_validation => _setup_validation is called' );


		$as_option = array (
				'rules' => array (
						'user-email' => array (
								'required' => true,
								'email' => true
						),
						'user-password' => array (
								'required' => true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength-customer' => true
						),
						'user-first-name' => array(
								'required'=>true,
								'minlength' => 3
						),
						'user-password-confirm' => array(
								'required'=>true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength-customer' => true,
								'confirmPassword-customer' => true
						),
						'forgotPasswordEmail' =>array(
								'required' =>true,
								'email' => true
						)
				),
				'messages' => array (
						'user-email' => array (
								'required' => "Please enter Email Address",
								'email' =>"Enter a valid Email address"
						),
						'user-first-name' => array(
								'required'=>"Please enter your Name",
								'minlength' => "Name should be minimum 3 characters"
						),
						'user-password' => array (
								'required' => "Please enter a password",
								'minlength' => "Password should be minimum 5 characters",
								'maxlength' => "Password can be maximum 20 characters",
								'passwordStrength-customer' => "Characters, Numbers and !\-@._*&# allowed"
						),
						'user-password-confirm' => array(
								'required'=>"This field is required",
								'minlength' => "Password should be minimum 5 characters",
								'maxlength' => "Password can be maximum 20 characters",
								'passwordStrength-customer' => "Characters, Numbers and !\-@._*&# allowed",
								'confirmPassword-customer' => "Both passwords does not match"
						),
						'forgotPasswordEmail' =>array(
								'required' =>"Please enter Email Address",
								'email' => "Enter a valid Email Address"
						)
				)
		);
		$this->view_data ['JS_VALIDATION1'] = json_encode ( $as_option );
		$this->view_data ['JS_SUBMITHANDLER2'] = "adminLoginCheck(form);";
		$this->view_data ['JS_SUBMITHANDLER1'] = "registerLoginCheck(form);";
	}

}