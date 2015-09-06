<?php

/**
 * @author Arun
 *
 */
class Reminder_Model extends MY_Model {

	public $_table = 'reminders';

	public $primary_key = 'sequence';

	function __construct() {

		parent::__construct ();
	
	}

	public function getReminder() {

		return parent::get_all ();
	
	}

	public function addReminder($reminder) {

		$data = array (
				
				'item' => $reminder->item,
				
				'reminder' => $reminder->reminder 
		);
		
		return parent::insert ( $data );
	
	}

	public function updatePayment($seq) {

		$data = array (
				
				'paid' => 1 
		);
		
		return parent::update ( $seq, $data );
	
	}

	public function resetReminders() {

		$data = array (
				
				'paid' => 0 
		);
		
		$this->_database->set ( $data )
			->update ( $this->_table );
	
	}

	public function updatePlan($seq, $category, $amount) {

		$data = array (
				
				'category' => $category,
				
				'amount' => $amount 
		);
		
		return parent::update ( $seq, $data );
	
	}

}