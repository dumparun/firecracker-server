<?php


class District extends Entity {

	public $district_id;

	public $district_name;
	
	public $state_id;


	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}


