<?php


/**
 * @author SUJITH
 *
 */
class School extends Entity {

	public $user_id;

	public $school_name;

	public $school_type;

	public $address_id;

	public $phone_number;

	public $mobile_number;

	public $principal_name;

	public $principal_number;

	public $working_days;

	public $school_image;


	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}