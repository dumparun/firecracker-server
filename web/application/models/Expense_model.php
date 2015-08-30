<?php

/**
 * @author Arun
 *
 */
class Expense_Model extends MY_Model {

	public $_table = 'dailyexpense';

	public $primary_key = 'expense_seq_no';

	function __construct() {

		parent::__construct ();
	
	}

	public function submitDailyExpense($expense) {

		$data = array (
				
				'date' => $expense->date,
				
				'description' => $expense->description,
				
				"category" => $expense->category,
				
				'paymenttype' => $expense->paymentType,
				
				'amount' => $expense->amount 
		);
		
		return parent::insert ( $data, false );
	
	}

}