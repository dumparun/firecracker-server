<?php

/**
 * @author Arun
 *
 */
class ExpenseEntity extends Entity {

	public $expense_seq_no;

	public $expensedate;

	public $description;

	public $category;

	public $paymentType;

	public $amount;

	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}