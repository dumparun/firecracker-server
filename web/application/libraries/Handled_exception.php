<?php
/**
 *
 * @author Maganiva
 *
 */
class HandledException extends Exception {
	public $loggable_params = FALSE;
	public function __construct($message =null, $code =null, $loggable_params = null){
		parent::__construct($message, $code);
		$this->loggable_params = $loggable_params;
	}
}