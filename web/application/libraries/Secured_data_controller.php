<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Secured_Data_Controller extends Secured_Controller
{
    function __construct ()  {
    	parent::__construct();
    	$this->layout_view ='';
    }
}