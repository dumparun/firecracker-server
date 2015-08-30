<?php

/**
 * @author Sujith
 *
 */

require_once BASE_APPPATH . 'entities/school.php';
require_once BASE_APPPATH . 'entities/authentication.php';

class School_Service extends Service {

	function __construct() {

		parent::__construct ();


		$this->load->model ( 'School_model' );
		$this->load->model ( 'Address_model' );
		$this->load->model ( 'Schoolworkingdays_model' );
		$this->load->model ( 'Auth_model' );
	}



	public function registerSchool($school) {

		$path = "profile/";

		$school->working_days->user_id =  $school->user_id;

		$this->Schoolworkingdays_model->insertWorkingDaysOfSchool($school->working_days);

		$schoolID=   $this->School_model->registerSchool($school);


		if($schoolID != null){

			$directory =  RESOURCE_REALPATH . $path .$schoolID;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}


			copy ( $school->school_image, RESOURCE_REALPATH . $path .$schoolID ."/1.jpg" );

			return	$this->School_model->fetchSchoolByID($schoolID);
		}else{

			return $schoolID;
		}

	}

	public function updateSchool($school) {

		$path = "profile/";

		$school->working_days->user_id =  $school->user_id;

		$workingDays = $this->Schoolworkingdays_model->getWorkingDaysWithUserID( $school->user_id);

		if($workingDays != null){
			$this->Schoolworkingdays_model->updateWorkingDaysOfSchool($school->working_days);
		}else{
			$this->Schoolworkingdays_model->insertWorkingDaysOfSchool($school->working_days);
		}


		$result=  $this->School_model->updateSchool($school);

		if($result && $school->school_image != null){

			$directory =  RESOURCE_REALPATH . $path .$school->user_id;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}
			copy ( $school->school_image, RESOURCE_REALPATH . $path .$school->user_id ."/1.jpg" );

			return	$this->School_model->fetchSchoolByID($school->user_id);
		}else{

			return  $result;
		}

	}


	public function fetchAllSchools( $pageNo = 1, $noOfItems = 10,$status = null){


		$offset = ($pageNo - 1) * $noOfItems;

		if ($pageNo <= 0 || $offset < 0) {

			return null;
		}


		$result =  $this->School_model->fetchAllSchools($noOfItems,$offset,$status);

		$fieldDetails = null;
		if($status != null){
			$fieldDetails = $this->Auth_model->fetchFieldDetails();
		}


		$path = "profile/";

		foreach ($result as $school){

			if($fieldDetails != null){
				$school->authentication =  new Authentication();
				foreach ($fieldDetails as $key => $fields){
					$school->authentication->{$fields}= $school->{$fields};
					if($key != 0){
						unset($school->{$fields});
					}
				}
			}

			$school->statusText =  $this-> _getCorrespondingTextForSchoolStatus($school->authentication->status);
			$school->imageURL = $this->_setSchoolImage($school);

		}


		return $result;
	}

	public function fetchSchoolByID($userID){


		$school =  $this->School_model->fetchSchoolByID($userID);
		$school->address =  $this->Address_model->fetchAddressWithId($school->address_id);
		$school->statusText =  $this-> _getCorrespondingTextForSchoolStatus($school->authentication->status);
		$school->imageURL = $this->_setSchoolImage($school);
		$school->working_days = $this->Schoolworkingdays_model->getWorkingDaysWithUserID($school->user_id);
		return $school;
	}

	private function _setSchoolImage($school){
		$path = "profile/";
		$imageURL =  RESOURCE_REALPATH . $path .$school->user_id ."/1.jpg";
		return $imageURL;
	}


	private function _getCorrespondingTextForSchoolStatus($status){

		if ($status == 0){
			$statusText = "Inactive";
		}

		if ($status == 1){
			$statusText = "Active";
		}

		if ($status == 2){
			$statusText = "New";
		}

		if ($status == 3){
			$statusText = "Password Reset";
		}

		return $statusText;
	}


	public function searchBySchoolName($searchKey){
		return $this->School_model->searchBySchoolName($searchKey);
	}


}
