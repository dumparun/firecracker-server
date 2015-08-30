<?php

/**
 *
 * @author Maganiva
 *
 */


class Home extends Unsecured_View_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->service ( 'notification_service' );
		$this->load->service ( 'Auth_service' );
	}

	public function kinderGartenHome() {
		$schoolId=$_SESSION['user_id'];
		$type=0;
		$notificationCount=$this->notification_service->getNotificationCountByUserId($schoolId,$type);

		$this->view_data["notificationCount"] =$notificationCount;


		if($_SESSION["user_type"] == 0){

			$schoolCount =  $this->Auth_service->getCountOfSchool (true);
			$this->view_data["schoolCount"] =$schoolCount;
			$this->content_view = 'admin_home';
		}else{
			$this->content_view = 'home';
		}

	}





}
