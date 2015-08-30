<?php


class District_Model extends MY_Model {

	public $_table = 'district';

	public $primary_key = 'district_id';

	public $belongs_to = array (
			'state' => array (
					'model' => 'state_model',
					'primary_key' => 'state_id'
			)
	);


	function __construct() {

		parent::__construct ();

	}


	public function fetchDistrictForState($stateId) {

		return parent::get_many_by ( "state_id", $stateId );

	}

	public function fetchDistrictById($districtId) {

		return parent::with('state')->get ( $districtId );

	}


	public function addDistrict($districtName, $stateId) {

		$data = array (
				'district_name' => $districtName,
				"state_id" => $stateId
		);

		return parent::insert ( $data );

	}

}
