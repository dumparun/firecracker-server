<?php
/**
 * Extend Output class to handle caching in future. this is TODO
 * 
 * @author Maganiva
 *
 */
class MY_Output extends CI_Output {
	
	protected $_memcached;	// Holds the memcached object
	
	
	/**
	 * 
	 * @param $output
	 */
	public function renderView($output){
		//TODO In future to be overwritten to implement Cache		
		echo $output;
	}
}