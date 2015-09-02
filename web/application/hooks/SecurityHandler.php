<?php
/**
 *
 * @author Maganiva
 *
 */
class SecurityHandler
{
	
	var $CI;
	
	
	public function handleSecurity(){
		
		
		$this->CI =& get_instance();
		$this->CI->load->helper('cookie');
		
		if (!isset($this->CI->session))
		{
			$this->CI->load->library('session');
		}
		$cookieToken = get_cookie('__auth_token');		
		
		$userData = $this->CI->session->all_userdata();
		if(! empty($userData) && $cookieToken == "loggedout"){
			$this->CI->session->sess_destroy();
			session_destroy();				
		}
		
		if($_POST){
			sanitize_post_data();
		}
	}
}