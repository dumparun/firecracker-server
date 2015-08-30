<?php 

class CookieUtility{

	function __construct(){
	}

	public function validateIAgree(){
		$CI =& get_instance();

		$CI->load->helper('cookie');
		$cookie = false;
		$cookie = get_cookie("iagree-dialog", TRUE);
		if($cookie == true)
			return true;
		else
			return false;
	}
	
	public function fromStore(){
		$CI =& get_instance();
		
		$CI->load->helper('cookie');
		$cookie = false;
		$cookie = get_cookie("from_store", TRUE);
		if($cookie == "true"){
			return true;
		}
		else
			return false;
	}
}
?>