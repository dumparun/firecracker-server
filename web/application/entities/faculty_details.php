<?php


/**
 * @author SIJIN L JOSE
 *
 */
class Faculty_details extends Entity {

	public $faculty_id;

	public $school_id;

	public $faculty_type;

	public $faculty_name;

	public $designation_id;

	public $sex;

	public $date_of_birth;

	public $mobile_number;

	public $alternate_number;

	public $address_id;

	public $imageURL;


	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}