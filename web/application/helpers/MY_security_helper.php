<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Security Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/security_helper.html
 * 
 * 
 * 
 */

// ------------------------------------------------------------------------

/**
 * XSS Filtering
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('sanitize_post_data'))
{
	function sanitize_post_data()
	{
		
		//XSS Attack check is disabled temporarily
		
		
		$restrictedItemsArray = config_item('restricted_xss_items');
		checkForRestrictedNames($_POST, $restrictedItemsArray);
		
		
// 		$CI =& get_instance();
		
// 		$tempPOST = $_POST;
		
// 		$skipFields = config_item('skip_xss_check_fields');
// 		foreach($skipFields as $fields){
// 			$tempPOST[$fields] = null;
// 		}
		
// 		//This is a temporary patch to remove all the non printable characters
// 		//from the object. There are some characters which is currently in place
// 		//in UI1.0. 
// 		//This code will trim all those characters which are non printable.
// 		//This patch should be removed after some time, considering that the data is 
// 		//sanitized in the server.
// 		foreach ($_POST as $keys => $values){
// 			if($tempPOST[$keys] != null){
// 				$_POST[$keys] = preg_replace('/[\x00-\x09\x11-\x1F\x80-\xFF]/', '', $values);
// 				$tempPOST[$keys] = preg_replace('/[\x00-\x09\x11-\x1F\x80-\xFF]/', '', $values);
// 			}
// 		}
		
// 		//All the fields to be skipped, potentially has some values
// 		//which will get sanitized. hence assigning null
		
// 		$scanned = $CI->security->xss_clean($tempPOST, TRUE);
// 		if(@array_diff($scanned, $tempPOST) == null){
// 			$restrictedItemsArray = config_item('restricted_xss_items');
// 			checkForRestrictedNames($_POST, $restrictedItemsArray);
// 		} else{
// 			throw new Exception("XSS Threat Detected", 999);
// 		}
	}
}

if ( ! function_exists('checkForRestrictedNames'))
{
	//Check for further restriction
	function checkForRestrictedNames($tempPOST, $restrictedItemsArray){
		foreach ($tempPOST as $member){
			$scanned = @str_replace($restrictedItemsArray, 'removed', $member);
			if( @strcmp($scanned, $member) != 0 ){
				throw new Exception("XSS Threat Detected", 998);
			}
		}
	}
}

/* End of file MY_security_helper.php */
/* Location: ./application/helpers/security_helper.php */