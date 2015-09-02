<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_date_from_timestamp($gmt_timestamp, $format=NULL, $timezone=NULL)
{
	if ($format == NULL)
		$format = get_instance()->config->item('date_format');
	if ($timezone == NULL){
		$user_timezone = get_instance()->session->userdata('user_time_zone');
		$gmt_timestamp = $gmt_timestamp;// + $user_timezone;
	}
	$timezone_locale = get_instance()->session->userdata('user_time_zone_locale');

	$serverTimeZone = date_default_timezone_get();

	if(function_exists('date_default_timezone_set'))
		date_default_timezone_set($timezone_locale);

	if($gmt_timestamp==NULL) //TODO : If the timestamp is null, returning back the current date. (Default behaviour of utility).
		$result =  ''; //@date($format); //TODO For end date if the default date-time shown that may be the sooner than curent date-time
	else 
		$result = @date($format,$gmt_timestamp);

	if(function_exists('date_default_timezone_set'))
		date_default_timezone_set($serverTimeZone);

	return $result;
}

function get_time_from_timestamp($gmt_timestamp, $format=NULL, $timezone=NULL)
{
	if($gmt_timestamp == NULL || $gmt_timestamp == '')
		return ''; //12:00 AM'; //TODO For end date if the default date-time shown that may be the sooner than curent date-time
	return get_date_from_timestamp($gmt_timestamp, $format, $timezone);
}

function get_date_from_millisecond($gmt_timestamp, $format=NULL, $timezone=NULL)
{
	$gmt_timestamp=intval($gmt_timestamp/1000);
	$result=get_date_from_timestamp($gmt_timestamp, $format, $timezone);
	return $result;
}

function get_manipulated_timestamp($timestamp,$hour=0)
{
	$result=$timestamp+$hour*3600;
	return $result;	
}

function convert_to_24_format($hour = 12, $period ='am')
{
	if($period == 'am'){
		if($hour == 12)
			$hour = 0;
	}
	else {
		if($hour != 12)
			$hour += 12;
	}
	return $hour;
}

function createTmeRangeArray($DateFrom,$DateTo) {
	$aryRange=array();
	$iDateFrom = strtotime($DateFrom);
	$iDateTo = strtotime($DateTo);
	if ($iDateTo>=$iDateFrom) {
		//array_push($aryRange,date('g:i A',$iDateFrom)); // first entry
		$timeStamp = createTS($DateFrom);
		$aryRange[$timeStamp] = date('g:i A',$iDateFrom);
		while ($iDateFrom<$iDateTo) {
			$iDateFrom+=3600;
			 $timeStamp = createTS(date('g:i A',$iDateFrom));
			//array_push($aryRange,date('g:i A',$iDateFrom));
			$aryRange[$timeStamp] = date('g:i A',$iDateFrom);
		}
	}
	return $aryRange;
}

function createTS($convTS){
	$amPM = explode(' ', $convTS);
	$convTS = explode(':', $amPM[0]);
	
	if($amPM[1] == 'PM'){
		$hours = ($convTS[0] + 12) * 3600;		
	}else{
		$hours = $convTS[0] * 3600;
	}
	$mints = $convTS[1] * 60;
	$TS = $hours + $mints;	
	return $TS;	
}

function time_seprate($full_time,$is_ass_index = true)
{
	$full_time = intval($full_time);
	if($full_time<12){
		$period = ($is_ass_index == true)?'am':1;
	} else {
		$period = ($is_ass_index == true)?'pm':2;
		$full_time = $full_time - 12;
	}
	$hour =($full_time == 0)? 12 : $full_time;
	return array($hour, $period);
}
