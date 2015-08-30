<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SMS_Utility
{

	var $userName ="sharma.gaurav860529@gmail.com:Gaurav1";

	var $password = "password";

	var $senderID = "SKYNET";

	var $toRecipients = array();

	var $template = null;

	var $message = null;
	
	public function __construct($to = false)
	{

		if($to !== false)
		{
			if(is_array($to))
			{
				foreach($to as $_to){
					$this->toRecipients[$_to] = $_to;
				}
			}else
			{
				$this->toRecipients[$to] = $to; //1 Recip
			}
		}
	}


	public function setTemplate(SMSTemplate $Template){
		$this->template =  $Template;
		$this->message = $this->template->compile();
	}

	public function sendSMS(){

		$to = null;

		if(sizeof($this->toRecipients) > 1){
			$state = 1;
		}else {
			$state = 4;
		}
		
		foreach ($this->toRecipients as &$recipients){
			$to .= $recipients . ",";
		}
		$to = rtrim($to, ",");

		$senderChannel = curl_init();

		curl_setopt($senderChannel,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");

		curl_setopt($senderChannel, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($senderChannel, CURLOPT_POST, 1);

		curl_setopt($senderChannel, CURLOPT_POSTFIELDS, "user=".$this->userName."&senderID=".$this->senderID."&receipientno=".$to."&dcs=0&msgtxt=".$this->message."&state=".$state);

		$buffer = curl_exec($senderChannel);

		if(empty ($buffer))
		{
			curl_close($senderChannel);
			return false;
		}
		else
		{
			curl_close($senderChannel);
			return true;
		}
	}
}
