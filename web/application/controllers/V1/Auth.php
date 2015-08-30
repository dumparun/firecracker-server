<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/utilities/security_util.php';

require APPPATH . '/entities/generic_response.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/login_response.php';

require APPPATH . '/entities/student_response.php';

require APPPATH . '/entities/user_response.php';

require APPPATH . '/entities/authentication.php';

class Auth extends REST_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->service("Auth_service");

		$this->load->service("Student_service");

		$this->load->service("Faculty_Service");

		$this->load->service("District_service");
		
		$this->load->service("Locality_service");
		
		$this->load->service("Address_service");

		$this->load->service("State_service");
		
	}

	function registerUser_post() {

		// validate the session Key
		$user = new user ();

		$user->email_id = $this->post ( "email_id" );

		$user->user_name = $this->post ( "user_name" );

		$user->password = $this->post ( "password" );

		$user->mobile_number = $this->post ( "mobile_number" );

		$user->profile_image = $this->post ( "userImage" );

		$sessionKey = $this->auth_service->registerUser ( $user );

		$response = new LoginResponse ( false );

		if ($sessionKey != null) {

			$status = new ResponseStatus ( 0, "success" );
		}
		else {
			$response->status = new ResponseStatus ( 100, "Email Id already exists" );

			$this->response ( $response );

			return;
		}

		$response->sessionKey = $sessionKey;

		$response->status = $status;

		$this->response ( $response );

	}

	function login_post() {

		// validate the session Key
		$loginId = $this->post ( "loginID" );

		$password = $this->post ( "password" );

		$user = $this->Auth_service->doLogin ( $loginId, $password );


		$response = new LoginResponse ( false );


		if($user == null || $user == false){

			$status = new ResponseStatus ( 1, "Invalid User ID or Passwrod" );

		}elseif ($user->user_type == 2 || $user->user_type == 3){

			$status = new ResponseStatus ( 0, "success" );

			/*	if($user->user_type == 2 ){

			$faculty =  $this->Faculty_Service->fetchFacultyById($user->user_id);
			$students = $this->Student_service->fetchAllStudentBySchoolId($faculty->school_id,1,100,false);

			}
			*/
			$response->user_id = $user->user_id;
			$response->user_type = $user->user_type;
			$response->email_id = $user->email_id;

		}else{
			$status = new ResponseStatus ( 2, "Error in login please contact administrator" );
		}


		$response->sessionKey = "12121299012";
		$response->status = $status;

		$this->response ( $response );

	}

	function fetchUser_post() {

		// validate the session Key
		$sessionKey = $this->post ( "sessionKey" );

		$details = $this->auth_service->fetchwithSessionKey ( $sessionKey );

		$userID = $details->user_id;

		$user = $this->auth_service->getUserWithID ( $userID );

		$response = new UserResponse ( false );

		if ($user != null) {

			$status = new ResponseStatus ( 0, "success" );

			$response->userName = $user->user_name;

			$response->userEmail = $user->email_id;

			$response->userMobile = $user->mobile_number;

			$response->userImage = $user->profile_image;

			$response->status = $status;
		}
		else {

			$response->status = new ResponseStatus ( 100, "Invalid Login/Password" );

			$this->response ( $response );

			return;
		}

		$this->response ( $response );

	}

	function forgotPassword_post() {

		// validate the session Key
		$email = $this->post ( "email_id" );

		$user = $this->auth_service->forgotPassword ( $email );

		$response = new LoginResponse ( false );

		if ($user != null) {
			$status = new ResponseStatus ( 0, "A Reset link has been set to your mail." );
		}
		else {
			$response->status = new ResponseStatus ( 100, "Invalid Email" );

			$this->response ( $response );

			return;
		}

		$response->sessionKey = SecurityUtil::getRandomString ( 20 );

		$response->userId = $user->user_id;

		$response->status = $status;

		$this->response ( $response );

	}

	function changeUserPassword_post() {

		$key = $this->post ( "sessionKey" );

		$oldPassword = $this->post ( "oldPassword" );

		$newPassword = $this->post ( "newPassword" );

		$user = $this->auth_service->fetchwithSessionKey ( $key );

		if ($user != null) {

			$checkPassword = $this->auth_service->checkPassword ( $user->user, $oldPassword );

			if ($checkPassword != null) {
				$user->user->password = $newPassword;
				$result = $this->auth_service->updateUserPassword ( $user->user );
			}
			else {
				$result = null;
			}
		}
		else {
			$result = null;
		}

		$response = new GenericResponse ( false );

		if ($result != null) {
			$status = new ResponseStatus ( 0, "successfully changed password" );
		}
		else {
			$status = new ResponseStatus ( 100, "Invalid Password" );
		}

		$response->status = $status;

		$this->response ( $response );

		return;

	}

	function changeUserDetails_post() {

		$key = $this->post ( "sessionKey" );

		$userName = $this->post ( "userName" );

		$userMobile = $this->post ( "mobileNumber" );

		$userImage = $this->post ( "userImage" );

		$user = $this->auth_service->fetchwithSessionKey ( $key );

		if ($user != null) {

			$user->user->user_name = $userName;

			$user->user->mobile_number = $userMobile;

			$user->user->profile_image = $userImage;

			$result = $this->auth_service->updateUser ( $user->user );
		}
		else {
			$result = null;
		}
		$response = new GenericResponse ( false );

		if ($result != null) {
			$status = new ResponseStatus ( 0, "successfully updated profile" );
		}
		else {
			$status = new ResponseStatus ( 100, "Sorry,Try later" );
		}

		$response->status = $status;

		$this->response ( $response );

		return;

	}
	
	function fectchDistrictsByStateId_post(){
		

		$stateID = $this->post ( "state_id" );
		
		$districts = $this->District_service->fetchDistrictForState($stateID);
		
		$response = new GenericResponse ( false );
		
		$response->districtList =  $districts;
		
		if ($districts != null) {
		
			$status = new ResponseStatus ( 0, "success" );
		}
		else {
		
			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}
		
		
		$response->status = $status;
		
		
		$this->response ( $response );
	}
	
	function fectchLocalitiesByDistrictID_post(){
		

		$districtID = $this->post ( "district_id" );
		
		$localityList = $this->Locality_service->fetchLocalityForDistrict($districtID);
		
		$response = new GenericResponse ( false );
		
		$response->localityList =  $localityList;
		
		if ($localityList != null) {
		
			$status = new ResponseStatus ( 0, "success" );
		}
		else {
		
			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}
		
		
		$response->status = $status;
		
		
		$this->response ( $response );
		
	}
	
	
	function updateUserDetails_post(){
	
	
		$userId = $this->post ( "user_id" );
		$userType= $this->post ( "user_type" );
		
		$user = null;
		
		if($userType == 2){
			
			$user = $this->Faculty_Service->fetchFacultyById($userId);
			
		}
		
		if($userType == 3){
				
			$user = $this->Student_Service->fetchStudentById($userId);
				
		}
		
		if($user != null){
			
			$user->mobile_number =   $this->post ( "mobile_number" );
			$user->alternate_number =   $this->post ( "alternate_number" );
			
			$user->address->address_1 =     $this->post ( "address_1" );
			$user->address->address_2 =     $this->post ( "address_2" );
			$user->address->address_3 =     $this->post ( "address_3" );
			$user->address->state_id =    $this->post ( "state" );;
			$user->address->district_id =    $this->post ( "district" );
			$user->address->locality_id =   $this->post ( "locality" );
			$user->address->pincode =    $this->post ( "pincode" );
			$user->address->locality_selector_type =null;
			
			if($userType == 2){
				$user->faculty_image =null;
				$result = $this->Faculty_Service->updateFaculty($user);
			}
			
			if($userType == 3){
				$result = $this->Student_Service->updateStudent($user);
			}
			
			$result  = $this->Address_service->addAddress($user->address,true);
			
		}
		
		
		
		$response = new GenericResponse ( false );
	
		$faculty = $this->Faculty_Service->fetchFacultyById($userId);
		
		$response->faculty =  $faculty;
		
		$response->stateList =  $this->State_service-> fetchState(1);
		
		if ($faculty != null) {
		
			$status = new ResponseStatus ( 0, "success" );
		}
		else {
		
			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}
		
		
		$response->status = $status;
		
		
		$this->response ( $response );
		
		
	
	}
	
	
	

}
