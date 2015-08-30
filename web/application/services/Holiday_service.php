<?php

require_once BASE_APPPATH . 'entities/holidays.php';


class Holiday_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'Holiday_model' );
	}


	public function addHoliday($holiday) {

		return $this->Holiday_model->addHoliday ( $holiday );



	}
	public function updateHoliday($holiday) {

		return $this->Holiday_model->updateHoliday ( $holiday );



	}
	public function fetchHolidayWithId($holidayId) {

		return $this->Holiday_model->fetchHolidayWithId ( $holidayId );



	}
	public function fetchAllHolidays() {

		return $this->Holiday_model->fetchAllHolidays ( );



	}

}
