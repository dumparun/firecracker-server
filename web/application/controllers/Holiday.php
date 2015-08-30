<?php

/**
 *
 * @author SIJIN L JOSE
 *
 */
require_once BASE_APPPATH . 'entities/holidays.php';


class Holiday extends Secured_View_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->service ( 'Holiday_service' );
	}


	public function ManageHolidays() {

		$holidays=$this->Holiday_service->fetchAllHolidays();

		$this->view_data['holidays'] = $holidays;

		$this->content_view = 'holidays';

	}

	public function addHoliday() {

		$holiday=new holidays();

		$holiday->school_id=$_SESSION['user_id'];

		$holiday->date=$this->input->post('date');

		$holiday->event=$this->input->post('event');

		$holiday->status=0;

		$holidays=$this->Holiday_service->addHoliday($holiday);

		if($holidays != null){

			$this->session->set_flashdata ( 'successMessage', "Holidays Added Successfully" );
			redirect('Holiday/ManageHolidays');
		}else{

			$this->session->set_flashdata ( 'errorMessage', "error" );
			redirect('Holiday/ManageHolidays');
		}
	}
	public function updateHoliday() {

		$holiday=new holidays();


		$holiday->school_id=$_SESSION['user_id'];

		$holiday->holiday_id=$this->input->post('editHolidayButton');


		$holiday->date=$this->input->post('date'.$holiday->holiday_id );

		$holiday->event=$this->input->post('event'.$holiday->holiday_id);
		//var_dump($holiday);die;

		$holiday->status=0;

		$holidays=$this->Holiday_service->updateHoliday($holiday);

		if($holidays != null){

			$this->session->set_flashdata ( 'successMessage', "Holidays updated Successfully" );
			redirect('Holiday/ManageHolidays');
		}else{

			$this->session->set_flashdata ( 'errorMessage', "error" );
			redirect('Holiday/ManageHolidays');
		}
	}




}