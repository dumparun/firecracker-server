<?php

require_once APPPATH . 'entities/notifications.php';


class Notification_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'notification_model' );
		$this->load->model ( 'student_model' );
		$this->load->model ( 'faculty_model' );
		$this->load->model ( 'School_model' );

	}


	public function insertNewNotification($notifications) {

		return $this->notification_model->insertNewNotification($notifications);



	}
	public function updateNotificationStatus($receiver,$receiverIdList) {
		$list = explode(',', $receiverIdList);

		if($receiver==0){
			$this->student_model->updateNotificationStatus();
			return $this->faculty_model->updateNotificationStatus();
		}else if($receiver==1){
			return $this->faculty_model->updateNotificationStatus();
		}else if($receiver==2){
			return	$this->student_model->updateNotificationStatus();
		}else if($receiver==3){
			foreach ($list as $listItem)
				$this->faculty_model->updateNotificationStatus($listItem);
			return true;
		}else if($receiver==4){
			foreach ($list as $listItem)
				$this->student_model->updateNotificationStatus($listItem);
			return true;
		}



	}
	public function getNotificationCountByUserId($userId,$type){
		if($type==0){
			$count =$this->School_model->getNotificationCountByUserId($userId);
			if($count != null){
				return $count[0]->notification_count;
			}else {
				return $count;
			}
			
		}else if($type==1){
			$count = $this->faculty_model->getNotificationCountByUserId($userId);
			return $count[0]->notification_count;
		}else if($type==2){
			$count =$this->student_model->getNotificationCountByUserId($userId);
			return $count[0]->notification_count;
		}
	}
	public function getNotificationByUserId($userId,$type){
		$notificationDetails=new Notifications();
		if($type==0){
			$notificationDetails=$this->notification_model->getNotificationBySchoolId($userId);
		}else if($type==1){
			$notificationDetails=$this->notification_model->getNotificationByFacultyId($userId);
		}else if($type==2){
			$notificationDetails=$this->notification_model->getNotificationByStudentId($userId);
		}

		return $notificationDetails;
	}

	public function changeNotificationStatus($userId,$type){
		if($type==0){
			return $this->School_model->changeNotificationStatus($userId);
		}else if($type==1){
			return $this->faculty_model->changeNotificationStatus($userId);
		}else if($type==2){
			return $this->student_model->changeNotificationStatus($userId);
		}

	}
}