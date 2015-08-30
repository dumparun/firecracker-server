<?php

/**
 *
 * @author SIJIN L JOSE
 *
 */

require_once BASE_APPPATH . 'entities/Student_details.php';
require_once BASE_APPPATH . 'entities/authentication.php';
require_once BASE_APPPATH . 'entities/address.php';

require_once BASE_APPPATH . 'utilities/mail/email_template.php';
require_once BASE_APPPATH . 'utilities/mail/emailer.php';

class Students extends Secured_View_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Auth_service' );
		$this->load->service ( 'Student_service' );
		$this->load->service ( 'State_service' );
		$this->load->service ( 'Address_service' );
		$this->load->service ( 'Designation_Service' );
		$this->load->service ( 'District_service' );
		$this->load->service ( 'Locality_service' );

	}
	public function addStudents() {

		$userId=$this->input->post('userId');
		$states = 	$this->State_service-> fetchState(1);
		$student=null;
		$districtsInSelectedState = null;
		$localitiesInSelectedDistrict =  null;

		if($userId!=null){

			$student = 	$this->Student_service-> fetchstudentById($userId);

			$districtsInSelectedState =  $this->District_service->fetchDistrictForState($student->address->state_id);

			$localitiesInSelectedDistrict =   $this->Locality_service->fetchLocalityForDistrict($student->address->district_id);
		}
		$this->view_data["districtsInSelectedState"] = $districtsInSelectedState;
		$this->view_data["localitiesInSelectedDistrict"] = $localitiesInSelectedDistrict;
		$this->view_data["students"] = $student;
		$this->view_data["states"] = $states;
		$this->_setup_student_validation();
		$this->content_view = 'student_registration';

	}

	public function registerStudent() {
		$student = new student_details();
		$student = $this->_setstudentDetailsDetails($student,true);
		$valid_file = true;

		if ($_FILES ['student_image'] ['name']) {
			if (! $_FILES ['student_image'] ['error']) {
				$file_name = $_FILES ['student_image'] ['tmp_name'];

				if (exif_imagetype ( $file_name ) != IMAGETYPE_JPEG) {
					$message = 'This is either not a valid Image File or a JPG image';
					$valid_file = false;
				}

				if ($_FILES ['student_image'] ['size'] > (1024000)) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				// check for duplicate brand names
				if ($valid_file) {

					$student->user_id =  $this->Auth_service->register($student->authDetails);

					$student->address_id =  $this->Address_service->addAddress($student->address);

					if(	$student->user_id != null){
						$student->student_image = $file_name;
						$result =  $this->Student_service->registerStudent($student);
						if($result){
							$this->_sendRegisterationMailToStudent($student->authDetails,$student->student_name);
							$this->session->set_flashdata ( 'successMessage', "Student Registered" );
							redirect("Students/addStudents");
						}
					}else{
						$message = "Email Id already registered" ;
					}
				}
			}
			// if there is an error...
			else {
				// set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['student_image'] ['error'] ;
			}
		}
		else {

			$message =  "Please upload a file to continue";

		}
		$this->session->set_flashdata ( 'errorMessage', "Email Id already registered" );

		redirect('Students/addStudents');
	}
	public function manageStudents() {

		$status = null;
		if(isset($_GET['studentStatus'])) {
			$status = $this->input->get("studentStatus");
		}
		$schoolId=$_SESSION['user_id'];
		$totalCountOfStudents =   $this->auth_service->getCountOfStudents($status);
		$students =  $this->Student_service->fetchAllStudentBySchoolId(1,20,$schoolId,$status);
		$this->view_data["itemsInPage"] = 20;
		$this->view_data["pageNo"] = 1;
		$this->view_data["status"] = $status;
		$this->view_data["totalCountOfStudents"]= $totalCountOfStudents;
		$this->view_data["students"]= $students;
		$this->content_view  = "manage_students";


	}
	public function mangeStudentStatus() {
		$userId =    $this->input->get('student_id');
		$status =    $this->input->get('status');

		if($status==1 || $status==2){

			$result= $this->Auth_service->changeUserStatus($userId,0);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "Student Deactivated successfully" );
			}else{
				$this->session->set_flashdata ( 'errorMessage', "Error in Deactivating  Student" );
			}

		}else{

			$result= $this->Auth_service->changeUserStatus($userId,1);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "Student Activated successfully" );
			}else{
				$this->session->set_flashdata ( 'errorMessage', "Error in Activating  Student" );
			}
		}


		redirect("Students/manageStudents");

	}


	public function updatestudent(){

		$studentId =  $this->input->post('student_id');
		$student =  $this->Student_service->fetchStudentById($studentId);
		$student=  $this->_setstudentDetailsDetails($student,false);

		$student->address->address_id =  $student->address_id;



		$student->student_image = null;

		$valid_file = true;

		if ($_FILES ['student_image'] ['name']) {
			if (! $_FILES ['student_image'] ['error']) {
				$file_name = $_FILES ['student_image'] ['tmp_name'];

				if (exif_imagetype ( $file_name ) != IMAGETYPE_JPEG) {
					$message = 'This is either not a valid Image File or a JPG image';
					$valid_file = false;
				}

				if ($_FILES ['student_image'] ['size'] > (1024000)) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				// check for duplicate brand names
				if ($valid_file) {
					$student->student_image = $file_name;
					$student->address_id =  $this->Address_service->addAddress($student->address,true);
					$result = $this->Student_service->updatestudent($student);
					if($result){
						$this->session->set_flashdata ( 'successMessage', "student details successfully updated" );
						redirect("student/managestudent");
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

			$student->address_id =  $this->Address_service->addAddress($student->address,true);
			$result = $this->student_service->updatestudent($student);
			if($result){
				$this->session->set_flashdata ( 'successMessage', "student details successfully updated" );
				redirect("student/managestudent");
			}
		}

		$this->session->set_flashdata ( 'errorMessage', $message);
		redirect("student/managestudent");

	}


	private function _setstudentDetailsDetails($student,$forRegister= false){

		$student->student_name =  $this->input->post('student_name');
		$student->fathers_name =  $this->input->post('fathers_name');
		$student->mothers_name =  $this->input->post('mothers_name');
		$student->fathers_occupation =  $this->input->post('fathers_occupation');
		$student->emergency_contact_number =  $this->input->post('emergency_contact_number');
		$student->remarks =  $this->input->post('remarks');
		$student->mobile_number =  $this->input->post('mobile_number');
		$student->alternate_number =  $this->input->post('alternate_contact_number');
		$student->date_of_birth =  $this->input->post('date_of_birth');
		$student->school_id =  $_SESSION["user_id"];
		$student->sex =  $this->input->post('gender');

		if($forRegister == true){
			$auth = new Authentication();

			$auth->email_id =  $this->input->post('email');
			$auth->user_type = 3;
			$student->authDetails =  $auth;

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
		$student->address =$address;

		return $student;
	}



	private function _sendRegisterationMailToStudent($auth,$studentName) {

		$emailer = new Emailer ( $auth->email_id, null, null, 'no-reply@kindergarten.com' );
		$template = new EmailTemplate ( BASE_APPPATH . 'customize/mails/registrationacknowledgement_mail_student.php' );
		$template->firstName = $studentName;
		$template->loginUrl = "http://localhost/kindergarten-server/auth/verifyemail?email=" . $auth->email_id . "&code=" . $auth->hash_code;
		$emailer->SetTemplate ( $template, "Welcome to KinderGarten - student Panel" ); // Email runs the compile
		$returnVal = $emailer->send ();
	}

	private function _setup_student_validation() {

		log_message ( 'info', 'Vendor Controller :: _setup_validation => _setup_validation is called' );


		$as_option = array (
				'rules' => array (
						'student_name' => array (
								'required' => true,
						),
						'fathers_name' => array (
								'required' => true,
						),
						'mothers_name' => array (
								'required' => true,
						),
						'fathers_occupation' => array (
								'required' => true,
						),
						'emergency_contact_number' => array (
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
						'student_name' => array (
								'required' => "Enter student name",
						),
						'fathers_name' => array (
								'required' => "Enter student name",
						),
						'mothers_name' => array (
								'required' => "Enter student name",
						),
						'fathers_occupation' => array (
								'required' => "Enter student name",
						),
						'emergency_contact_number' => array (
								'required' => "Enter emergency contact number",
								'digits' =>"Enter phone number",
								'minlength' => "Enter phone number",
								'maxlength' => "Enter phone number",
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
	public function viewStudent(){
		if(isset($_POST["student_id"])){
			$studentId =  $this->input->post("student_id");
			$student =  $this->Student_service->fetchStudentById($studentId);
			//	var_dump($student);die;
			if($student == null ){
				$this->session->set_flashdata ( 'errorMessage', "No Data Found" );
				redirect("Home/kinderGartenHome");
			}
			$this->view_data["student"] = $student;
			$this->content_view = "view_student";

		}else{
			$this->session->set_flashdata ( 'errorMessage', "No Data Found" );
			redirect("Home/kinderGartenHome");
		}
	}
	public function uploadStudentsDetailsExcel(){

		$this->content_view = 'student_upload';

	}
	public function excelUpload() {
		$valid_file = true;
		$message = null;
		$schoolId=$_SESSION['user_id'];

		if ($_FILES ['studentsfile'] ['name']) {
			// if no errors...
			if (! $_FILES ['studentsfile'] ['error']) {
				$file_name = $_FILES ['studentsfile'] ['tmp_name'];

				$finfo = new finfo ();
				$fileinfo = $finfo->file ( $file_name, FILEINFO_MIME );

				// Commented for Ubuntu
				/*
					* if (! stristr ( $fileinfo, "application/vnd.ms-excel" )) { $message = 'This is not a valid Excel file.'; $valid_file = false; }
				*/
				if ($_FILES ['studentsfile'] ['size'] > (1024000) && $valid_file == true) 				// can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}

				// if the file has passed the test
				if ($valid_file) {
					$returnSrNo = $this->Student_service->uploadStudentDetails ( $file_name, $schoolId );

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
				$message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES ['studentsfile'] ['error'];
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

}
