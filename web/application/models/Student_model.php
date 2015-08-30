<?php


/**
 * @author SIJIN L JOSE, RAHUL
 *
 */
class Student_Model extends MY_Model {

	public $_table = 'student';

	public $primary_key = 'user_id';
	public $belongs_to = array (

			'auth' => array (
					'model' => 'Auth_model',
					'primary_key' => 'user_id'
			));


	function __construct() {

		parent::__construct ();

	}

	public function registerStudent($student){

		$data = array(

				'user_id' => $student->user_id,

				"student_name" => $student->student_name,

				"fathers_name" => $student->fathers_name,

				"mothers_name" => $student->mothers_name,

				'guardians_name' =>$student->guardians_name,

				'sex' =>$student->sex,

				'date_of_birth' =>$student->date_of_birth,

				"school_id" => $student->school_id,

				"fathers_occupation" => $student->fathers_occupation,

				"remarks" => $student->remarks,

				"mobile_number" => $student->mobile_number,

				'alternate_number' =>$student->alternate_number,

				'emergency_contact_number' => $student->emergency_contact_number,

				"guardians_contact_number" => $student->guardians_contact_number,

				"address_id" => $student->address_id


		);

		return parent::insert ( $data, false );

	}

	public function updateStudent($student) {

		$data = array (

				'user_id' => $student->user_id,

				"student_name" => $student->student_name,

				"fathers_name" => $student->fathers_name,

				"mothers_name" => $student->mothers_name,

				'guardians_name' =>$student->guardians_name,

				'sex' =>$student->sex,

				'date_of_birth' =>$student->date_of_birth,

				"school_id" => $student->school_id,

				"fathers_occupation" => $student->fathers_occupation,

				"remarks" => $student->remarks,

				"mobile_number" => $student->mobile_number,

				'alternate_number' =>$student->alternate_number,

				'emergency_contact_number' => $student->emergency_contact_number,

				"guardians_contact_number" => $student->guardians_contact_number,

				"address_id" => $student->address_id


		);

		return parent::update ( $student->user_id, $data, false );

	}

	public function fetchAllStudents(){

		return parent::with("auth")->get_all ();
	}

	public function fetchStudentById($userId){

		return parent::with("auth")->get ($userId);
	}



	public function fetchAllStudentBySchoolId($noOfItems = 0, $offset = 0,$schoolId, $status = null){

		parent::order_by("`student`.`student_name`");

		if ($noOfItems != 0 || $offset != 0) {
			parent::limit ( $noOfItems, $offset );
		}
		if($status === null){
			$this->_database->select ( "* from `student` , `auth` where `student`.`user_id` = `auth`.`user_id` AND `student`.`school_id` = " . $schoolId ,false);
			return $this->_database->get ()->result ();


		}else{

			$this->_database->select ( "* from `student`,`auth` where `student`.`user_id`= `auth`.`user_id` AND  `student`.`school_id` = " . $schoolId . " AND `auth`.`status` =" .$status,false);
			return $this->_database->get ()->result ();
		}


	}
	public function updateNotificationStatus($studentId=null){
		$schoolId=$_SESSION['user_id'];

		if($studentId==null){
			$result=$this->_database->query ( "update `student` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 WHERE `school_id`=".$schoolId);

			return $result;

		}
		else{
			$result=$this->_database->query ( "update `student` SET `notification_count`= CASE WHEN `notification_status`= 0 THEN `notification_count`+1 WHEN `notification_status` != 0 THEN 1 END,`notification_status`= 0 WHERE `user_id`=".$studentId);

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
		$this->_database->select ( " `notification_count`  FROM `student` WHERE  `user_id`=".$userId);
		return $this->_database->get ()->result ();


	}
	public function searchStudentByName($searchKey){

			
		$this->_database->select ( "`student`.`student_name`,`student`.`user_id`  FROM `student` WHERE `student_name` LIKE '%". $searchKey."%' LIMIT 15;");
		return $this->_database->get ()->result ();

	}

}