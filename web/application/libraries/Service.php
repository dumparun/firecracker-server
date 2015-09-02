<?php
/**
 * 
 * @author Maganiva
 *
 */
class Service{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}

	function getResponse($response){
		$res = new Entity();
		foreach($response as $key => $val){
			$res->$key = $val;
		}
		return $res;
	}
	
}