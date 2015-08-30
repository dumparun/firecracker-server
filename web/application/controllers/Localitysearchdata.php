<?php

/**
 *
 * @author Sujith
 *
 */


class LocalitySearchData extends Unsecured_Data_Controller {


	function __construct() {

		parent::__construct ();
		
		$this->load->service ( 'State_service' );
		
		$this->load->service ( 'Locality_service' );
	
		$this->load->service ( 'District_service' );
	}


	public function getLocalityMatches() {

		$this->json = true;
		$searchkey = $this->input->post ( 'key' );
		$matches = $this->Locality_service->fetchLocationBasedOnPinAndLocality ( $searchkey );
		$this->view_data ['JSON'] = json_encode ( $matches );
	
	}
	
	public function getAllState(){
		$this->json = true;
		$countryID = $this->input->post ( 'countryId' );
		$states= $this->State_service->fetchAllStates (  );
		$this->view_data ['JSON'] = json_encode ( $states );
	}
	
	public function getDistrict(){
		$this->json = true;
		$stateId = $this->input->post ( "stateId" );
		$district = $this->District_service->fetchDistrictForState ( $stateId );
		$this->view_data ['JSON'] = json_encode ( $district );
	}
	
	public function getLocality(){
		$this->json = true;
		$districtId = $this->input->post ( "districtId" );
		$locality = $this->Locality_service->fetchLocalityForDistrict ( $districtId );
		$this->view_data ['JSON'] = json_encode ( $locality );
	}

}