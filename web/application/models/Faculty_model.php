<?php

/**
 * @author SIJIN L JOSE,RAHUL
 *
 */
class Faculty_Model extends MY_Model {

	public $_table = 'faculty';

	public $primary_key = 'user_id';

	public  $belongs_to = array(

			'authentication' => array(
					'model' => 'Auth_model',
					'primary_key' => 'user_id'
			),
			'address' => array(
					'model' => 'Address_model',
					'primary_key' => 'address_id'
			),
			'designation' => array(
					'model' => 'Designation_Model',
					'primary_key' => 'designation_id'
			)
	);


	function __construct() {

		parent::__construct ();

	}

	public function registerFaculty($faculty){

		$data = array(

				'user_id' => $faculty->user_id,

				'school_id' =>$faculty->school_id,

				'faculty_type' => $faculty->faculty_type,

				"designation_id" => $faculty->designation_id,

				"faculty_name" => $faculty->faculty_name,

				'sex' =>$faculty->sex,

				'date_of_birth' =>$faculty->date_of_birth,

				"mobile_number" => $faculty->mobile_number,

				'alternate_number' =>$faculty->alternate_number,

				"address_id" => $faculty->address_id,

		);

		return parent::insert ( $data, false );

	}

	public function updateFaculty($faculty) {

		$data = array (

				'user_id' => $faculty->user_id,

				'school_id' =>$faculty->school_id,

				'faculty_type' => $faculty->faculty_type,

				"designation_id" => $faculty->designation_id,

				"faculty_name" => $faculty->faculty_name,

				'sex' =>$faculty->sex,

				'date_of_birth' =>$faculty->date_of_birth,

				"mobile_number" => $faculty->mobile_number,

				'alternate_number' =>$faculty->alternate_number,

				"address_id" => $faculty->address_id,

		);

		return parent::update ( $faculty->user_id, $data, false );

	}

	public function fetchAllFaculty(){

		return parent::with("authentication")->with("designation")->get_all ();
	}

	public function fetchFacultyById($userId){

		return parent::with("authentication")->with("designation")->get ($userId);
	}

	public function fetchAllFacultyBySchoolId($noOfItems = 0, $offset = 0,$schoolId, $status = null){

		parent::order_by("`faculty`.`faculty_name`");

		if ($noOfItems != 0 || $offset != 0) {
			parent::limit ( $noOfItems, $offset );
		}
		if($status === null){
			$this->_database->select ( "* from `faculty`,`auth`,`designation` where `faculty`.`user_id`= `auth`.`user_id` AND `faculty`.`designation_id`= `designation`.`designation_id` AND `faculty`.`school_id` = " . $schoolId ,false);
			return $this->_database->get ()->result ();


		}else{

			$this->_database->select ( "* from `faculty`,`auth`,`designation` where `faculty`.`user_id`= `auth`.`user_id`  AND `faculty`.`designation_id`= `designation`.`designation_id` AND  `faculty`.`school_id` = " . $schoolId . " AND `auth`.`status` =" .$status,false);
			return $this->_database->get ()->result ();
		}


	}
	public function updateNotificationStatus($facultyId=null){
		$schoolId=$_SESSION['user_id'];
		if($facultyId==null){
			$result=$this->_database->query ( "update `faculty` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 WHERE `school_id`=".$schoolId);

			return $result;

		}
		else{
			$result=$this->_database->query ( "update `faculty` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 WHERE `user_id`=".$facultyId);

			return $result;
		}


	}
	public function changeNotificationStatus($userId){

		$data = array(

				'notification_status' => 1,
				'notification_count' => 0
		);
		return parent::update ($userId, $data, false );
	}
	public function getNotificationCountByUserId($userId){
		$this->_database->select ( " `notification_count`  FROM `faculty` WHERE  `user_id`=".$userId);
		return $this->_database->get ()->result ();


	}
	public function searchFacultyByName($searchKey){

			
		$this->_database->select ( "`faculty`.`faculty_name`,`faculty`.`user_id`  FROM `faculty` WHERE `faculty_name` LIKE '%". $searchKey."%' LIMIT 15;");
		return $this->_database->get ()->result ();

	}

}
