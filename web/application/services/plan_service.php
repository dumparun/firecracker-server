<?php

/**
 * @author Arun
 *
 */

require APPPATH . '/entities/planview_list.php';

class Plan_Service extends Service {

	function __construct() {

		parent::__construct ();
		
		$this->load->model ( 'plan_model' );
		$this->load->model ( 'expense_model' );
	
	}

	public function getPlanView() {

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
		
		$res = $this->plan_model->getPlanView ();
		$currentExpense = $this->expense_model->getExpenseOnCategory();
		
		$index = 0;
		foreach ( $res as $value ) {
			$newList = new PlanViewList();
			$newList->category = $value->category;
			$newList->plannedAmount = $value->amount;
			
			$key = array_search($value->category, $allCategory);
			
			if(array_key_exists($key, $currentExpense))
				$newList->expenditure = $currentExpense[$key]->amt;
			else 
				$newList->expenditure = 0;
			
			$finalList [$value->category] = $newList;
		}
		return $finalList;

	}

}
