<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Unsecured_Data_Controller extends My_Controller
{
    function __construct ()  {
    	parent::__construct();
    	$this->layout_view ='';
    }
}