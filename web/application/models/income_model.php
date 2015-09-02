<?php

/**
 * @author Arun
 *
 */
class Income_Model extends MY_Model {

	public $_table = 'income';

	public $primary_key = 'sequence';

	function __construct() {

		parent::__construct ();
	
	}

	public function getIncome() {

		return parent::get (1);
	
	}

	public function insertIncome($income) {
	
		$data = array (
	
				'salary' => $income->salary,
	
				'otherofficeincome' => $income->otherofficeincome,
	
				"others" => $income->others,
	
		);
	
		return parent::update ( 1, $data );
	
	}
}