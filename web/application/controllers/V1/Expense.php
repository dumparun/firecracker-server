<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require APPPATH . 'libraries/Rest_Controller.php';

require APPPATH . '/utilities/security_util.php';

require APPPATH . '/entities/response_status.php';

require APPPATH . '/entities/expense_response.php';

class Expense extends REST_Controller {

	function __construct() {

		parent::__construct ();
		
		$this->load->service ( "Expense_service" );
	
	}

	function submitDailyExpense_post() {

		$date = $this->post ( 'date' );
		$description = $this->post ( 'description' );
		$category = $this->post ( 'category' );
		$paymenType = $this->post ( 'paymentType' );
		$amount = $this->post ( 'amount' );
		
		$status = $this->Expense_service->submitDailyExpense ( $date, $description, $category, $paymenType, $amount );
		
		$response = new ExpenseResponse ( false );
		
		if ($status > 0)
			$status = new ResponseStatus ( 0, "Expense was submitted succesfully" );
		else
			$status = new ResponseStatus ( 101, "Expense was not submitted, please try again" );
		
		$response->status = $status;
		
		$this->response ( $response );
	
	}

}
