<?php

/**
 *
 * @author Sijin L Jose
 *
 */


class FacultyData extends Unsecured_Data_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Faculty_service' );

	}


	public function fetchMoreFaculties() {

		$this->json = true;
		$pageNo =  $this->input->post("pageNo");
		$status =  $this->input->post("status");
		$schoolId=$_SESSION['user_id'];
		if($status == ""){
			$status = null;
		}
		$facultyList =  $this->Faculty_service->fetchAllFacultyBySchoolId($pageNo,20,$schoolId,$status);
		$this->view_data ['JSON'] = json_encode ( $facultyList );

	}

	public function searchFacultyByName(){

		$this->json = true;

		$searchKey =  $this->input->post("searchkey");

		$facultyList =  $this->Faculty_service->searchFacultyByName($searchKey);

		$this->view_data ['JSON'] = json_encode ( $facultyList );
	}

}