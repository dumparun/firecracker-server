<?php

/**
 * @author SIJIN L JOSE
 *
 */

class Designation_Model extends MY_Model {

	public $_table = 'designation';

	public $primary_key = 'designation_id';


	function __construct() {

		parent::__construct ();

	}



	public function fetchAllDesignation() {

		return parent::get_all ();

	}
	public function fetchDesignationById($designationId) {

		return parent::get ($designationId);

	}


}
