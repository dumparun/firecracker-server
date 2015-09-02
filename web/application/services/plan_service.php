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
		$this->load->model ( 'income_model' );
	
	}

	public function updatePlan($plans) {

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
		
		foreach ( $plans as $plan ) {
			$seq = array_keys ( $allCategory, $plan ["category"] );
			$this->plan_model->updatePlan ( $seq [0], $plan ["category"], $plan ["plannedAmount"] );
		}
		
		return 0;
	
	}

	public function getPlanView($past = 'false') {
		
		// $past is used to pick last months expenditure.
		
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
		$currentMonth = date ( 'm' );
		$currentYear = date ( 'Y' );
		
		if ($past == 'true') {
			$currentMonth = date ( 'm' ) - 1;
			$creditCardExpense = $this->getLastMonthCreditCardExpense ();
		}
		
		$fromDate = $currentYear . '-' . $currentMonth . '-01';
		$toDate = $currentYear . '-' . $currentMonth . '-31';
		$currentExpense = $this->expense_model->getExpenseOnCategory ( $fromDate, $toDate );
		
		$index = 0;
		foreach ( $res as $value ) {
			$newList = new PlanViewList ();
			$newList->category = $value->category;
			$newList->plannedAmount = floatval ( $value->amount );
			$newList->expenditure = 0;
			
			foreach ( $currentExpense as $cat ) {
				$key = array_keys ( $allCategory, $value->category );
				if ($cat->category == $key [0]) {
					if ($past && $key [0] == '1') {
						$newList->expenditure = $creditCardExpense;
					} else {
						$newList->expenditure = $cat->amt;
					}
					
					break;
				}
			}
			
			$finalList [$value->category] = $newList;
		}
		
		$inc = $this->income_model->getIncome ();
		$finalList ['income'] = floatval ( $inc->salary ) + floatval ( $inc->otherofficeincome ) + floatval ( $inc->others );
		return $finalList;
	
	}

	public function getLastMonthCreditCardExpense() {

		$currentMonth = date ( 'm' );
		$currentYear = date ( 'Y' );
		
		$data = array (
				'2' => '24',
				'3' => '19',
				'4' => '20',
				'5' => '11',
				'6' => '15' 
		);
		$cardTotal = 0;
		
		foreach ( $data as $itemKey => $itemVal ) {
			
			$fromDate = $currentYear . '-' . $currentMonth - 1 . '-' . $itemVal;
			$toDate = $currentYear . '-' . $currentMonth . '-' . $itemVal;
			
			$res = $this->expense_model->getCreditCardHistory ( $itemKey, $fromDate, $toDate );
			$cardTotal += $res [0]->amt;
		
		}
		
		return $cardTotal;
	
	}

}
