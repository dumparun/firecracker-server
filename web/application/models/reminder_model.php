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

	public function updatePlan($seq, $category, $amount) {

		$data = array (
				
				'category' => $category,
				
				'amount' => $amount 
		);
		
		return parent::update ( $seq, $data );
	
	}

}