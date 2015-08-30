<?php
require_once APPPATH . 'entities/district.php';


class District_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'District_model' );
	
	}


	public function fetchDistrictForState($stateId) {

		$types = $this->District_model->fetchDistrictForState ( $stateId );
		
		$arrayOfTypes = null;
		foreach ( $types as &$value ) {
			$typez = new District ( $value );
			$arrayOfTypes [$typez->district_id] = $typez;
		}
		return $arrayOfTypes;
	
	}


	public function fetchStateIdForDistrict($districtId) {

		$val = $this->District_model->fetchDistrictById ( $districtId );
		return $val->state_id;
	
	}


	public function fetchDistrictBasedOnDistrictId($DistrictId) {

		return $this->District_model->fetchDistrictById ( $DistrictId );
	
	}


	public function fetchDistrictNameBasedOnDistrictId($DistrictId) {

		$val = $this->District_model->fetchDistrictById ( $DistrictId );
		return $val->district_name;
	
	}
	
	public function fetchDistrictsInKerala($stateId = 12){
		
		return $this->District_model->getDistrictByStateId ( $stateId );
		
	}
	
	public function fetchDistrictWithDistrictName($districtName){
		return $this->District_model->fetchDistrictWithDistrictName ( $districtName );
	}

}