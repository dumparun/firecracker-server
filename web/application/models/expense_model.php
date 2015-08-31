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

	public function getDailyExpense($date) {

		return parent::get_many_by ( "date", $date );
	
	}

	public function getMonthlyExpense($fromDate, $toDate) {

		$this->_database->select ( " * FROM `notifications`,`auth` WHERE `auth`.`user_id`= `notifications`.`sender_id` AND  (`receiver_id` LIKE \"%" . $userId . "%\" OR `receiver_type`=4) ORDER BY `timestamp` DESC", false );
		
		return $this->_database->get ()
			->result ();
	
	}

}