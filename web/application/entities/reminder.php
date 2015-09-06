<?php

/**
 * @author Arun
 *
 */
class Reminder extends Entity {

	public $sequence;

	public $item;

	public $reminder;
	
	public $paid;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}