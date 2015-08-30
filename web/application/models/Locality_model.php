<?php


class Locality_Model extends MY_Model {

	public $_table = 'locality';

	public $primary_key = 'locality_id';


	function __construct() {

		parent::__construct ();

	}


	public function fetchLocalityForDistrict($districtId) {

		return parent::get_many_by ( "district_id", $districtId );

	}


	public function fetchPincodeForDistrict($districtId) {

		$this->_database->select ( " DISTINCT(`pincode`) AS pincode FROM  `locality` WHERE  `district_id` = " . $districtId );
		return $this->_database->get ()->result ();

	}

	public function fetchPincodeForState($stateId) {

		$this->_database->select ( " DISTINCT(`pincode`) AS pincode FROM  `locality` WHERE  `state_id` = " . $stateId );
		return $this->_database->get ()->result ();

	}


	public function fetchLocalityById($localityId) {

		return parent::get ( $localityId );

	}


	public function addLocality($localityName, $districtId, $stateId, $pincode) {

		$data = array (
				'locality_name' => $localityName,
				"district_id" => $districtId,
				'state_id' => $stateId,
				"pincode" => $pincode
		);

		return parent::insert ( $data );

	}


	public function getLocalityBasedOnLocality($searchkey) {

		parent::limit(50,0);
		$result = parent::get_many_like ( 'locality_name', $searchkey );

		return $result;

	}


	public function getLocalityBasedOnPinCode($searchkey) {

		//parent::limit(50,0);

		
		$this->_database->select ( "*  FROM `locality` WHERE `pincode` LIKE '%". $searchkey."%' LIMIT 15;");
		return $this->_database->get ()->result ();
		
		/*
		$result = parent::get_many_by ( 'pincode', $searchkey );
	
		return $result;*/

	}

	public function getDistrictIDForPinCode($pinCode) {

		$this->_database->select ( "DISTINCT(`district_id`) AS districtid FROM `locality` WHERE `pincode` = ". $pinCode);
		return $this->_database->get ()->result ();

	}

	public function getStateIDForPinCode($pinCode) {
	
		$this->_database->select ( "DISTINCT(`state_id`) AS stateid FROM `locality` WHERE `pincode` = ". $pinCode);
		return $this->_database->get ()->result ();
	
	}
	public function  fetchLocalityNameAndIdByPincode($pinCode) {
		$key = array (
				"pincode"=> $pinCode
		);
		return parent::get_by ( $key );
		
	}
}