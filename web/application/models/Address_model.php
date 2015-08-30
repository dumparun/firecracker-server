<?php


class Address_Model extends MY_Model {

	public $_table = 'address';

	public $primary_key = 'address_id';

	public $belongs_to = array (
			'locality' => array (
					'model' => 'locality_model',
					'primary_key' => 'locality_id' 
			),
			'district' => array (
					'model' => 'district_model',
					'primary_key' => 'district_id' 
			),
			'state' => array (
					'model' => 'state_model',
					'primary_key' => 'state_id' 
			) 
	);


	function __construct() {

		parent::__construct ();
	
	}


	public function addAddress($address) {

		$data = array (
				'address_1' => $address->address_1,
				'address_2' => $address->address_2,
				'address_3' => $address->address_3,
				'pincode' => $address->pincode,
				'locality_id' => $address->locality_id,
				'district_id' => $address->district_id,
				'state_id' => $address->state_id,
				'country_id' => $address->country_id,
		);
		
		return parent::insert ( $data, false );
	
	}


	public function updateAddress($address) {

		$data = array (
				'address_1' => $address->address_1,
				'address_2' => $address->address_2,
				'address_3' => $address->address_3,
				'pincode' => $address->pincode,
				'locality_id' => $address->locality_id,
				'district_id' => $address->district_id,
				'state_id' => $address->state_id,
				'country_id' => $address->country_id,
		);
		
		return parent::update ( $address->address_id, $data, false );
	
	}


	public function fetchAddressWithId($addressId) {

		return parent::with ( 'locality' )->with ( 'district' )->with ( 'state' )->get ( $addressId );
	
	}

}
