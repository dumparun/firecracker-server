<?php


class Locality extends Entity {

	public $locality_id;

	public $locality_name;
	
	public $district_id;

	public $pincode;
	
	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}


