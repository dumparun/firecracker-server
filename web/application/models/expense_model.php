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
				
				'expensedate' => $expense->expensedate,
				
				'description' => $expense->description,
				
				"category" => $expense->category,
				
				'paymenttype' => $expense->paymentType,
				
				'amount' => $expense->amount 
		);
		
		return parent::insert ( $data, false );
	
	}

	public function getDailyExpense($date) {

		return parent::get_many_by ( "expensedate", $date );
	
	}

	public function getMonthlyExpense($fromDate, $toDate) {

		$this->_database->select ( " * FROM `dailyexpense` WHERE `expensedate` <= \"" . $toDate . "\" AND `expensedate` >= \"" . $fromDate . "\" ORDER BY `expensedate` ASC ", false );
		
		return $this->_database->get ()
			->result ();
	
	}

	public function getExpenseOnCategory() {

		$this->_database->select ( " category, SUM(amount) amt FROM `dailyexpense` GROUP BY category" );
		
		return $this->_database->get ()
			->result ();
	
	}

}