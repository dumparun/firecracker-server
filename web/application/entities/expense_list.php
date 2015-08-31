<?php

/**
 * @author Arun
 *
 */
class ExpenseList extends Entity {

	public $status;

	public $listOfExpenses;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}