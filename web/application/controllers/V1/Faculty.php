<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/entities/generic_response.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/student_response.php';


class Faculty extends REST_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service("Auth_service");

		$this->load->service("Faculty_Service");
		
		$this->load->service("Student_service");

		$this->load->service("State_service");
		
		$this->load->service("District_service");
		
		$this->load->service("Locality_service");
		
	}
	
	function fetchFacultyById_post() {


		$userID = $this->post ( "user_id" );

		$faculty = $this->Faculty_Service->fetchFacultyById($userID);

		$response = new GenericResponse ( false );

		$response->stateList =  $this->State_service-> fetchState(1);
		
		$response->districtList =  $this->District_service->fetchDistrictForState($faculty->address->state_id);
		
		$response->localityList =   $this->Locality_service->fetchLocalityForDistrict($faculty->address->district_id);
		
		
		$response->faculty =  $faculty;

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

?>