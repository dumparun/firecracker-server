<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require APPPATH . '/entities/notifications.php';

require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/entities/generic_response.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/student_response.php';


class Notification extends REST_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service("Auth_service");

		$this->load->service("Notification_service");

	}

	function fetchNotifications_post() {


		$userID = $this->post ( "user_id" );
		$userType = $this->post ( "user_type" );
		$notifications=null;
		$notifications = $this->Notification_service->getNotificationByUserId($userID,$userType);
		if(!empty($notifications)){
			foreach ($notifications  as $notification){
				$sender =  $this->Auth_service->getUserWithID($notification->sender_id);
				$notification->sender = $sender->email_id;
			}
		}

		$response = new StudentResponse ( false );

		$response->notification =  $notifications;

		if ($notifications != null) {

			$status = new ResponseStatus ( 0, "success" );
		}
		else {

			$status  =  new ResponseStatus ( 1, "Sorry Error Occured" );
		}


		$response->status = $status;


		$this->response ( $response );


	}
	
	function sendNotification_post(){
		
		
		
		
		$notifications= new notifications();
		
		$notifications->sender_id = $this->post ( "senderId" );
		$notifications->message = $this->post ( "message" );
		$notifications->receiver_type = $this->post ( "receiverType" );
		$receiverList  = $this->post ( "receivers" );
		$notifications->receiver_id =   implode (", ", $receiverList); 
		$receiver = $notifications->receiver_type;
		$result=$this->Notification_service->insertNewNotification($notifications);
		$result = $this->Notification_service->updateNotificationStatus($receiver,$notifications->receiver_id);
		
		$response = new GenericResponse ( false );
		
		
		if ($result) {
		
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