<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


/**
 *
 * @author Maganiva
 *
 *
*/

require_once APPPATH . 'libraries/Unsecured_view_controller.php';

class Customer_Unsecured_View_Controller extends Unsecured_View_Controller {


	function __construct() {

		parent::__construct ();

	}


	public function _output($output) {

		return parent::_output ( $output );

	}
}