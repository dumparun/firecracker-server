<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Maganiva
 * 
 */

/*
 * Extented to allow URLs like 
 * example.com/product/search/?pname=test&pid=2
 * config settings required: 
 * $config['uri_protocol'] = "PATH_INFO";
 * $config['enable_query_strings'] = TRUE;
 * 
 */
class My_Config extends CI_Config {
	
	
	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 *
	 * @access	public
	 * @param	string	the URI string
	 * @return	string
	 */
	function site_url($uri = '',$params=array(), $dataurl = false)
	{
		if ($uri == '')
		{
			return $this->slash_item('base_url').$this->item('index_page');
		}
		
		
		if ($this->item('enable_query_strings') == FALSE)
		{
			$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
			return $this->slash_item('base_url').$this->slash_item('index_page').$this->_uri_string($uri).$suffix;
		}
		else
		{
			if($this->item('uri_protocol') == 'PATH_INFO'){
				return $this->slash_item('base_url').$this->item('index_page').$this->_uri_string($uri);
			}else{
				return $this->slash_item('base_url').$this->item('index_page').'?'.$this->_uri_string($uri);						
			}
		}
	}

}
// END CI_Config class

/* End of file Config.php */
