<?php

/**
 * @author Maganiva
 *
 */
class GenericResponse extends Entity {

	public $status;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}