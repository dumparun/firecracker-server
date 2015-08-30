<?php

/**
 * @author SIJIN L JOSE ,RAHUL
 *
 */

require_once BASE_APPPATH . 'third_party/PHPExcel/PHPExcel.php';

require_once BASE_APPPATH . 'entities/Student_details.php';
require_once BASE_APPPATH . 'entities/authentication.php';
require_once BASE_APPPATH . 'entities/address.php';


class Student_Service extends Service {


	var $no = 'A';

	var $student_name = 'C';

	var $email_id = 'D';

	var $sex = 'B';

	var $date_of_birth = 'E';

	var $fathers_name = 'F';

	var $mothers_name = 'G';

	var $fathers_occupation = 'H';

	var $mobile_number = 'I';

	var $alternate_number = 'J';

	var $emergency_contact_number = "K";

	var $guardians_name = 'L';

	var $guardians_contact_number = 'M';

	var $address1 = 'N';

	var $address2 = 'O';

	var $address3 = 'P';

	var $pincode = 'Q';

	var $remarks = 'R';



	function __construct() {

		parent::__construct ();


		$this->load->model ( 'Student_model' );

		$this->load->model ( 'Locality_model' );

		$this->load->model ( 'Address_model' );


	}

	public function uploadStudentDetails ( $fileName ) {

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

			$student = $this->setStudentDetailsFromExcelForUpload ( $eachRow );



			if ($student === null) {
				array_push ( $errorSrNo, $eachRow ['A'] );
				continue;
			}

			// Set status as inactive
			$student->status = 2;

			$student->school_id = $_SESSION ['user_id'];

			$locality=$this->Locality_model->fetchLocalityNameAndIdByPincode($student->address->pincode);

			$student->address->locality_id=$locality->locality_id;

			$student->address->locality_selector_type= "0";

			$student->user_id =  $this->Auth_service->register($student->authDetails);

			$student->address_id =  $this->Address_service->addAddress($student->address);

			$result = $this->Student_model->registerStudent ( $student );
			if ($result === null) {
				array_push ( $errorSrNo, $eachRow ['A'] );
			}else{

				$errorSrNo=null;
			}
		}
		return $errorSrNo;

	}

	private function setStudentDetailsFromExcelForUpload($eachRow) {

		$student=new student_details;

		if ($eachRow [$this->student_name] === null || $this->student_name === "") {
			return null;
		}
		if ($eachRow [$this->email_id] === null || $this->email_id === "") {
			return null;
		}
		if ($eachRow [$this->sex] === null || $this->sex === "") {
			return null;
		}
		if ($eachRow [$this->date_of_birth] === null || $this->date_of_birth === "") {
			return null;
		}
		if ($eachRow [$this->fathers_name] === null || $this->fathers_name === "") {
			return null;
		}
		if ($eachRow [$this->mothers_name] === null || $this->mothers_name === "") {
			return null;
		}
		if ($eachRow [$this->fathers_occupation] === null || $this->fathers_occupation === "") {
			return null;
		}
		if ($eachRow [$this->mobile_number] === null || $this->mobile_number === "") {
			return null;
		}

		if ($eachRow [$this->emergency_contact_number] === null || $this->emergency_contact_number === "") {
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
		$auth->user_type = 3;
		$student->authDetails =  $auth;

		$student->student_name = $eachRow [$this->student_name];
		$student->fathers_name = $eachRow [$this->fathers_name];
		$student->mothers_name = $eachRow [$this->mothers_name];
		$student->fathers_occupation = $eachRow [$this->fathers_occupation];
		$student->guardians_name = $eachRow [$this->guardians_name];
		$student->guardians_contact_number = $eachRow [$this->guardians_contact_number];
		$student->emergency_contact_number = $eachRow [$this->emergency_contact_number];
		$student->sex = $eachRow [$this->sex];
		$student->date_of_birth = $eachRow [$this->date_of_birth];
		$student->mobile_number = $eachRow [$this->mobile_number];
		$student->alternate_number = $eachRow [$this->alternate_number];
		$student->remarks = $eachRow [$this->remarks];



		$address = new Address();
		$address->address_1 =$eachRow [$this->address1];
		$address->address_2 =$eachRow [$this->address2];
		$address->address_3 =$eachRow [$this->address3];
		$address->pincode =  $eachRow [$this->pincode];
		$student->address =$address;


		return $student;

	}


	public function registerStudent($student) {


		$path = "profile/";

		$this->Student_model->registerStudent ( $student );
		$studentID=$student->user_id;


		if($studentID != null){

			$directory =  RESOURCE_REALPATH . $path .$studentID;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}


			copy ( $student->student_image, RESOURCE_REALPATH . $path .$studentID ."/1.jpg" );

			return	$this->Student_model->fetchStudentById($studentID);
		}else{

			return $studentID;
		}
	}
	public function updateStudent($student) {

		$path = "profile/";

		$result= $this->Student_model->updateStudent ( $student );

		if($result && $student->student_image != null){

			$directory =  RESOURCE_REALPATH . $path .$student->user_id;

			if (!is_dir($directory)) {
					
				mkdir (  $directory ,0755,true );
					
			}
			copy ( $student->student_image, RESOURCE_REALPATH . $path .$student->user_id ."/1.jpg" );

			return	$this->Student_model->fetchSchoolByID($student->user_id);
		}else{

			return  $result;
		}


	}
	public function fetchAllStudents( $pageNo = 1, $noOfItems = 10,$onlyCount = false,$status = 1){

		$offset = ($pageNo - 1) * $noOfItems;

		if ($pageNo <= 0 || $offset < 0) {

			return null;
		}
		$result =  $this->Student_model->fetchAllStudents($noOfItems,$offset,$onlyCount,$status);

		if($onlyCount == false){
			$path = "profile/";
			foreach ($result as $school){

				$school->imageURL = $this->_setStudentmage($school);
			}

		}
		return $result;
	}
	public function fetchAllStudentBySchoolId( $pageNo = 1, $noOfItems = 10,$schoolId,$status = null){

		$offset = ($pageNo - 1) * $noOfItems;

		$path = "profile/";

		if ($pageNo <= 0 || $offset < 0) {

			return null;
		}

		$result=   $this->Student_model->fetchAllStudentBySchoolId($noOfItems,$offset,$schoolId,$status);

		foreach ($result as $students){

			$students->imageURL = $this->_setStudentmage($students);

		}
		return $result;
	}
	private function _setStudentmage($students){
		$path = "profile/";
		$imageURL =  RESOURCE_REALPATH . $path .$students->user_id ."/1.jpg";
		return $imageURL;
	}
	public function fetchStudentById($userId){

		$student= $this->Student_model->fetchStudentById($userId);
		$student->address =  $this->Address_model->fetchAddressWithId($student->address_id);
		$student->imageURL = $this->_setStudentmage($student);
		return $student;
	}


	public function getStudentBySchoolId($schoolId) {

		return $this->Student_model->fetchAllStudentBySchoolId($schoolId);

	}

	public function searchStudentByName($searchKey){
		return $this->Student_model->searchStudentByName($searchKey);
	}




}
