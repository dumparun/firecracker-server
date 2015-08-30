<?php


class Holiday_Model extends MY_Model {

	public $_table = 'holiday';

	public $primary_key = 'holiday_id';


	function __construct() {

		parent::__construct ();

	}


	public function addHoliday($holiday) {

		$data = array (

				'date' => $holiday->date,
				'event' => $holiday->event,
				'status' => $holiday->status,
				'school_id' => $holiday->school_id,
		);

		return parent::insert ( $data, false );

	}


	public function updateHoliday($holiday) {

		$data = array (
				'date' => $holiday->date,
				'event' => $holiday->event,
				'status' => $holiday->status,
				'school_id' => $holiday->school_id,

		);

		return parent::update ( $holiday->holiday_id, $data, false );

	}


	public function fetchHolidayWithId($holiday_id) {

		return parent::get ( $holiday_id );

	}
	public function fetchAllHolidays() {

		return parent::get_all ();

	}

}
