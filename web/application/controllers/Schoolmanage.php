<?php

/**
 *
 * @author Sujith,Rahul
 *
 */


require_once BASE_APPPATH . 'entities/school.php';
require_once BASE_APPPATH . 'entities/authentication.php';
require_once BASE_APPPATH . 'entities/address.php';
require_once BASE_APPPATH . 'entities/schoolworkingdays.php';


require_once BASE_APPPATH . 'utilities/mail/email_template.php';
require_once BASE_APPPATH . 'utilities/mail/emailer.php';



class SchoolManage extends Secured_View_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Auth_service' );
		$this->load->service ( 'School_service' );
		$this->load->service ( 'notification_service' );
		$this->load->service ( 'State_service' );
		$this->load->service ( 'Address_service' );
		$this->load->service ( 'Faculty_service' );
		$this->load->service ( 'Student_service' );
		$this->load->service ( 'District_service' );
		$this->load->service ( 'Locality_service' );
	}



	public function schoolRegistration(){

		$school = null;
		$districtsInSelectedState = null;
		$localitiesInSelectedDistrict =  null;
		$workingDaysDetailsArray = null;
		if($_POST){
			if(isset($_POST['school_id'])){
				$schoolID = $this->input->post('school_id');
				$school =  $this->School_service->fetchSchoolByID($schoolID);


				if($school->working_days != null){

					$workingDaysDetailsArray = $this->_getWorkingDayDetails($school->working_days);

				}


				$districtsInSelectedState =  $this->District_service->fetchDistrictForState($school->address->state_id);

				$localitiesInSelectedDistrict =   $this->Locality_service->fetchLocalityForDistrict($school->address->district_id);

			}
		}
		$this->view_data["workingDaysDetailsArray"] =  $workingDaysDetailsArray;

		$this->view_data["districtsInSelectedState"] = $districtsInSelectedState;
		$this->view_data["localitiesInSelectedDistrict"] = $localitiesInSelectedDistrict;

		$this->view_data["school"] = $school;

		$states = 	$this->State_service-> fetchState(1);
		$this->view_data["states"] = $states;

		$this->content_view ='school_registration';
		$this->_setup_schoolregistration_validation();
	}



	private function _setup_schoolregistration_validation() {

		log_message ( 'info', 'Vendor Controller :: _setup_validation => _setup_validation is called' );


		$as_option = array (
				'rules' => array (
						'school_name' => array (
								'required' => true,
						),
						'address_1' => array (
								'required' => true
						),
						'address_2' => array (
								'required' => true
						),
						'locality' => array (
								'required' => true
						),
						'district' => array (
								'required' => true
						),
						'state' => array (
								'required' => true
						),
						'phone_number' => array (
								'required' => true,
								'digits' =>true
						),
						'mobile_number' => array (
								'required' => true,
								'digits' =>true,
								'minlength' =>10,
								'maxlength' =>10,
						),
						'chairman_principal_name' => array (
								'required' => true
						),
						'chairman_principal_number' => array (
								'required' => true,
								'digits' =>true,
								'minlength' =>10,
								'maxlength' =>10,
						),
						'email_address' => array (
								'required' => true,
								'email' => true
						),
						'working_days' => array (
								'required' => true
						),
						'school_image' => array (
								'required' => true
						),

				),
				'messages' => array (
						'school_name' => array (
								'required' => "Enter school name",
						),
						'address_1' => array (
								'required' => "Enter street address1"
						),
						'address_2' => array (
								'required' => "Enter street address2"
						),
						'locality' => array (
								'required' => "Locality"
						),
						'district' => array (
								'required' => "distict"
						),
						'state' => array (
								'required' => "Enter state"
						),
						'phone_number' => array (
								'required' => "Enter phone number",
								'digits' =>"Enter phone number",
								'minlength' => "Enter phone number",
								'maxlength' => "Enter phone number",
						),
						'mobile_number' => array (
								'required' => "Enter mobile number",
								'digits' => "Enter mobile number",
								'minlength' => "Enter mobile number",
								'maxlength' => "Enter mobile number",
						),
						'chairman_principal_name' => array (
								'required' => "Enter name"
						),
						'chairman_principal_number' => array (
								'required' => "Enter number",
								'digits' => "Enter mobile number",
								'minlength' => "Enter mobile number",
								'maxlength' => "Enter mobile number",

						),
						'email_address' => array (
								'required' => "Enter  email address",
								'email' => "Enter a valid email Address"
						),
						'working_days' => array (
								'required' => "Enter working days/time"
						),
						'school_image' => array (
								'required' => "Select image"
						),

				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->validator->set_rules ( $as_option );

	}


	public function registerSchool(){

		if(!isset($_POST['school_name'])){

			redirect('home/kinderGartenHome');
			return;
		}

		$school = new School();
		$school =  	$this->_setSchoolDetails($school,true);

		$valid_file = true;

		if ($_FILES ['school_image'] ['name']) {
			if (! $_FILES ['school_image'] ['error']) {
				$file_name = $_FILES ['school_image'] ['tmp_name'];

				if (exif_imagetype ( $file_name ) != IMAGETYPE_JPEG) {
					$message = 'This is either not a valid Image File or a JPG image';
					$valid_file = false;
				}

				if ($_FILES ['school_image'] ['size'] > (1024000)) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				// check for duplicate brand names
				if ($valid_file) {

					$userID =  $this->Auth_service->register($school->authDetails);
					$school->address_id =  $this->Address_service->addAddress($school->address);

					if($userID != null){
						$school->user_id =  $userID;
						$school->school_image = $file_name;
						$result  =  $this->School_service->registerSchool($school);
						if($result){
							$this->_sendRegisterationMailToSchool($result);
							$this->session->set_flashdata ( 'successMessage', "School Registered Successfully" );
							redirect("home/schoolRegistration");
						}
					}else{
						$message = "Email Id already registered" ;
					}
				}
			}
			// if there is an error...
			else {
				// set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['school_image'] ['error'] ;
			}
		}
		else {

			$message =  "Please upload a file to continue";

		}

		$this->session->set_flashdata ( 'errorMessage', $message);
		redirect("home/schoolRegistration");
	}



	public function updateSchool(){

		$schoolId =  $this->input->post('school_id');
		$school =  $this->School_service->fetchSchoolByID($schoolId);

		$school=  $this->_setSchoolDetails($school,false);

		$school->address->address_id =  $school->address_id;

		$school->school_image = null;

		$valid_file = true;

		if ($_FILES ['school_image'] ['name']) {
			if (! $_FILES ['school_image'] ['error']) {
				$file_name = $_FILES ['school_image'] ['tmp_name'];

				if (exif_imagetype ( $file_name ) != IMAGETYPE_JPEG) {
					$message = 'This is either not a valid Image File or a JPG image';
					$valid_file = false;
				}

				if ($_FILES ['school_image'] ['size'] > (1024000)) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				// check for duplicate brand names
				if ($valid_file) {
					$school->school_image = $file_name;
					$school->address_id =  $this->Address_service->addAddress($school->address,true);
					$result = $this->School_service->updateSchool($school);
					if($result){
						$this->session->set_flashdata ( 'successMessage', "School details successfully updated" );
						redirect("schoolmanage/viewAllSchools");
					}

				}
			}
			// if there is an error...
			else {
				// set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['school_image'] ['error'] ;
			}
		}
		else {

			$school->address_id =  $this->Address_service->addAddress($school->address,true);
			$result = $this->School_service->updateSchool($school);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "School details successfully updated" );
				redirect("schoolmanage/viewAllSchools");
			}
		}

		$this->session->set_flashdata ( 'errorMessage', $message);
		redirect("home/viewAllSchools");

	}



	private function _setSchoolDetails($school,$forRegister= false){

		$school->school_name =  $this->input->post('school_name');
		$school->school_type =  $this->input->post('school_type');
		$school->mobile_number =  $this->input->post('mobile_number');
		$school->phone_number =  $this->input->post('phone_number');
		$school->principal_name =  $this->input->post('chairman_principal_name');
		$school->principal_number =  $this->input->post('chairman_principal_number');

		$workingDays =  $this->input->post('working_days');

		$schoolWorkingDays =   new schoolWorkingDays();

		if($workingDays != null){

			$startingHrs =   sprintf("%02d",  $this->input->post('working_starting_hours'));
			$startingMins=  sprintf("%02d", $this->input->post('working_starting_minutes'));
			$endingHours =   sprintf("%02d",$this->input->post('working_ending_hours'));
			$endingMins  =  sprintf("%02d", $this->input->post('working_ending_minutes'));


			foreach ($workingDays as $days){
					
				$workingsDays =  $startingHrs.":".$startingMins." To ".$endingHours." : ".$endingMins;
				$day =  $this->_getDayFormNumber($days);
				$schoolWorkingDays->{$day} =  $workingsDays;
			}

		}



		$workingDaysSingle=  $this->input->post('working_days_single');

		if($workingDaysSingle != null){

			foreach ($workingDaysSingle as $workingDayzz){
					
				$startingHrs =   sprintf("%02d",  $this->input->post('working_starting_hours'.$workingDayzz));
				$startingMins=  sprintf("%02d", $this->input->post('working_starting_minutes'.$workingDayzz));
				$endingHours =   sprintf("%02d",$this->input->post('working_ending_hours'.$workingDayzz));
				$endingMins  =  sprintf("%02d", $this->input->post('working_ending_minutes'.$workingDayzz));
				$workingsDays =  $startingHrs.":".$startingMins." To ".$endingHours." : ".$endingMins;
					
				$day =  $this->_getDayFormNumber($workingDayzz);
					
				$schoolWorkingDays->{$day} =  $workingsDays;
					
			}

		}

		$school ->working_days =  $schoolWorkingDays;

		if($forRegister == true){
			$authDetails = new Authentication();
			$authDetails->email_id =  $this->input->post('email_address');
			$authDetails->user_type = 1;
			$school->authDetails =  $authDetails;

		}

		$address = new Address();
		$address->address_1 =    $this->input->post('address_1');
		$address->address_2 =    $this->input->post('address_2');
		$address->address_3 =    $this->input->post('address_3');
		$address->pincode =    $this->input->post('pincode');
		$address->locality_selector_type =  $this->input->post('for-locality-select');
		if($address->locality_selector_type == 1){

			$address->country_id =    $this->input->post('country');
			$address->state_id =    $this->input->post('state');
			$address->district_id =    $this->input->post('district');
			$address->locality_id =    $this->input->post('locality');
		}else{
			$address->locality_id =   $this->input->post('locality_id');
		}

		$school->address =$address;

		return $school;
	}

	private function _sendRegisterationMailToSchool($school) {
		$emailer = new Emailer ( "support@kindergarten.com", null, null, 'no-reply@kindergarten.com' );
		$template = new EmailTemplate ( BASE_APPPATH . 'customize/mails/registrationacknowledgement_mail.php' );
		$template->firstName = $school->school_name;
		$template->loginUrl = "http://localhost/kindergarten-server/auth/verifyemail?email=" . $school->authentication->email_id . "&code=" . $school->authentication->hash_code;
		$emailer->SetTemplate ( $template, "Welcome to KinderGarten - School Panel" ); // Email runs the compile
		$returnVal = $emailer->send ();
	}

	public function viewAllSchools(){

		$status = null;
		if(isset($_GET['schools'])) {
			$status = $this->input->get("schools");
		}

		$totalCountOfSchools =   $this->Auth_service->getCountOfSchool($status);
		$schoolList =  $this->School_service->fetchAllSchools(1,20,$status);
		$this->view_data["itemsInPage"] = 20;
		$this->view_data["pageNo"] = 1;
		$this->view_data["status"] = $status;
		$this->view_data["totalCountOfSchools"]= $totalCountOfSchools;
		$this->view_data["schoolList"]= $schoolList;
		$this->content_view  = "view_all_school";
	}

	public function viewSchool(){
		if(isset($_POST["school_id"])){
			$schoolID =  $this->input->post("school_id");
			$school =  $this->School_service->fetchSchoolByID($schoolID);
			if($school == null ){
				$this->session->set_flashdata ( 'errorMessage', "Something Wrong" );
				redirect("Home/kinderGartenHome");
			}
			$this->view_data["school"] = $school;
			$this->content_view = "view_school";

		}else{
			$this->session->set_flashdata ( 'errorMessage', "Something Wrong" );
			redirect("Home/kinderGartenHome");
		}
	}

	public function sendNotification() {

		$schoolId=$_SESSION['user_id'];
		$this->view_data["studentList"] = $this->Student_service->getStudentBySchoolId($schoolId);
		$this->view_data["facultyList"] = $this->Faculty_service->getFacultyBySchoolId($schoolId);
		$this->content_view = 'send_notification';
		$this->_setup_sendNotification_validation();

	}
	public function sendNotificationToContacts(){
		/*$receiver 0-all 1-all faculty 2-all student 3-selected faculty 4-selected students*/
		$notificationText=  $this->input->post('send-notifications');
		$receiverType=  $this->input->post('select-faculty-student');
		$receiverIdList="";
		if($receiverType==0){
			$receiveMode=0;
			$receiver=0;
		}else
		if($receiverType==1){
			$facultySelection=  $this->input->post('inlineRadioOptionFaculty');
			if($facultySelection==2){
				$receiveMode=3;
				$receiver=3;
				if(!empty($_POST['check_faculty_list'])) {
					foreach($_POST['check_faculty_list'] as $check) {
						$receiverIdList.=$check.",";
					}

				}
			}else{$receiveMode=1;
			$receiver=1;
			}
		}else if($receiverType==2){
			$studentSelection=  $this->input->post('inlineRadioOptionStudent');
			if($studentSelection==4){
				$receiveMode=3;
				$receiver=4;
				if(!empty($_POST['check_student_list'])) {
					foreach($_POST['check_student_list'] as $check) {
						$receiverIdList.=$check.",";
					}

				}
			}
			else{$receiveMode=2;
			$receiver=2;
			}
		}
		$receiverIdList=trim($receiverIdList, ",");
		$notifications= new notifications();
		$notifications->message=$notificationText;
		$notifications->sender_id=1;
		$notifications->receiver_type=$receiveMode;
		$notifications->receiver_id=$receiverIdList;
		$result=$this->notification_service->insertNewNotification($notifications);
		$result=$this->notification_service->updateNotificationStatus($receiver,$receiverIdList);


		if($result){

			$this->session->set_flashdata ( 'successMessage', "Notification send successfully" );
			redirect("schoolmanage/sendNotification");
		}
		else{
			$this->session->set_flashdata ( 'errorMessage', "Error Occur while sending" );

			redirect("schoolmanage/sendNotification");
		}

	}
	public function viewNotification(){
		/* $type 0-school,1-faculty 2-student*/
		$schoolId=$_SESSION['user_id'];
		$type=0;

		$notification=$this->notification_service->getNotificationByUserId($schoolId,$type);
		$notificationCount=$this->notification_service->getNotificationCountByUserId($schoolId,$type);

		$this->view_data["notificationCount"] =$notificationCount;
		$this->view_data["notifications"] =$notification;
		$result=$this->notification_service->changeNotificationStatus($schoolId,$type);
		$this->content_view = 'view_notification';
	}
	private function _setup_sendNotification_validation() {

		log_message ( 'info', 'Vendor Controller :: _setup_validation => _setup_validation is called' );


		$as_option = array (
				'rules' => array (
						'send-notifications' => array (
								'required' => true,
						)
				),
				'messages' => array (
						'send-notifications' => array (
								'required' => "Enter The Text",
						))
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->validator->set_rules ( $as_option );

	}

	public function deactivateSchool(){
		$userId =  $this->input->post("school_id");
		$result =  $this->Auth_service->changeUserStatus($userId,0);
		if($result){
			$this->session->set_flashdata ( 'successMessage', "School Deactivated successfully" );
		}else{
			$this->session->set_flashdata ( 'errorMessage', "Error in Deactivating  school" );
		}

		redirect("schoolmanage/viewAllSchools");
	}

	public function activateSchool(){
		$userId =  $this->input->post("school_id");
		$result =  $this->Auth_service->changeUserStatus($userId,1);
		if($result){
			$this->session->set_flashdata ( 'successMessage', "School activated successfully" );
		}else{
			$this->session->set_flashdata ( 'errorMessage', "Error in activating  school" );
		}

		redirect("schoolmanage/viewAllSchools");
	}


	private function _getWorkingDayDetails($working_days){

		$arrayOfTime = null;
		for ($i = 1;$i < 8;$i++){
			$monday =  null;
			$day =  	$this->_getDayFormNumber($i);

			if($working_days->{$day}  != null){
				$split =  explode("To",$working_days->{$day} );
				$splitStartingHours =   explode(":",$split[0]);
				$splitEndingHours =   explode(":",$split[1]);
				${
					$day}[0]=  	trim($splitStartingHours[0]);
					${
						$day}[1] =  	trim($splitStartingHours[1]);
						${
							$day}[2] = 	trim($splitEndingHours[0]);
							${
								$day}[3] =  	trim($splitEndingHours[1]);
			}else{
				${
					$day} = null;
			}

			$arrayOfTime[$i] = ${
				$day};

		}

		return $arrayOfTime;

	}

	private function _getDayFormNumber($day){

		switch ($day){

			case 1 :
				$day =  "monday";
				break;
			case 2 :
				$day =  "tuesday";
				break;
			case 3 :
				$day =  "wednesday";
				break;
			case 4 :
				$day =  "thursday";
				break;
			case 5 :
				$day =  "friday";
				break;
			case 6 :
				$day =  "saturday";
				break;

			case 7 :
				$day =  "sunday";
				break;
			default :
				$day =  "NA";
				break;
		}

		return $day;
	}
}
