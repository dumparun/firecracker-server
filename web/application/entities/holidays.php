<?php


/**
 * @author SIJIN L JOSE
 *
 */
class Holidays extends Entity {

	public $holiday_id;
	
	public $school_id;

	public $date;

	public $event;

	public $status;



	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}