<?php

/**
 * @author SIJIN L JOSE
 *
 */
require_once BASE_APPPATH . 'third_party/PHPExcel/PHPExcel.php';

require_once BASE_APPPATH . 'entities/Faculty_details.php';
require_once BASE_APPPATH . 'entities/authentication.php';
require_once BASE_APPPATH . 'entities/address.php';


class Faculty_Service extends Service {


	var $no = 'A';

	var $sex = 'B';

	var $faculty_name = 'C';

	var $email_id = 'F';

	var $date_of_birth = 'G';

	var $designation_id = 'E';

	var $faculty_type = 'D';

	var $mobile_number = 'H';

	var $alternate_number = 'I';

	var $address1 = 'J';

	var $address2 = 'K';

	var $address3 = 'L';

	var $pincode = 'M';

	function __construct() {

		parent::__construct ();


		$this->load->model ( 'Faculty_model' );

	}

	public function uploadFacultyDetails ( $fileName ) {

		$errorSrNo = array ();

		$inputFileType = PHPExcel_IOFactory::identify ( $fileName );
		$objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
		$objPHPExcel = $objReader->load ( $fileName );

		$rowIterator = $objPHPExcel->getActiveSheet ()
		->getRowIterator ();
		$array_data = array ();
		foreach ( $rowIterator as $row ) {
			$cellIterator = $row->getCellIterator ();
			$cellIterator->setIterateOnlyExistingCells ( false );
			$rowIndex = $row->getRowIndex ();
			$array_data [$rowIndex] = array ();

			foreach ( $cellIterator as $cell ) {
				$array_data [$rowIndex] [$cell->getColumn ()] = $cell->getCalculatedValue ();
			}
		}
		$i = 0;

		foreach ( $array_data as $eachRow ) {
			if ($i === 0) {
				++ $i;
				continue;
			}

			if ($eachRow [$this->no] === null || $eachRow [$this->no] === '') {
				continue;
			}

			$faculty = $this->setFacultyDetailsFromExcelForUpload ( $eachRow );



			if ($faculty === null) {
				array_push ( $errorSrNo, $eachRow ['A'] );
				continue;
			}

			// Set status as inactive
			$faculty->status = 2;

			$faculty->school_id = $_SESSION ['user_id'];

			$locality=$this->Locality_model->fetchLocalityNameAndIdByPincode($faculty->address->pincode);

			$faculty->address->locality_id=$locality->locality_id;

			$faculty->address->locality_selector_type= "0";

			$faculty->user_id =  $this->Auth_service->register($faculty->authDetails);

			$faculty->address_id =  $this->Address_service->addAddress($faculty->address);

			$result= $this->Faculty_model->registerFaculty ( $faculty );

			if ($result === null) {
				array_push ( $errorSrNo, $eachRow ['A'] );
			}else{

				$errorSrNo=null;
			}
		}
		return $errorSrNo;

	}

	private function setFacultyDetailsFromExcelForUpload($eachRow) {

		$faculty=new Faculty_details;

		if ($eachRow [$this->faculty_name] === null || $this->faculty_name === "") {
			return null;
		}
		if ($eachRow [$this->email_id] === null || $this->email_id === "") {
			return null;
		}
		if ($eachRow [$this->designation_id] === null || $this->designation_id === "") {
			return null;
		}
		if ($eachRow [$this->sex] === null || $this->sex === "") {
			return null;
		}
		if ($eachRow [$this->faculty_type] === null || $this->faculty_type === "") {
			return null;
		}

		if ($eachRow [$this->mobile_number] === null || $this->mobile_number === "") {
			return null;
		}
		if ($eachRow [$this->address1] === null || $this->address1 === "") {
			return null;
		}

		if ($eachRow [$this->address2] === null || $this->address2 === "") {
			return null;
		}
		if ($eachRow [$this->pincode] === null || $this->pincode === "") {
			return null;
		}


		$auth = new Authentication();

		$auth->email_id =trim ( $eachRow [$this->email_id] );
		$auth->user_type = 2;
		$faculty->authDetails =  $auth;

		$faculty->faculty_name = $eachRow [$this->faculty_name];
		$faculty->designation_id = $eachRow [$this->designation_id];
		$faculty->faculty_type = $eachRow [$this->faculty_type];
		$faculty->sex = $eachRow [$this->sex];
		$faculty->date_of_birth = $eachRow [$this->date_of_birth];
		$faculty->mobile_number = $eachRow [$this->mobile_number];
		$faculty->alternate_number = $eachRow [$this->alternate_number];



		$address = new Address();
		$address->address_1 =$eachRow [$this->address1];
		$address->address_2 =$eachRow [$this->address2];
		$address->address_3 =$eachRow [$this->address3];
		$address->pincode =  $eachRow [$this->pincode];
		$faculty->address =$address;

		return $faculty;

	}

	public function registerFaculty($faculty) {



		$path = "profile/";

		$facultyId= $this->Faculty_model->registerFaculty ( $faculty );

		if($facultyId != null){

			$directory =  RESOURCE_REALPATH . $path .$facultyId;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}
			copy ( $faculty->faculty_image, RESOURCE_REALPATH . $path .$facultyId ."/1.jpg" );

			return	$this->Faculty_model->fetchFacultyById($facultyId);
		}else{

			return $facultyId;
		}
	}
	public function updateFaculty($faculty) {

		$path = "profile/";

		$result= $this->Faculty_model->updateFaculty ( $faculty );

		if($result && $faculty->faculty_image != null){

			$directory =  RESOURCE_REALPATH . $path .$faculty->user_id;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}
			copy ( $faculty->faculty_image, RESOURCE_REALPATH . $path .$faculty->user_id ."/1.jpg" );

			return	$this->Faculty_model->fetchFacultyById($faculty->user_id);
		}else{

			return  $result;
		}


	}
	public function fetchAllFacultyBySchoolId($pageNo = 1, $noOfItems = 10,$schoolId,$status = null) {

		$offset = ($pageNo - 1) * $noOfItems;

		if ($pageNo <= 0 || $offset < 0) {

			return null;
		}


		return $this->Faculty_model->fetchAllFacultyBySchoolId($noOfItems,$offset,$schoolId,$status);



	}
	public function fetchAllFaculty() {

		return $this->Faculty_model->fetchAllFaculty();


	}
	public function fetchFacultyById($userId) {
		$faculty= $this->Faculty_model->fetchFacultyById($userId);
		$faculty->address =  $this->Address_model->fetchAddressWithId($faculty->address_id);

		$faculty->imageURL = $this->_setFacultyImage($faculty);

		return $faculty;
	}
	private function _setFacultyImage($faculty){
		$path = "profile/";
		$imageURL =  RESOURCE_REALPATH . $path .$faculty->user_id ."/1.jpg";
		return $imageURL;
	}
	public function searchfacultyByName($searchKey){
		return $this->Faculty_model->searchfacultyByName($searchKey);
	}



}
