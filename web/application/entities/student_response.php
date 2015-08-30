<?php

/**
 * @author Maganiva
 *
 */
class StudentResponse extends Entity {

	public $student;

	public $status;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}