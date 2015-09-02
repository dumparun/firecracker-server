<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * create_url()
 *
 * Create a local URL based on your basepath.
 *
 * @access	public
 * @param	string - controller path
 * @param	array - list key/value pairs
 * @return	string
 */
if ( ! function_exists('create_url'))
{
	function create_url($key = '', $params = array(), $dataurl = false)
	{
		 $uri = get_instance()->config->item($key);
		 $uri = ($uri == '')?$key:$uri;	
		 $CI =& get_instance();			 
		 $suffix = ($dataurl)?'.json?lang=en-us':'?lang=en-us';
		 $uri = $uri.$suffix;
		 foreach ($params as $key => $val) {
			$uri = $uri. '&' . $key . '=' . $val;
		}		
		//return $uri;
		return $CI->config->site_url($uri);
	}
}

function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}
 
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}

function arrayToObject($d) {
	if (is_array($d)) {
		/*
			* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return (object) array_map(__FUNCTION__, $d);
	}
	else {
		// Return object
		return $d;
	}
}
/* End of file url_helper.php */