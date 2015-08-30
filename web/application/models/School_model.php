<?php


/**
 * @author Sujith
 *
 */
class School_Model extends MY_Model {

	public $_table = 'school';

	public $primary_key = 'user_id';

	public  $belongs_to = array(
			'authentication' => array(
					'model' => 'Auth_model',
					'primary_key' => 'user_id'
			),
			'address' => array(
					'model' => 'Address_model',
					'primary_key' => 'address_id'
			)
	);

	function __construct() {

		parent::__construct ();

	}

	public function registerSchool($school){

		$data = array(

				'user_id' => $school->user_id,

				'school_name' => $school->school_name,

				'school_type' => $school->school_type,

				'address_id' => $school->address_id,

				'mobile_number' => $school->mobile_number,

				'phone_number' =>$school->phone_number,

				'principal_name' =>$school->principal_name,

				"principal_number" => $school->principal_number,

		);

		return parent::insert ( $data, false );

	}

	public function updateSchool($school){

		$data = array(

				'user_id' => $school->user_id,

				'school_name' => $school->school_name,

				'school_type' => $school->school_type,

				'address_id' => $school->address_id,

				'mobile_number' => $school->mobile_number,

				'phone_number' =>$school->phone_number,

				'principal_name' =>$school->principal_name,

				"principal_number" => $school->principal_number,

		);

		return parent::update ($school->user_id, $data, false );

	}


	public function fetchAllSchools($noOfItems = 0, $offset = 0, $status = null){

		parent::order_by("`school`.`school_name`");

		if ($noOfItems != 0 || $offset != 0) {
			parent::limit ( $noOfItems, $offset );
		}

		if($status === null){

			return parent::with("authentication")->get_all ();
		}else{
			$this->_database->select ( "* from `school`,`auth` where `school`.`user_id`= `auth`.`user_id` AND `auth`.`status` =" .$status,false);
			return $this->_database->get ()->result ();
		}


	}


	public function fetchSchoolByID($userID){
		return parent::with("authentication")->get ($userID);
	}
	public function updateNotificationStatus($schoolId=null){

		if($schoolId==null){
			$result=$this->_database->query ( "update `school` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 ");

			return $result;

		}
		else{
			$result=$this->_database->query ( "update `school` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 WHERE `user_id`=".$schoolId);

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
		$this->_database->select ( " `notification_count`  FROM `school` WHERE  `user_id`=".$userId,false);
		return $this->_database->get ()->result ();


	}

	public function searchBySchoolName($searchKey){

			
		$this->_database->select ( "`school`.`school_name`,`school`.`user_id`  FROM `school` WHERE `school_name` LIKE '%". $searchKey."%' LIMIT 15;");
		return $this->_database->get ()->result ();

	}


}