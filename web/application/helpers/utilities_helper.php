<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function formatNumberToDisplayInMillions($number, $fullFormat=FALSE)
{
	// is this a number?
	if(!is_numeric($number)) return false;

	// now filter it;
	if($number>=1000000000000) return round(($number/1000000000000),0). (($fullFormat)? ' Trillion':' T');
	else if($number>=1000000000) return round(($number/1000000000),0).(($fullFormat)? ' Billion':' B');
	else if($number>=1000000) return round(($number/1000000),0).(($fullFormat)? ' Million':' M');
	else if($number>=1000) return round(($number/1000),0).(($fullFormat)? ' Thousand':' K');

	return number_format($number, 0, '.', ',');
}


function formatNumberForDisplay($number, $decimal=0, $decimalSeperator='.', $numberSeperator=',')
{
	return number_format($number, $decimal, $decimalSeperator, $numberSeperator);
}

function formatStringToTitleCase($str)
{
	return ucwords($str);
}

function formatDurationToDisplayInDays($duration)
{
	if($duration >0 & $duration < 86400) return '0 Day';
	elseif($duration>=86400 & $duration <= 172800) return '1 Day';
	else{
		return round(($duration/86400),0).' Days';
	}
}

function displaySymbolForCurrencyCode($currencyCode){
	$symbol = config_item($currencyCode);
	return $symbol == null? $currencyCode :$symbol;
}


function draw_horizontal($percent,$color)
{
	$width = 100;
	if ($percent >=0 && $percent <= 100)
		$width = 100 - $percent;

	echo '<div class="hz-bar">
	<div class="hz-bar-percent" style="background:' . $color . ';">
	<span style="width:' . $width . '%;"></span>
	</div>
	<div class="hz-bar-position" style="left:' . $percent . '%;">
	<span></span>
	</div>
	</div>';
}


function draw_circle($percent,$color, $displayValue)
{
	list($r,$g,$b)=html2rgb($color);
	$rgb_str='rgb('.$r.', '.$g.', '.$b.')';
	$rotate_deg=(360 / 100) *$percent;
	$circle_str='<div class="pietimer" name="full-pie_'.$percent.'" style="font-size: 33px;">
	<div class="percent" title="' . $displayValue . '" style="color:'.$color.'">'. $displayValue . '</div>
	<div class="closer" style="border-color: rgb(240, 240, 240);"></div>';
	if($percent<50){
		$circle_str.='<div class="slice"><div class="pie" style="-moz-transform: rotate('.$rotate_deg.'deg);-webkit-transform: rotate('.$rotate_deg.'deg);-o-transform: rotate('.$rotate_deg.'deg);msTransform: rotate('.$rotate_deg.'deg);-ms-transform: rotate('.$rotate_deg.'deg);transform:rotate('.$rotate_deg.'deg);  border-color: '.$rgb_str.';"></div></div>';
	}else{
		$circle_str.='<div class="slice gt50"><div class="pie" style="-moz-transform: rotate('.$rotate_deg.'deg);-webkit-transform: rotate('.$rotate_deg.'deg);-o-transform: rotate('.$rotate_deg.'deg);msTransform: rotate('.$rotate_deg.'deg);-ms-transform: rotate('.$rotate_deg.'deg);transform:rotate('.$rotate_deg.'deg);  border-color: '.$rgb_str.';"></div><div class="pie fill" style="-moz-transform: rotate('.$rotate_deg.'deg);-webkit-transform: rotate('.$rotate_deg.'deg);-o-transform: rotate('.$rotate_deg.'deg);msTransform: rotate('.$rotate_deg.'deg);transform:rotate('.$rotate_deg.'deg);  border-color: '.$rgb_str.';"></div></div>';
	}
	$circle_str.='</div>';
	echo $circle_str;
}
function html2rgb($color)
{
	if ($color[0] == '#')
		$color = substr($color, 1);

	if (strlen($color) == 6)
		list($r, $g, $b) = array($color[0].$color[1],
				$color[2].$color[3],
				$color[4].$color[5]);
	elseif (strlen($color) == 3)
	list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	else
		return false;

	$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

	return array($r, $g, $b);
}
function horizontal_chart_color($delivery_status)
{
	//TODO need to set default value
	$color = "#FF0000";//red
	if($delivery_status == 'UNDER_DELIVERING' ){
		$color = "#FF0000";
	}else if($delivery_status == 'PER_EXECPTATION' ){
		$color = "#55A909";//green
	}else if($delivery_status == 'SLIGHTLY_UNDER_DELIVERING' ){
		$color = "#F2C802";//yellow
	}else if($delivery_status == 'OVER_DELIVERING' ){
		$color = "#990099";//purple.
	}
	return $color;
}

function getFormattedString($str, $length)
{
	if(strlen($str)>=$length){
		return substr($str,0,$length) . "...";
	}
	return $str;
}
function getFileSize($bytes)
{
	$size = $bytes / 1024;
	if($size < 1024){
		$size = number_format($size, 2);
		$size .= ' KB';
	}else if($size / 1024 < 1024){
		$size = number_format($size / 1024, 2);
		$size .= ' MB';
	}else if ($size / 1024 / 1024 < 1024){
		$size = number_format($size / 1024 / 1024, 2);
		$size .= ' GB';
	}
	return $size;
}

function getShowQueryVal($pre_val, $setempty=false){
	if (isset($pre_val) && ($pre_val)){
		$value = $pre_val;
	}else{
		if($setempty)
			$value='';
		else
			$value='["0"]';
	}
	return $value;
}

function array_searchRecursive( $needle, $haystack, $strict=false, $path=array() )
{
	if( !is_array($haystack) ) {
		return false;
	}

	foreach( $haystack as $key => $val ) {

		if( is_array($val) && $subPath = array_searchRecursive($needle, $val, $strict, $path) ) {
			$path = array_merge($path, array($key), $subPath);

			return $path;
		} else if( (!$strict && $val == $needle) || ($strict && $val === $needle) ) {

			$path[] = $key;
			return $path;
		}
	}
	return false;
}
/**
 * function to validate two form fields
 * used by validator class
 * @return boolean
 */

function greaterThan($value, $param){

	if($param['param1'] <= $param['param2'])
		return TRUE;
	return FALSE;
}

/**
 * Function used to sort the columns accordinging to the array passed
 */
function sortArrayByArray($array,$orderArray) {
	$ordered = array();
	foreach($orderArray as $key) {
		if(array_key_exists($key,$array)) {
			$ordered[$key] = $array[$key];
			unset($array[$key]);
		}
	}
	return $ordered + $array;
}

function is_decimal( $val ){
	return is_numeric( $val ) && floor( $val ) != $val;
}
function is_image_exist($url){
	$file_headers = @get_headers($url);
	return ($file_headers[0] == 'HTTP/1.1 200 OK')?true:false;
}

function percentage($nominator, $denominator, $round = 0){
	if($denominator==null || $denominator==0 || $denominator==-1){
		return 0;
	}
	return round(($nominator/$denominator)*100,$round);
}
?>
