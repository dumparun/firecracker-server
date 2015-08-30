<?php
/**
 * @author SIJIN L JOSE
 *
 */

class Designation_Service extends Service {

	function __construct() {

		parent::__construct ();

		$this->load->model ( 'Designation_model' );
	}

	public function fetchAllDesignation(){

		return $this->Designation_model->fetchAllDesignation();

	}
}
