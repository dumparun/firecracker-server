<?php

/**
 *
 * @author Sijin L Jose
 *
 */


class StudentData extends Unsecured_Data_Controller {


	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Student_service' );

	}


	public function fetchMoreStudents() {

		$this->json = true;
		$pageNo =  $this->input->post("pageNo");
		$status =  $this->input->post("status");
		$schoolId=$_SESSION['user_id'];

		if($status == ""){
			$status = null;
		}
		$studentList =  $this->Student_service->fetchAllStudentBySchoolId($pageNo,20,$schoolId,$status);
		$this->view_data ['JSON'] = json_encode ( $studentList );

	}

	public function searchStudentByName(){

		$this->json = true;

		$searchKey =  $this->input->post("searchkey");

		$studentList =  $this->Student_service->searchStudentByName($searchKey);

		$this->view_data ['JSON'] = json_encode ( $studentList );
	}

}