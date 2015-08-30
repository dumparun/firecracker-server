<?php

require_once BASE_APPPATH . 'entities/address.php';


class Address_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'Address_model' );
		$this->load->model ( 'Locality_model' );
	}


	public function addAddress($address,$forUpdate = false) {

		if($address->locality_selector_type != null){

			if($address->locality_selector_type == 0){
				$localityDetails  =  $this->Locality_model->fetchLocalityById($address->locality_id);
				$address->district_id = $localityDetails->district_id;
				$address->state_id = $localityDetails->state_id;
				$address->country_id = 1;
			}

		}
		if($forUpdate == false){
			return $this->Address_model->addAddress ( $address );
		}else{
			return $this->Address_model->updateAddress ( $address );
		}


	}

}
