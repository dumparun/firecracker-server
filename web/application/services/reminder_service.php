<?php

/**
 * @author Arun
 *
 */

require_once APPPATH . '/entities/reminder.php';

class Reminder_Service extends Service {

	function __construct() {

		parent::__construct ();
		
		$this->load->model ( 'reminder_model' );
	
	}

	public function addReminder($reminder) {

		return $this->reminder_model->addReminder ( $reminder );
	
	}

	public function updateReminder($reminders) {

		$allItems = array (
				'1' => 'Amex US',
				'2' => 'Amex India',
				'3' => 'BOA',
				'4' => 'CITI',
				'5' => 'Capital One',
				'6' => 'Airtel MG Broadband',
				'7' => 'Airtel MG Phone',
				'8' => 'Airtel Bangalore',
				'9' => 'Vodafone Arun',
				'10' => 'Vodafone Priya',
				'11' => 'SBI Credit Card',
				'12' => 'Axis Credit Card',
				'13' => 'ICICI Credit Card' 
		);
		
		foreach ( $reminders as $reminder ) {
			$seq = array_keys ( $allItems, $reminders ["item"] );
			$this->reminder_model->updateReminder ( $seq [0], $reminder ["item"], $reminder ["reminder"] );
		}
		
		return 0;
	
	}

	public function getReminder() {

		return $this->reminder_model->getReminder ();
	
	}

}
