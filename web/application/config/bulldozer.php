<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * default language field form $_POST or $_GET or $_SESSION
*  config_item()
*/

$config['page_title'] = "Build Mantra";

$config['js_version'] = '1.1.0.1';

$config['white_label'] = 'default';


$config['language_field'] = 'lang';
/*
 * default language output
*/
$config['language_key'] = 'en-us';
/*
 * default language list to support
*/
$config['language_list'] = array(
		'en-us' => 'english',
		'zh-tw' => 'zh-tw'
);
$config['time_format'] = array(
		'am'  => 'AM',
		'pm'    => 'PM',
			
);

$config['time_zone'] = 'IST';
$config['date_format'] = 'DD MM YY H:I:S';

$config['time_zone'] = 'GMT';
$config['date_format'] = 'd M Y';
