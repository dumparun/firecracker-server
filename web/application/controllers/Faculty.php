<?php

/**
 *
 * @author SIJIN L JOSE
 *
 */

require_once BASE_APPPATH . 'entities/Faculty_details.php';
require_once BASE_APPPATH . 'entities/authentication.php';
require_once BASE_APPPATH . 'entities/address.php';

require_once BASE_APPPATH . 'utilities/mail/email_template.php';
require_once BASE_APPPATH . 'utilities/mail/emailer.php';

class Faculty extends Secured_View_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Auth_service' );
		$this->load->service ( 'Faculty_service' );
		$this->load->service ( 'State_service' );
		$this->load->service ( 'Address_service' );
		$this->load->service ( 'Designation_Service' );
		$this->load->service ( 'District_service' );
		$this->load->service ( 'Locality_service' );

	}

	public function addFaculty() {

		$userId=$this->input->get('userId');
		$states = 	$this->State_service-> fetchState(1);
		$designation = 	$this->Designation_Service-> fetchAllDesignation();
		$faculty=null;
		$districtsInSelectedState = null;
		$localitiesInSelectedDistrict =  null;

		if($userId!=null){

			$faculty = 	$this->Faculty_service-> fetchFacultyById($userId);

			$districtsInSelectedState =  $this->District_service->fetchDistrictForState($faculty->address->state_id);

			$localitiesInSelectedDistrict =   $this->Locality_service->fetchLocalityForDistrict($faculty->address->district_id);
		}
		$this->view_data["districtsInSelectedState"] = $districtsInSelectedState;
		$this->view_data["localitiesInSelectedDistrict"] = $localitiesInSelectedDistrict;
		$this->view_data["faculty"] = $faculty;
		$this->view_data["designation"] = $designation;
		$this->view_data["states"] = $states;
		$this->_setup_faculty_validation();
		$this->content_view = 'faculty_registration';

	}

	public function manageFaculty() {
		$status = null;
		if(isset($_GET['facultyStatus'])) {
			$status = $this->input->get("facultyStatus");
		}
		$schoolId=$_SESSION['user_id'];
		$totalCountOfFaculty =   $this->Auth_service->getCountOfFaculty($status);
		$faculty = 	$this->Faculty_service-> fetchAllFacultyBySchoolId(1,20,$schoolId,$status);
		$this->view_data["itemsInPage"] = 20;
		$this->view_data["pageNo"] = 1;
		$this->view_data["status"] = $status;
		$this->view_data["totalCountOfFaculty"]= $totalCountOfFaculty;
		$this->view_data['faculty']=$faculty;
		$this->content_view = 'manage_faculty';
	}
	public function deactivateFaculty() {

		$userId =    $this->input->post('userId');
		$result= $this->Auth_service->changeUserStatus($userId,"0");
	 if($result){
	 	$this->session->set_flashdata ( 'successMessage', "Faculty Deactivated successfully" );
	 }else{
	 	$this->session->set_flashdata ( 'errorMessage', "Error in Deactivating  school" );
	 }
	 redirect("Faculty/manageFaculty");

	}

	public function registerFaculty() {

		$faculty = new Faculty_details();
		$faculty = $this->_setFacultyDetailsDetails($faculty,true);
		$valid_file = true;

		if ($_FILES ['faculty_image'] ['name']) {
			if (! $_FILES ['faculty_image'] ['error']) {
				$file_name = $_FILES ['faculty_image'] ['tmp_name'];

				if (exif_imagetype ( $file_name ) != IMAGETYPE_JPEG) {
					$message = 'This is either not a valid Image File or a JPG image';
					$valid_file = false;
				}

				if ($_FILES ['faculty_image'] ['size'] > (1024000)) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				// check for duplicate brand names
				if ($valid_file) {
					$faculty->address_id =  $this->Address_service->addAddress($faculty->address);

					if(	$faculty->user_id != null){
						$faculty->faculty_image = $file_name;
						$result =  $this->Faculty_service->registerFaculty($faculty);
						if($result){
							$this->_sendRegisterationMailToFaculty($faculty->authDetails,$faculty->faculty_name);
							$this->session->set_flashdata ( 'successMessage', "Faculty Registered" );
							redirect("Faculty/addFaculty");
						}
					}else{
						$message = "Email Id already registered" ;
					}
				}
			}
			// if there is an error...
			else {
				// set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['faculty_image'] ['error'] ;
			}
		}
		else {

			$message =  "Please upload a file to continue";

		}
		$this->session->set_flashdata ( 'errorMessage', "Email Id already registered" );

		redirect("Faculty/addFaculty");
	}
	public function updateFaculty(){

		$facultyId =  $this->input->post('faculty_id');
		$faculty =  $this->Faculty_service->fetchFacultyById($facultyId);
		$faculty=  $this->_setFacultyDetailsDetails($faculty,false);

		$faculty->address->address_id =  $faculty->address_id;

		$faculty->address_id =  $this->Address_service->addAddress($faculty->address,true);
		$result = $this->Faculty_service->updateFaculty($faculty);
		if($result){
			$this->session->set_flashdata ( 'successMessage', "Faculty details successfully updated" );
			redirect("Faculty/manageFaculty");
		}
		else{
			$this->session->set_flashdata ( 'errorMessage', $message);
			redirect("Faculty/manageFaculty");
		}
	}


	private function _setFacultyDetailsDetails($faculty,$forRegister= false){

		$faculty->faculty_name =  $this->input->post('faculty_name');
		$faculty->designation_id =  $this->input->post('designation');
		$faculty->mobile_number =  $this->input->post('mobile_number');
		$faculty->faculty_type =  $this->input->post('faculty_type');
		$faculty->alternate_number =  $this->input->post('alternate_contact_number');
		$faculty->date_of_birth =  $this->input->post('date_of_birth');
		$faculty->school_id =  $_SESSION['user_id'];
		$faculty->sex =  $this->input->post('gender');

		if($forRegister == true){
			$auth = new Authentication();

			$auth->email_id =  $this->input->post('email');
			$auth->user_type = 2;
			$faculty->user_id =  $this->Auth_service->register($auth);
			$faculty->authDetails =  $auth;

		}

		$address = new Address();
		$address->address_1 = $this->input->post('address_1');
		$address->address_2 = $this->input->post('address_2');
		$address->address_3 = $this->input->post('address_3');
		$address->pincode =  $this->input->post('pincode');
		$address->locality_selector_type =  $this->input->post('for-locality-select');
		if($address->locality_selector_type == 1){

			$address->country_id =    $this->input->post('country');
			$address->state_id =    $this->input->post('state');
			$address->district_id =    $this->input->post('district');
			$address->locality_id =    $this->input->post('locality');
		}else{
			$address->locality_id =   $this->input->post('locality_id');
		}

		$faculty->address =$address;

		return $faculty;
	}



	private function _sendRegisterationMailToFaculty($auth,$facultyName) {


		$emailer = new Emailer ( $auth->email_id, null, null, 'no-reply@kindergarten.com' );
		$template = new EmailTemplate ( BASE_APPPATH . 'customize/mails/registrationacknowledgement_mail_faculty.php' );
		$template->firstName = $facultyName;
		$template->loginUrl = "http://localhost/kindergarten-server/auth/verifyemail?email=" . $auth->email_id . "&code=" . $auth->hash_code;
		$emailer->SetTemplate ( $template, "Welcome to KinderGarten" ); // Email runs the compile
		$returnVal = $emailer->send ();
	}

	private function _setup_faculty_validation() {

		log_message ( 'info', 'Vendor Controller :: _setup_validation => _setup_validation is called' );


		$as_option = array (
				'rules' => array (
						'faculty_name' => array (
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
						'pincode' => array (
								'required' => true,
								'digits' =>true
						),
						'alternate_number' => array (
								'required' => true,
								'digits' =>true
						),
						'mobile_number' => array (
								'required' => true,
								'digits' =>true,
								'minlength' =>10,
								'maxlength' =>10,
						),

						'email_id' => array (
								'required' => true,
								'email' => true

						),

				),
				'messages' => array (
						'faculty_name' => array (
								'required' => "Enter school name",
						),
						'address_1' => array (
								'required' => "Enter street address1"
						),
						'address_2' => array (
								'required' => "Enter street address1"
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
						'pincode' => array (
								'required' => "Enter pincode",
								'digits' => "Enter pincode",
								'minlength' => "Enter pincode",
								'maxlength' => "Enter pincode",
						),
						'alternate_number' => array (
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
						'email_id' => array (
								'required' => "Enter  email address",
								'email' => "Enter a valid email Address"
						),

				)
		);
		$this->view_data ['JS_VALIDATION'] = json_encode ( $as_option );
		$this->validator->set_rules ( $as_option );

	}
	public function mangeFacultyStatus() {
		$userId =    $this->input->post('userId');
		$status =    $this->input->post('status');
		if($status==1 || $status==2){

			$result= $this->Auth_service->changeUserStatus($userId,0);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "Faculty Deactivated successfully" );
			}else{
				$this->session->set_flashdata ( 'errorMessage', "Error in Deactivating  Faculty" );
			}

		}else{

			$result= $this->Auth_service->changeUserStatus($userId,1);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "Faculty Activated successfully" );
			}else{
				$this->session->set_flashdata ( 'errorMessage', "Error in Activating  Faculty" );
			}
		}


		redirect("Faculty/manageFaculty");

	}
	public function uploadFacultyDetailsExcel(){

		$this->content_view = 'faculty_upload';

	}
	public function excelUpload() {
		$valid_file = true;
		$message = null;
		$schoolId=$_SESSION['user_id'];

		if ($_FILES ['facultyfile'] ['name']) {
			// if no errors...
			if (! $_FILES ['facultyfile'] ['error']) {
				$file_name = $_FILES ['facultyfile'] ['tmp_name'];

				$finfo = new finfo ();
				$fileinfo = $finfo->file ( $file_name, FILEINFO_MIME );

				// Commented for Ubuntu
				/*
				 * if (! stristr ( $fileinfo, "application/vnd.ms-excel" )) { $message = 'This is not a valid Excel file.'; $valid_file = false; }
				*/
				if ($_FILES ['facultyfile'] ['size'] > (1024000) && $valid_file == true) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}

				// if the file has passed the test
				if ($valid_file) {
					$returnSrNo = $this->Faculty_service->uploadFacultyDetails ( $file_name, $schoolId );

					if (! empty ( $returnSrNo )) {
						$message = "Some of the data has not been uploaded,please check if the uploaded email does not repeats. please verify to proceed.be Cell numbers are " . implode ( ',', $returnSrNo );
					}else{

						$message="Excel uploaded succesfully";
					}
				}
			}

			// if there is an error...
			else {
				// set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['facultyfile'] ['error'];
			}
		} else {
			$message = "Please upload a file to continue";
		}

		if ($message != null) {
			$this->errorMessage = $message;
			return;
		}
		return;
	}
	public function viewFaculty(){
		if(isset($_POST["userId"])){
			$facultyId =  $this->input->post("userId");
			$faculty = 	$this->Faculty_service-> fetchFacultyById($facultyId);
			if($faculty == null ){
				$this->session->set_flashdata ( 'errorMessage', "No Data Found" );
				redirect("Faculty/manageFaculty");
			}
			$this->view_data["faculty"] = $faculty;
			$this->content_view = "view_faculty";

		}else{
			$this->session->set_flashdata ( 'errorMessage', "No Data Found" );

			redirect("Faculty/manageFaculty");
		}
	}

}



