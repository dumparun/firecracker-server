<?php


/**
 * @author Maganiva
 *
 */
class LocalitySearchEntity extends Entity {

	public $locality_id;

	public $locality_name;

	public $pincode;

	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}
