<?php


/**
 * @author SIJIN L JOSE
 *
 */
class Student_details extends Entity {

	public $user_id;

	public $school_id;

	public $student_name;

	public $fathers_name;

	public $mothers_name;

	public $fathers_occupation;

	public $guardians_name;

	public $guardians_contact_number;

	public $emergency_contact_number;

	public $sex;

	public $date_of_birth;

	public $age;

	public $mobile_number;

	public $alternate_number;

	public $imageURL;

	public $address_id;

	public $remarks;


	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}