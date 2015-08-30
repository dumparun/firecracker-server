<?php


class State_Model extends MY_Model {

	public $_table = 'state';

	public $primary_key = 'state_id';


	function __construct() {

		parent::__construct ();
	
	}


	public function fetchState($countryId) {

		return parent::get_many_by ( "country_id", $countryId );
	
	}


	public function fetchStateById($stateId) {

		return parent::get ( $stateId );
	
	}


	public function addState($stateName, $countryId) {

		$data = array (
				'state_name' => $stateName,
				"country_id" => $countryId 
		);
		
		return parent::insert ( $data );
	
	}

}
