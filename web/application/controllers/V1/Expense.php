<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/utilities/security_util.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/expense_response.php';

require APPPATH . '/entities/expense_list.php';

require_once APPPATH . '/entities/income.php';

class Expense extends REST_Controller {

	function __construct() {

		parent::__construct ();
		
		$this->load->service ( "expense_service" );
		
		$this->load->service ( "plan_service" );
		
		$this->load->service ( "income_service" );
	
	}

	function submitDailyExpense_post() {

		$date = $this->post ( 'date' );
		$description = $this->post ( 'description' );
		$category = $this->post ( 'category' );
		$paymenType = $this->post ( 'paymentType' );
		$amount = $this->post ( 'amount' );
		
		$status = $this->expense_service->submitDailyExpense ( $date, $description, $category, $paymenType, $amount );
		
		$response = new ExpenseResponse ( false );
		
		if ($status > 0)
			$status = new ResponseStatus ( 0, "Expense was submitted succesfully" );
		else
			$status = new ResponseStatus ( 101, "Expense was not submitted, please try again" );
		
		$response->status = $status;
		
		$this->response ( $response );
	
	}

	function getExpense_post() {

		$date = $this->post ( 'date' );
		$month = $this->post ( 'month' );
		$year = $this->post ( 'year' );
		$expenses = $this->expense_service->getExpense ( $date, $month, $year );
		
		$response = new ExpenseList ( false );
		
		if (sizeof ( $expenses ) > 0)
			$status = new ResponseStatus ( 0, "Recieved All Expenses" );
		else
			$status = new ResponseStatus ( 102, "We were not able to retrieve expenses, please try again" );
		
		$response->status = $status;
		$response->listOfExpenses = $expenses;
		
		$this->response ( $response );
	
	}

	function getPlanView_post() {

		$planview = $this->plan_service->getPlanView ();
		
		$response = new ExpenseList ( false );
		
		if (sizeof ( $planview ) > 0)
			$status = new ResponseStatus ( 0, "Plan Retrieved" );
		else
			$status = new ResponseStatus ( 103, "Too Bad, when its already bad" );
		
		$response->status = $status;
		
		$response->listOfExpenses = $planview;
		
		$this->response ( $response );
	
	}

	function insertIncome_post() {

		$salary = $this->post ( 'salary' );
		$otherIncome = $this->post ( 'otherofficeincome' );
		$others = $this->post ( 'others' );
		
		$status = $this->income_service->insertIncome ( $salary, $otherIncome, $others );
		
		$response = new ExpenseResponse ( false );
		
		if ($status > 0)
			$status = new ResponseStatus ( 0, "Income was submitted succesfully" );
		else
			$status = new ResponseStatus ( 101, "Income was not submitted, please try again" );
		
		$response->status = $status;
		
		$this->response ( $response );
	
	}

	function getIncome_post() {

		$res = $this->income_service->getIncome ();
		$response = new ExpenseResponse ( false );
		
		$response->status = new ResponseStatus ( 0, "Recieved Income" );
		$response->listOfExpenses = $res;
		$this->response ( $response );
	
	}

	function uploadExcel_get() {

		die ();
		$this->expense_service->uploadExcel ();
	
	}

}
