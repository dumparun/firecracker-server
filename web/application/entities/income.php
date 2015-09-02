<?php

/**
 * @author Arun
 *
 */
class IncomeEntity extends Entity {

	public $status;
	
	public $sequence;

	public $salary;

	public $otherofficeincome;

	public $others;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}