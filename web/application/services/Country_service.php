<?php
/**
 * @author Sujith 
 *
 */

class Country_Service extends Service {
	
	function __construct() {
		
		parent::__construct ();
		
		$this->load->model ( 'Country_model' );
	}

	public function getAllCountry(){
		
		return $this->Country_model->getAllCountry();
		
	}
}
