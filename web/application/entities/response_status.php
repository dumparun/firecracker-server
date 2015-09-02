<?php
/**
 * @author Arun
 *
 */
class ResponseStatus extends Entity {
	public $code;
	public $message;
	
	/*
	 * public function __construct($entity = false) { parent::__construct ( $entity ); }
	 */
	
	public function __construct($code = null, $message = null) {
		parent::__construct ();
		$this->code = $code;
		
		$this->message = $message;
	
	}
}