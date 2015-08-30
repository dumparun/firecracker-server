<?php

/**
 * @author Maganiva
 *
 */




class Facultydetails_Service extends Service {

	function __construct() {

		parent::__construct ();


		$this->load->model ( 'Facultydetails_model' );


	}



	public function fetchAllFacultyBySchoolId($schoolId) {
		return $this->Facultydetails_model->fetchAllFacultyBySchoolId($schoolId);
	}
}