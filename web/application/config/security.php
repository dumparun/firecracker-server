<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Add to this list, which all values needs to be restricted from user entry
 */

$config['restricted_xss_items'] = array('<marquee>', '</marquee>');
$config['skip_xss_check_fields'] = array();