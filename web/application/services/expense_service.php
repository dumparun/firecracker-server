<?php

/**
 * @author Arun
 *
 */

require APPPATH . '/entities/expense.php';

class Expense_Service extends Service {

	function __construct() {

		parent::__construct ();
		
		$this->load->model ( 'expense_model' );
	
	}

	public function submitDailyExpense($date, $description, $category, $paymentType, $amount) {

		$allCategory = array (
				'1' => 'Credit Cards',
				'2' => 'Loans/Debts Paid Back',
				'3' => 'Food at Hotels',
				'4' => 'Grocery & Home Stuffs',
				'5' => 'Home Routine Expense',
				'6' => 'LIC/Investement',
				'7' => 'Educational Expense',
				'8' => 'Medical Expense',
				'9' => 'Others',
				'10' => 'Gas',
				'11' => 'Snacks',
				'12' => 'Leisure & Shopping',
				'13' => 'Vehicle Expenses',
				'14' => 'Business Initiative',
				'15' => 'Giving Back',
				'16' => 'Travelling Expense' 
		);
		
		$allPaymentType = array (
				'1' => 'CASH',
				'2' => 'Amex',
				'3' => 'BOA',
				'4' => 'CITI',
				'5' => 'US Bank',
				'6' => 'CapitalOne' 
		);
		
		$expense = new ExpenseEntity ();
		$expense->date = $date;
		$expense->description = $description;
		$expense->category = array_search ( $category, $allCategory );
		$expense->paymentType = array_search ( $paymentType, $allPaymentType );
		$expense->amount = $amount;
		$status = $this->expense_model->submitDailyExpense ( $expense );
		
		return $status;
	
	}

	public function getExpense($date, $month, $year) {

		$expense = new ExpenseEntity ();
		if ($date != null) {
			//extract only yyyy-mm-dd
			$date = substr($date, 0, 10);
			$res = $this->expense_model->getDailyExpense ( $date );
		}
		return $res;
	}

}
