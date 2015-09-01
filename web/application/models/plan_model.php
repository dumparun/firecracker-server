<?php

/**
 * @author Arun
 *
 */
class Plan_Model extends MY_Model {

	public $_table = 'planning';

	public $primary_key = 'sequence';

	function __construct() {

		parent::__construct ();
	
	}

	public function getPlanView() {

		return parent::get_all ();
	
	}

}