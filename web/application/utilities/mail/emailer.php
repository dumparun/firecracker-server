<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailer
{
	var $from = "no-reply@mysite.com";
	var $senderName = "Kickiss";

	var $toRecipients = array();
	var $ccRecipients = array();
	var $bccRecipients = array();

	var $emailTemplate;

	var $subject;

	/**
	 * @param $to To mail id
	 * @param @cc CC mail id
	 * @param @bcc BCC mail id
	 * @param @from From mail id
	 **/
	public function __construct($to = false, $cc = false, $bcc = false, $from="no-reply@maganiva.com")
	{
		$this->_ci =& get_instance();
			
		$this->_ci->load->library('email');
			
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
			
		$this->_ci->email->initialize($config);

		$this->_ci->email->clear();

		$this->from = $from;
		
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

		if($cc !== false)
		{
			if(is_array($cc))
			{
				foreach($cc as $_cc){
					$this->ccRecipients[$_cc] = $_cc;
				}
			}else
			{
				$this->ccRecipients[$cc] = $cc; //1 Recip
			}
		}

		if($bcc !== false)
		{
			if(is_array($bcc))
			{
				foreach($bcc as $_bcc){
					$this->bccRecipients[$_bcc] = $_bcc;
				}
			}else
			{
				$this->bccRecipients[$bcc] = $bcc; //1 Recip
			}
		}
	}

	public function SetTemplate(EmailTemplate $EmailTemplate, $subject = "Hello")
	{
		$this->emailTemplate = $EmailTemplate;
		$this->subject = $subject;
	}

	public function send(){
		$emailContent = $this->emailTemplate->compile();

		$header = "From: ". $this->from . "\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
		$this->_ci->email->from($this->from, $this->senderName );

		$this->_ci->email->to($this->toRecipients);

		$this->_ci->email->cc($this->ccRecipients);

		$this->_ci->email->bcc($this->bccRecipients);
			
		$this->_ci->email->subject($this->subject);

		$this->_ci->email->message($emailContent);
		
		$this->_ci->email->mailtype = "html";
		
		$returnVal = $this->_ci->email->send();
			
		return $returnVal;
			
	}
}