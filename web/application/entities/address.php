<?php


/**
 * @author SUJITH
 *
 */


class Address extends Entity {

	public $address_id;

	public $address_1;

	public $address_2;

	public $address_3;

	public $locality_id;

	public $pincode;
	
	public $district_id;

	public $state_id;

	public $country_id;



	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}