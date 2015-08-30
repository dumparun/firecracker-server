<?php

/**
 *
 * @author Sujith
 *
 */


class SchoolManageData extends Unsecured_Data_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service ( 'School_service' );
		$this->load->service ( 'notification_service' );

	}


	public function fetchMoreSchools() {

		$this->json = true;
		$pageNo =  $this->input->post("pageNo");
		$status =  $this->input->post("status");
		if($status == ""){
			$status = null;
		}
		$schoolList =  $this->School_service->fetchAllSchools($pageNo,20,$status);
		$this->view_data ['JSON'] = json_encode ( $schoolList );

	}

	public function changeNotificationStatus() {
		$this->json = true;
		$schoolId =  $this->input->post("schoolId");
		$result=$this->notification_service->changeNotificationStatus($schoolId);
		$this->view_data ['JSON'] = json_encode ( $result );

	}
	
	public function searchBySchoolName(){

		$this->json = true;
		
		$searchKey =  $this->input->post("searchkey");

		$schoolList =  $this->School_service->searchBySchoolName($searchKey);
		
		$this->view_data ['JSON'] = json_encode ( $schoolList );
	}

}