<?php

/**
 * @author Arun
 *
 */

require APPPATH . '/entities/expense.php';

require_once BASE_APPPATH . 'third_party/PHPExcel/PHPExcel.php';

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
		$expense->expensedate = $date;
		$expense->description = $description;
		$expense->category = array_search ( $category, $allCategory );
		$expense->paymentType = array_search ( $paymentType, $allPaymentType );
		$expense->amount = $amount;
		$status = $this->expense_model->submitDailyExpense ( $expense );
		
		return $status;
	
	}

	public function getExpense($date, $month, $year) {

		$allMonths = array (
				'01' => 'January',
				'02' => 'February',
				'03' => 'March',
				'04' => 'April',
				'05' => 'May',
				'06' => 'June',
				'07' => 'July',
				'08' => 'August',
				'09' => 'September',
				'10' => 'October',
				'11' => 'November',
				'12' => 'December' 
		);
		$expense = new ExpenseEntity ();
		$month = 'August';
		if ($date != null) {
			// extract only yyyy-mm-dd
			$date = substr ( $date, 0, 10 );
			$res = $this->expense_model->getDailyExpense ( $date );
		} else if ($month != null && $year != null) {
			$fromDate = $year . '-' . array_search ( $month, $allMonths ) . '-01';
			$toDate = $year . '-' . array_search ( $month, $allMonths ) . '-31';
			$res = $this->expense_model->getMonthlyExpense ( $fromDate, $toDate );
		} else if ($month != null) {
			$currentYear = date('Y');
			$fromDate = $currentYear.'-' . array_search ( $month, $allMonths ) . '-01';
			$toDate = $currentYear.'-' . array_search ( $month, $allMonths ) . '-31';
			$res = $this->expense_model->getMonthlyExpense ( $fromDate, $toDate );
		} else {
			// extract only yyyy-mm-dd
			$date = date ( "y-m-d" );
			$date = "20" . $date;
			$res = $this->expense_model->getDailyExpense ( $date );
		}
		$index = 0;
		foreach ( $res as $value ) {
			$finalList [$value->expensedate] [$index ++] = ($value);
		}
		
		return $finalList;
	
	}

	public function uploadExcel() {

		$fileName = BASE_APPPATH . '../resources/excel.xlsx';
		
		$inputFileType = PHPExcel_IOFactory::identify ( $fileName );
		$objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
		$objPHPExcel = $objReader->load ( $fileName );
		
		$rowIterator = $objPHPExcel->getActiveSheet ()
			->getRowIterator ();
		$array_data = array ();
		foreach ( $rowIterator as $row ) {
			$cellIterator = $row->getCellIterator ();
			$cellIterator->setIterateOnlyExistingCells ( false );
			$rowIndex = $row->getRowIndex ();
			$array_data [$rowIndex] = array ();
			
			foreach ( $cellIterator as $cell ) {
				$array_data [$rowIndex] [$cell->getColumn ()] = $cell->getCalculatedValue ();
			}
		}
		$i = 0;
		
		foreach ( $array_data as $eachRow ) {
			
			if ($eachRow ['B'] === null || $eachRow ['B'] === '') {
				continue;
			}
			
			$date = '2015-08-' . $eachRow ['A'];
			$description = $eachRow ['B'];
			$category = $eachRow ['C'];
			$paymentType = $eachRow ['D'];
			$amount = abs($eachRow ['E']);
		
			$data = $this->submitDailyExpense($date, $description, $category, $paymentType, $amount);
		}
	
	}

}
