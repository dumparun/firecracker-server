<?php
require_once APPPATH . 'entities/locality.php';
require_once APPPATH . 'entities/locality_search.php';


class Locality_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'Locality_model' );
		$this->load->model ( 'District_model' );

	}


	public function fetchLocalityForDistrict($districtId) {

		$types = $this->Locality_model->fetchLocalityForDistrict ( $districtId );

		$arrayOfTypes = null;
		foreach ( $types as &$value ) {
			$typez = new Locality ( $value );
			$arrayOfTypes [$typez->locality_id] = $typez;
		}
		return $arrayOfTypes;

	}


	public function fetchPinCodeForDistrict($districtId) {

		return $this->Locality_model->fetchPincodeForDistrict ( $districtId );

	}

	public function fetchPinCodeForState($stateId) {

		return $this->Locality_model->fetchPincodeForState ( $stateId );
	}

	public function fetchDistrictIdForLocality($localityId) {

		$val = $this->Locality_model->fetchLocalityById ( $localityId );
		return $val->district_id;

	}
	public function fetchDistrictForLocality($localityId) {
	
		return  $this->Locality_model->fetchLocalityById ( $localityId );
	
	}


	public function fetchLocationBasedOnPinAndLocality($searchkey) {

		$count = 0;
		$arrayOfLocality = null;

		if(is_numeric($searchkey)){
			$matches = $this->Locality_model->getLocalityBasedOnPinCode ( $searchkey );
			foreach ( $matches as &$values ) {
					
				$locality = new localitySearchEntity ();
				$locality->locality_id = $values->locality_id;
				$locality->locality_name = $values->locality_name;
				$locality->pincode = $values->pincode;
				$arrayOfLocality [$count ++] = $locality;
			}

		}else{
			$matches = $this->Locality_model->getLocalityBasedOnLocality ( $searchkey );

			foreach ( $matches as &$values ) {
					
				$locality = new localitySearchEntity ();
				$locality->locality_id = $values->locality_id;
				$locality->locality_name = $values->locality_name;
				$locality->pincode = $values->pincode;
				$arrayOfLocality [$count ++] = $locality;
			}
		}
		return $arrayOfLocality;
	}


	public function fetchLocalityBasedOnLOcalityId($localityId) {

		return $this->Locality_model->fetchLocalityById ( $localityId );

	}


	public function fetchLocalityNameBasedOnLOcalityId($localityId) {

		$val = $this->Locality_model->fetchLocalityById ( $localityId );
		return $val->locality_name;

	}

}