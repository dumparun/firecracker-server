<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/entities/generic_response.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/student_response.php';


class Students extends REST_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service("Auth_service");

		$this->load->service("Faculty_Service");

		$this->load->service("Student_service");

	}

	function viewAllStudents_post(){


		$userID = $this->post ( "user_id" );
		$userType = $this->post ( "user_type" );
		if($userType == 2){
			$faculty =  $this->Faculty_Service->fetchFacultyById($userID);
			$students = $this->Student_service->fetchAllStudentBySchoolId(1,100,$faculty->school_id,1);
		}
		if($userType == 3){

		}

		$response = new StudentResponse ( false );

		$response->studentList =  $students;

		if ($students != null) {

			$status = new ResponseStatus ( 0, "success" );
		}
		else {

			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}


		$response->status = $status;

		$this->response ( $response );


	}

	function fectchStudentById_post() {


		$studentID = $this->post ( "user_id" );

		$student = $this->Student_service->fetchStudentById($studentID);

		$response = new StudentResponse ( false );

		$response->student =  $student;

		if ($student != null) {

			$status = new ResponseStatus ( 0, "success" );
		}
		else {

			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}


		$response->status = $status;


		$this->response ( $response );


	}
	
	function updateRemark_post() {
	
	
		$studentID = $this->post ( "student_id" );
	
		$student = $this->Student_service->fetchStudentById($studentID);
	
		$student->remarks =  $this->post ( "message" );
		$student->student_image = null;
		
		$result =  $this->Student_service->updateStudent($student); 
		
		$response = new StudentResponse ( false );
	
		$response->student =  $student;
	
		if ($student != null) {
	
			$status = new ResponseStatus ( 0, "success" );
		}
		else {
	
			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}
	
	
		$response->status = $status;
	
	
		$this->response ( $response );
	
	
	}
	


}

?>