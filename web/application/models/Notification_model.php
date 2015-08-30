<?php


class Notification_Model extends MY_Model {

	public $_table = 'notifications';

	public $primary_key = 'notification_id';

	public $belongs_to = array (
			'auth' => array (
					'model' => 'auth_model',
					'primary_key' => 'user_id'
			),
			'school' => array (
					'model' => 'school_model',
					'primary_key' => 'user_id'
			),'faculty' => array (
					'model' => 'faculty_model',
					'primary_key' => 'user_id'
			),'students' => array (
					'model' => 'student_model',
					'primary_key' => 'user_id'
			),
	);


	function __construct() {

		parent::__construct ();

	}


	public function insertNewNotification($notifications){

		$data = array(
				'sender_id' => $notifications->sender_id,
				'message' => $notifications->message,
				'receiver_type' => $notifications->receiver_type,
				'receiver_id' => $notifications->receiver_id

		);

		return parent::insert ( $data, false );

	}

	public function getNotificationBySchoolId($userId){
		$this->_database->select ( " * FROM `notifications`,`auth` WHERE `auth`.`user_id`= `notifications`.`sender_id` AND  (`receiver_id` LIKE \"%" . $userId . "%\" OR `receiver_type`=4) ORDER BY `timestamp` DESC",false);

		return $this->_database->get ()->result ();


	}
	public function getNotificationByFacultyId($userId){
		$this->_database->select ( " * FROM `notifications` WHERE (`receiver_id` LIKE \"%" . $userId . "%\" OR `receiver_type`=0 OR `receiver_type`=1 ) ORDER BY `timestamp` DESC",false);

		return $this->_database->get ()->result ();


	}
	public function getNotificationByStudentId($userId){
		$this->_database->select ( " * FROM `notifications` WHERE (`receiver_id` LIKE \"%" . $userId . "%\" OR `receiver_type`=0 OR `receiver_type`=2) ORDER BY `timestamp` DESC",false);

		return $this->_database->get ()->result ();


	}

}