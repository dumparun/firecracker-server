<?php

/**
 * @author Arun
 *
 */

require_once APPPATH . '/entities/income.php';

class Income_Service extends Service {

	function __construct() {

		parent::__construct ();
		
		$this->load->model ( 'income_model' );
	
	}

	public function insertIncome($salary, $otherIncome, $other) {

		$income = new IncomeEntity ();
		$income->salary = $salary;
		$income->otherofficeincome = $otherIncome;
		$income->others = $other;
		$res = $this->income_model->insertIncome ($income);
		return $res;
	
	}

	public function getIncome() {

		return $this->income_model->getIncome ();
		
	}

}
