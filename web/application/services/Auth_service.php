<?php

/**
 * @author Maganiva
 *
 */

require_once BASE_APPPATH . 'entities/authentication.php';

require_once BASE_APPPATH . 'utilities/security_util.php';


class Auth_Service extends Service {

	function __construct() {

		parent::__construct ();


		$this->load->model ( 'Auth_model' );

		$this->load->model ( 'Faculty_model' );

		$this->load->model ( 'Student_model' );

		$this->load->model ( 'School_model' );
	}

	public function is_logged_in() {

		log_message ( 'info', 'Auth_Service :: is_logged_in => is_logged_in is called' );

		if (in_array ( 'is_logged_in', $_SESSION )) {
			$is_logged_in = $_SESSION ['is_logged_in'];
		}
		return (isset ( $is_logged_in ) && $is_logged_in == true);

	}


	public function doLogin($email, $password) {

		if ((strlen ( $email ) > 0) and (strlen ( $password ) > 0)) {

			$user = new Authentication ( $this->Auth_model->getUserWithEmail ( $email ) );

			if ($user != NULL &&  $user->user_id > 0 ) {
				if (strcmp ( $user->status, 0 ) === 0 ) {
					return FALSE;
				}

				if(strcmp ( $user->user_type, 2 ) === 0 || strcmp ( $user->user_type, 3 ) == 0){
					if(strcmp ( $user->user_type, 2 ) === 0 ){
						$userDetails = $this->Faculty_model->fetchFacultyById($user->user_id);
					}

					if(strcmp ( $user->user_type, 3 ) === 0 ){

						$userDetails = $this->Student_model->fetchStudentById($user->user_id);
					}

					$schoolDetails = $this->School_model->fetchSchoolByID($userDetails->school_id);
					if($schoolDetails->authentication->status == 0){
						return 0;
					}

				}
				return $this->_checkPasswordAndSetUserInSession ( $user, $password );
			}
			else {
				return FALSE;
			}
		}
		return FALSE;

	}

	private function _checkPasswordAndSetUserInSession($user,$password){
		$securityUtil = new SecurityUtil ();
		$convertedPassword = $securityUtil->createPassword ( $password, $user->salt );
		if (strcmp ( $user->password, $convertedPassword ) === 0) {
			$this->_setUserInSession ( $user );
			return $user;
		}
		else {
			return null;
		}
	}

	private function _setUserInSession($user){

		$_SESSION ['user_id'] = $user->user_id;
		$_SESSION ['user_email'] = $user->email_id;
		$_SESSION ['user_type'] = $user->user_type;
		$_SESSION ['is_logged_in'] = true;

		$userName = "User";
		if($user->user_type == 0){
			$userName = "Admin";
		}
		if($user->user_type == 1){
			$userDetails =  $this->School_model->fetchSchoolByID($user->user_id);
			$userName = $userDetails->school_name;
		}
		if($user->user_type == 2){
			$userDetails =  $this->Faculty_model->fetchFacultyById($user->user_id);
			$userName = $userDetails->faculty_name;
		}
		if($user->user_type == 3){
			$userDetails =  $this->Student_model->fetchStudentById($user->user_id);
			$userName = $userDetails->student_name;
		}


		$_SESSION ['user_name'] = $userName;

	}


	public function logout() {

		$_SESSION ['user_id'] = null;
		$_SESSION ['user_email'] = null;
		$_SESSION ['user_type'] = null;
		$_SESSION ['is_logged_in'] = false;
		$_SESSION ['user_name'] = null;
	}

	public function register($authDetails) {

		$securityUtil = new SecurityUtil ();

		$authDetails->salt = "";
		$authDetails->password = "";
		$authDetails->hash_code = SecurityUtil::getRandomString ( 40, null );
		$authDetails->status = 2;

		$duplicateUser = $this->Auth_model->getUserWithEmail($authDetails->email_id);
		if($duplicateUser == null){
			return $this->Auth_model->registerUser ( $authDetails );
		}else{
			return null;
		}

	}


	public function verifyUser($email,$code){

		$auth = $this->Auth_model->getUserWithEmail ( $email );

		if ($auth != null) {
			// either reset password or newly registered
			if (strcmp ( $auth->hash_code, $code ) === 0 && (strcmp ( $auth->status, 2 ) === 0 || strcmp ( $auth->status, 3 ) === 0)) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	public function verifyPassword( $email, $password ){

		if ((strlen ( $email ) > 0) and (strlen ( $password ) > 0)) {
			$user = $this->Auth_model->getUserWithEmail ( $email );
			if ($user != NULL && $user->user_id > 0 && strcmp ( $user->status, 1 ) === 0) {
				$securityUtil = new SecurityUtil ();
				$convertedPassword = $securityUtil->createPassword ( $password, $user->salt );
				if (strcmp ( $user->password, $convertedPassword ) === 0) {
					return $user;
				}
				else {
					return null;
				}
			}
			else {
				return null;
			}
		}
		return null;

	}


	public function updateUserPassword($auth) {

		if (strlen ( $auth->password ) > 0) {
			$securityUtil = new SecurityUtil ();

			$auth->salt = SecurityUtil::getSalt ();
			$auth->password = $securityUtil->createPassword ( $auth->password, $auth->salt );
			$auth->status = 1;
			$ret = $this->Auth_model->updateUser ( $auth );
			if ($ret === true) {
				$this->_setUserInSession ( $auth );
				return $auth;
			}
		}
		return FALSE;

	}

	public function forgotPassword($auth){
		if ($auth != null && $auth->user_id > 0) {
			$auth->salt = "";
			$auth->password = "";
			$auth->status = 3;
			$auth->hash_code = SecurityUtil::getRandomString ( 40, null );
			$this->Auth_model->updateUser ( $auth );
			return $auth;
		}
		return null;

	}

	public function getUserWithID($userID){
		return $this->Auth_model->getUserWithID($userID);
	}

	public function getUserWithEmail($email){
		return $this->Auth_model->getUserWithEmail($email);
	}

	public function changeUserStatus($userID,$status){
		return $this->Auth_model->changeUserStatus($userID,$status);
	}


	public function getCountOfSchool($allStatus = true){

		if($allStatus === true){

			$schoolCount[0] =  $this->Auth_model->getCountOfSchools(0);

			$schoolCount[1] =  $this->Auth_model->getCountOfSchools(1);

			$schoolCount[2] =  $this->Auth_model->getCountOfSchools(2);

			$schoolCount[3]  =  $this->Auth_model->getCountOfSchools(3);

			$schoolCount[4] =  $this->Auth_model->getCountOfSchools(null);

		}else{
			$schoolCount =  $this->Auth_model->getCountOfSchools($allStatus);

		}

		return $schoolCount;

	}
	public function getCountOfFaculty($allStatus = true){

		if($allStatus === true){

			$facultyCount[0] =  $this->Auth_model->getCountOfFaculty(0);

			$facultyCount[1] =  $this->Auth_model->getCountOfFaculty(1);

			$facultyCount[2] =  $this->Auth_model->getCountOfFaculty(2);

			$facultyCount[3]  =  $this->Auth_model->getCountOfFaculty(3);

			$facultyCount[4] =  $this->Auth_model->getCountOfFaculty(null);

		}else{
			$facultyCount =  $this->Auth_model->getCountOfFaculty($allStatus);

		}

		return $facultyCount;

	}
	public function getCountOfStudents($allStatus = true){

		if($allStatus === true){

			$studentsCount[0] =  $this->Auth_model->getCountOfStudents(0);

			$studentsCount[1] =  $this->Auth_model->getCountOfStudents(1);

			$studentsCount[2] =  $this->Auth_model->getCountOfStudents(2);

			$studentsCount[3]  =  $this->Auth_model->getCountOfStudents(3);

			$studentsCount[4] =  $this->Auth_model->getCountOfStudents(null);

		}else{
			$studentsCount =  $this->Auth_model->getCountOfStudents($allStatus);

		}

		return $studentsCount;

	}

}
