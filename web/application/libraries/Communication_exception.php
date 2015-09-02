<?php
/**
 * 
 * @author Maganiva
 *
 */
class Communication_Exception extends Exception {
	
	public $passed_object = FALSE;	
	
	public function __construct($passed_object, $message, &$code){
        parent::__construct($message, $code);
        $this->passed_object = $passed_object;
    }
}