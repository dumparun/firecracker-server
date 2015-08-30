<?php
require_once APPPATH . 'entities/state.php';


class State_Service extends Service {


	function __construct() {

		parent::__construct ();
		$this->load->model ( 'State_model' );

	}


	public function fetchState($countryId) {

		$types = $this->State_model->fetchState ( $countryId );

		$arrayOfTypes = null;
		foreach ( $types as &$value ) {
			$typez = new State ( $value );
			$arrayOfTypes [$typez->state_id] = $typez;
		}
		return $arrayOfTypes;

	}

	public function fetchAllStates() {
		$types = $this->State_model->fetchAllState ();
		return $types;
	}


	public function fetchStateBasedOnStateId($stateId) {
		return $this->State_model->fetchStateById ( $stateId );
	}

	public function fetchStateNameBasedOnStateId($stateId) {

		$val = $this->State_model->fetchStateById ( $stateId );
		return $val->state_name;

	}
	
	public function fetchStateWithStateName($stateName){
		return $this->State_model->fetchStateWithStateName ( $stateName );
	}


}