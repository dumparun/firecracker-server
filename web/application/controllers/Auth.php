<?php

/**
 *
 * @author Maganiva
 *
 */

require_once BASE_APPPATH . 'utilities/mail/email_template.php';
require_once BASE_APPPATH . 'utilities/mail/emailer.php';


class Auth extends Unsecured_View_Controller {

	function __construct() {

		parent::__construct ();
		$this->load->service ( 'Auth_service' );
		$this->load->service ( 'School_service' );
	}


	public function login() {

		if ($_POST) {

			// The user has submitted the registration form
			// TODO Validation

			$email = $this->input->post ( 'email_id' );
			$password = $this->input->post ( 'hidden_password' );

			$ruri  =   $this->input->post ( 'redirect');

			if($ruri == ""){
				$ruri = 'home/kinderGartenHome';
			}

			$user = $this->Auth_service->doLogin ( $email, $password );

			if ($user === null || $user === false) {
				$this->session->set_flashdata ( 'errorMessage', "Invalid UserID or Password" );
				$this->_setup_login_validation ();
				$this->content_view = "login";
				return;
			}
				
			if ($user === 0) {
				$this->session->set_flashdata ( 'errorMessage', "Please contact administrator" );
				$this->_setup_login_validation ();
				$this->content_view = "login";
				return;
			}
				
			else if ($user->status === 0) {

				$this->session->set_flashdata ( 'errorMessage', "Error occured Try later" );
				$this->_setup_login_validation ();
				$this->content_view = "login";
				return;
			}
			else {
				redirect ( $ruri );
				return;
			}
		}
		else {

			if (isset($_SESSION["is_logged_in"] ) && $_SESSION["is_logged_in"] == true ) {
				redirect ( 'home/kinderGartenHome' );
			}else{
				$this->_setup_login_validation ();
				$this->content_view = "login";
				return;
			}


		}

	}


	private function _setup_login_validation() {

		$as_option = array (
				'rules' => array (
						'email_id' => array (
								'required' => true,
								'email' => true
						),
						'password' => array (
								'required' => true
						)
				),
				'messages' => array (
						'email_id' => array (
								'required' => "Enter email address",
								'email' => "Enter a valid email Address"
						),
						'password' => array (
								'required' => "Enter Password"
						)
				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->view_data ['JS_SUBMITHANDLER'] = "login(form);";
		$this->validator->set_rules ( $as_option );

	}


	public function logout(){

		$this->Auth_service->logout();

		$this->session->set_flashdata ( 'successMessage', "Successfully Logged out" );
		redirect("auth/login");
	}


	/*Called to display Change password view*/

	public function changePassword(){

		if (isset($_SESSION["is_logged_in"] ) && $_SESSION["is_logged_in"] == true ) {
			$this->_setup_changepassword_validation();
			$this->content_view ="change_password";
		}else{
			redirect ( "Auth/login" );
		}

	}

	/*Ends here*/



	private function _setup_changepassword_validation(){

		log_message ( 'info', 'MyAccount Controller :: _setup_changepassword_validation => _setup_changepassword_validation is called' );
		$as_option = array (
				'rules' => array (
						'password' => array (
								'required' => true,
						),
						'new_password' => array (
								'required' => true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength' => true,
								'verifysameChangePassword' => "#passwordInput"
						),
						'confirm_new_password' => array (
								'required' => true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength' => true,
								'confirmPassword' => "#newPasswordInput",
						),
				),
				'messages' => array (
						'password' => array (
								'required' => "Please enter Password",
						),
						'new_password' => array (
								'required' => "Please enter Password",
								'minlength' => "Password should be minimum 5 characters long",
								'maxlength' => "Password can be maximum 20 characters long",
								'passwordStrength' => "Characters, Numbers and !\-@._*&# allowed",
								'verifysameChangePassword' => "New password cannot be same as old password"
						),
						'confirm_new_password' => array (
								'required' => "Please enter Password",
								'minlength' => "Password should be minimum 5 characters long",
								'maxlength' => "Password can be maximum 20 characters long",
								'passwordStrength' => "Characters, Numbers and !\-@._*&# allowed",
								'confirmPassword' => "Both passwords does not match",

						),

				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->view_data ['JS_SUBMITHANDLER'] = "changePasswordCheck(form);";
		$this->validator->set_rules ( $as_option );

	}


	/*Called When Change password form submitted*/

	public function setPassword() {

		if ($_POST) {
			$password = $this->input->post ( "hidden_password" );
			$newPassword = $this->input->post ( "hidden_new_password" );
			$email = $_SESSION ['user_email'];
			$auth = $this->Auth_service->verifyPassword ( $email, $password );
			if ($auth != null) {
				$auth->password = $newPassword;
				$this->Auth_service->updateUserPassword ( $auth );
				$this->session->set_flashdata ( 'successMessage', "Your password has been changed successfully" );
				redirect ( 'home/kinderGartenHome' );
				return;
			}
			else {
				$this->session->set_flashdata ( 'errorMessage', "Sorry, Invalid Password, Try again" );
				redirect ( 'Auth/changePassword' );
				return;
			}
		}
		else {
			$this->session->set_flashdata ( 'errorMessage', "Sorry, Invalid Password, Try again" );
			redirect ( 'Auth/changePassword' );
			return;
		}

	}

	/*Ends here*/

	/*Called to verify email link for newly registered OR password Reset*/
	public 	function verifyemail(){

		$email = $this->input->get ( 'email' );
		$code = $this->input->get ( 'code' );

		$return = $this->Auth_service->verifyUser ( $email, $code );
		if ($return !== false) {
			$this->view_data ["emailId"] = $email;
			$this->content_view = 'reset_password';
			$this->_setup_resetpassword_validation ();
			return;
		}
		else {
			$this->session->set_flashdata ( 'errorMessage', "This is not a valid email id or authentication string, please check with the administrator" );
			redirect ( "Auth/login" );
			return;
		}
	}
	/*Ends here*/

	private function _setup_resetpassword_validation(){

		$as_option = array (
				'rules' => array (
						'password' => array (
								'required' => true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength' => true,
						),
						'confirm_password' => array (
								'required' => true,
								'minlength' => 5,
								'maxlength' => 20,
								'passwordStrength' => true,
								'confirmPassword' => "#passwordInput",
						),
				),
				'messages' => array (
						'password' => array (
								'required' => "Please enter Password",
								'minlength' => "Password should be minimum 5 characters long",
								'maxlength' => "Password can be maximum 20 characters long",
								'passwordStrength' => "Characters, Numbers and !\-@._*&# allowed",
						),
						'confirm_password' => array (
								'required' => "Please enter Password",
								'minlength' => "Password should be minimum 5 characters long",
								'maxlength' => "Password can be maximum 20 characters long",
								'passwordStrength' => "Characters, Numbers and !\-@._*&# allowed",
								'confirmPassword' => "Both passwords does not match",

						),
				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->view_data ['JS_SUBMITHANDLER'] = "resetPasswordCheck(form);";
		$this->validator->set_rules ( $as_option );

	}



	/*Called When Reset password form submitted*/

	public function resetPassword() {

		if ($_POST) {
			$password = $this->input->post ( "hidden_password" );
			$confirmPassword = $this->input->post ( "hidden_confirm_password" );
			$email = $this->input->post("email_hidden");
			$userDuplicate = $this->Auth_service->getUserWithEmail ( $email );
			if (! empty ( $userDuplicate )) {
				$user = $userDuplicate ;
				if ($user->user_id != null && (strcmp ( $user->status, 2 ) === 0 || strcmp ( $user->status, 3 ) === 0)) {
					$user->password = $password;
					$user->hash_code = '';
					$user->status = 1;
					$this->Auth_service->updateUserPassword ( $user );
					$this->session->set_flashdata ( 'successMessage', "Your Password has been reset succesfully" );
					redirect ( "home/home" );
					return;
				}
			}
			else {
				$this->session->set_flashdata ( 'errorMessage', "This does not seems to be a valid account, please contact the customer support" );
				redirect ( "home/home" );
				return;
			}
		}
		else {
			redirect ( "home/home" );
		}

	}

	/*Ends here*/

	public function forgotPassword(){
		$this->_setup_forgotpassword_validation();
		$this->content_view ="forgot_password";
	}

	private function _setup_forgotpassword_validation(){

		$as_option = array (
				'rules' => array (
						'email_id' => array (
								'required' => true,
								'email' =>true
						),
				),
				'messages' => array (
						'email_id' => array (
								'required' => "Please enter Email",
								'email' => "Enter email"
						),
				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->validator->set_rules ( $as_option );

	}


	public function passwordRecovery(){

		if ($_POST) {
			$email = $this->input->post ( "email_id" );
			$auth = $this->Auth_service->getUserWithEmail ( $email );
			if (! empty ( $auth )) {
				if ($auth->user_id != null) {
					// whether inactive, active or reset password
					if ($auth->status == 0 || $auth->status == 1 || $auth->status == 3) {
						$this->Auth_service->forgotPassword ( $auth );

						if($auth->user_type == 0){

							$auth->userName = "MG Admin";
						}

						if($auth->user_type == 1){
							$schoolDetails= $this->School_service->fetchSchoolByID($auth->user_id);
							$auth->userName = $schoolDetails->school_name;
						}
						$this->_sendForgotPasswordMail ( $auth );
						$this->session->set_flashdata ( 'successMessage', "Reset Password Email has been sent succesfully" );
						redirect ( "Auth/login" );
						return;
					}
					else {
						$message =  "Not a Valid User, please contact Customer Support." ;
					}
				}

			}
			else {
				$message =  "Invalid Email Id";
			}
		}

		$this->session->set_flashdata ( 'errorMessage',$message);
		redirect ( "Auth/login" );
		return;
	}

	private function _sendForgotPasswordMail($auth){

		$emailer = new Emailer ( "support@kindergarten.com", null, null, 'no-reply@kindergarten.com' );
		$template = new EmailTemplate ( BASE_APPPATH . 'customize/mails/forgotpassword_mail.php' );
		$template->firstName = $auth->userName;
		$template->loginUrl = "http://localhost/kindergarten-server/auth/verifyemail?email=" . $auth->email_id . "&code=" . $auth->hash_code;
		$emailer->SetTemplate ( $template, "Reset Password- Kindergarten" ); // Email runs the compile
		$returnVal = $emailer->send ();

	}
}