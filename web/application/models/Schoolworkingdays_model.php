<?php


/**
 * @author Sujith
 *
 */
class SchoolWorkingDays_Model extends MY_Model {

	public $_table = 'school_working_days';

	public $primary_key = 'user_id';


	function __construct() {

		parent::__construct ();

	}

	public function insertWorkingDaysOfSchool($schoolWorkingDays){

		$data = array(

				'user_id' => $schoolWorkingDays->user_id,

				'monday' =>$schoolWorkingDays->monday,

				'tuesday' => $schoolWorkingDays->tuesday,

				"wednesday" => $schoolWorkingDays->wednesday,

				'thursday' =>$schoolWorkingDays->thursday,

				'friday' =>$schoolWorkingDays->friday,

				'saturday' =>$schoolWorkingDays->saturday,

				'sunday' =>$schoolWorkingDays->sunday,


		);

		return parent::insert ( $data, false );

	}

	public function updateWorkingDaysOfSchool($schoolWorkingDays) {

		$data = array (
					
				'monday' =>$schoolWorkingDays->monday,

				'tuesday' => $schoolWorkingDays->tuesday,

				"wednesday" => $schoolWorkingDays->wednesday,

				'thursday' =>$schoolWorkingDays->thursday,

				'friday' =>$schoolWorkingDays->friday,

				'saturday' =>$schoolWorkingDays->saturday,

				'sunday' =>$schoolWorkingDays->sunday,
		);

		return parent::update ( $schoolWorkingDays->user_id, $data, false );

	}



	public function getWorkingDaysWithUserID($userID) {


		return parent::get ( $userID );

	}

}