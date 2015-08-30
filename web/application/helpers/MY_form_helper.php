<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


function get_time_from_second($value_in_second) {

	if ($value_in_second < 0) {
		$value_in_second = 0;
	}
	$result = array ();
	if ($value_in_second >= 86400) {
		$unit = 'day';
		$value = round ( $value_in_second / 86400, 0 );
		$result = set_unit_and_values ( $unit, $value );
	} elseif ($value_in_second >= 3600) {
		$unit = 'hour';
		$value = round ( $value_in_second / 3600, 0 );
		$result = set_unit_and_values ( $unit, $value );
	} else {
		$unit = 'minute';
		$value = round ( $value_in_second / 60 );
		$result = set_unit_and_values ( $unit, $value );
	}
	return $result;

}


function get_time_from_minute($value_in_min) {

	if ($value_in_min < 0) {
		$value_in_min = 0;
	}
	$result = array ();
	if ($value_in_min >= 24 * 60 && ($value_in_min % (24 * 60) == 0)) {
		$unit = 'day';
		$value = $value_in_min / (24 * 60);
		$result = set_unit_and_values ( $unit, $value );
	} elseif ($value_in_min >= 1 * 60 && ($value_in_min % 60 == 0)) {
		$unit = 'hour';
		$value = $value_in_min / (1 * 60);
		$result = set_unit_and_values ( $unit, $value );
	} else {
		$unit = 'minute';
		$value = $value_in_min;
		$result = set_unit_and_values ( $unit, $value );
	}
	return $result;

}


function set_unit_and_values($unit, $value) {

	$result = array ();
	if ($unit == 'day') {
		$result ['minute'] = 10;
		$result ['hour'] = 1;
	} else if ($unit == 'hour') {
		$result ['minute'] = 10;
		$result ['day'] = 1;
	} else if ($unit == 'minute') {
		$result ['hour'] = 1;
		$result ['day'] = 1;
	}
	if ($unit == 'minute' && $value == '0') {
		$value = 10;
	}
	$result [$unit] = $value;
	$result ['unit'] = $unit;
	return $result;

}


function get_time_dropdown_data($dayLimit = 30, $hourLimit = 24, $minuteLimit = 60) {

	$result = array ();
	$time_unit = get_instance ()->config->item ( 'pixel_time_unit' );
	$result ['unit'] = $time_unit;
	$result ['day'] = get_value_list_time_unit ( $dayLimit, 1, TRUE, false );
	$result ['hour'] = get_value_list_time_unit ( $hourLimit, 1, TRUE, false );
	$result ['minute'] = get_value_list_time_unit ( $minuteLimit, 10, TRUE, false );
	return $result;

}


function get_date_range_data($max_val, $inc_val, $header = false) {

	$result = array ();
	if ($header)
		$result [""] = "Select";
	for($i = 1; $i <= $max_val; $i = $i + $inc_val) {
		if ($header == 1) {
			$value = "Last $i Days";
		} else {
			$value = $i;
		}
		$result [$i] = $value;
	}
	return $result;

}


function get_dropdown_data($param) {

	$result = array ();
	$data = get_instance ()->config->item ( $param );
	return $data;

}


function get_date_range_interval() {

	$result = array ();
	$time_unit = get_instance ()->config->item ( 'reports_date_range' );
	$result ['unit'] = $time_unit;
	$result ['date_range'] = get_instance ()->config->item ( 'custom_reports_date_range' );
	$result ['date_interval'] = get_instance ()->config->item ( 'custom_reports_interval' );
	return $result;

}


function get_value_list_time_unit($max_val, $inc_val, $header = TRUE, $sttartWithZero = true) {

	$result = array ();
	if ($header == TRUE)
		$result [""] = "";
	for($i = 0; $i <= $max_val; $i = $i + $inc_val) {
		$result [$i] = $i;
	}
	if (! $sttartWithZero) {
		unset ( $result [0] );
	}
	return $result;

}


function dropdown_list($object, $key, $value, $header = '') {

	$list = array (
			'' => $header 
	);
	$i = 0;
	if ($object == null)
		return $list;
	if (isset ( $key )) {
		foreach ( $object as $o ) {
			$list [$o->{$key}] = $o->{$value};
		}
	} else {
		foreach ( $object as $o ) {
			$list [++ $i] = $o->{$value};
		}
	}
	return $list;

}


function bind(&$target) {

	$CI = & get_instance ();
	
	// Iterate through the objects fields
	$target_class = strtolower ( get_class ( $target ) );
	
	foreach ( $target as $key => $value ) {
		$tkey = $target_class . '_' . $key;
		// check if a corresponding POST field exists
		if (array_key_exists ( $tkey, $_POST )) {
			$value = $CI->input->post ( $tkey );
			$target->{$key} = $value;
		}
	}
	
	return $target;

}

/**
 *
 *
 * Returns the error for a specific form field. This is a helper for the
 * custom validation class.
 *
 * @access public
 * @param
 *        	string
 * @return string
 */
if (! function_exists ( 'show_validator_error' )) {


	function show_validator_error($field = '') {

		$CI = & get_instance ();
		$object = $CI->load->validator;
		if (FALSE === $object) {
			return '';
		}
		
		return $object->showError ( $field );
	
	}
}

/**
 *
 *
 * Returns the error for a specific form field. This is a helper for the
 * custom validation class.
 *
 * @access public
 * @param
 *        	string
 * @return string
 */
if (! function_exists ( 'validator_value' )) {


	function validator_value($field = '') {

		$CI = & get_instance ();
		// $object = $CI->load->is_loaded('validator');
		$object = $CI->load->validator;
		if (FALSE === $object) {
			return '';
		}
		// return $object->showValid($field);
		return $object->getValidatorValue ( $field );
	
	}
}

/**
 *
 *
 * Returns the error for a specific form field. This is a helper for the
 * custom validation class.
 *
 * @access public
 * @param
 *        	string
 * @return string
 */
if (! function_exists ( 'validator_error_exist' )) {


	function validator_error_exist() {

		$CI = & get_instance ();
		// $object = $CI->load->is_loaded('validator');
		$object = $CI->load->validator;
		
		if (FALSE === $object) {
			return FALSE;
		}
		
		return $object->numberOfInvalids () > 0 ? TRUE : FALSE;
	
	}
}

if (! function_exists ( 'JS_validator' )) {


	function JS_validator() {

		$CI = & get_instance ();
		// $object = $CI->load->is_loaded('validator');
		$object = $CI->load->validator;
		
		if (FALSE === $object) {
			return FALSE;
		}
		
		return json_encode ( $object->asOption );
	
	}
}

if (! function_exists ( 'javascript_validation' )) {


	function javascript_validation($form_id, $validation_rule, $submitHandler = null) {

		if ($submitHandler === null) {
			$script = '<script>(function ($){$(document).ready(function() {$("#' . $form_id . '").validate(' . $validation_rule . ');});} (jQuery))</script>';
		}else{
			$rule = substr($validation_rule, 0, -1);
			$rule .= ",submitHandler: function(form) {".$submitHandler."}}";
			$script = '<script>(function ($){$(document).ready(function() {$("#' . $form_id . '").validate(' . $rule . ');});} (jQuery))</script>';
		}
		return $script;
	
	}
}

if (! function_exists ( 'javascript_validation_object' )) {


	function javascript_validation_object($validation_id, $validation_rule) {

		$script = '<script> var ' . $validation_id . ' = ' . $validation_rule . ';</script>';
		return $script;
	
	}
}

//
if (! function_exists ( 'get_image_properties' )) {


	function get_image_properties($path = '', $return = FALSE) {

		if ($path == '') {
			return '';
		} else {
			$vals = @getimagesize ( $path );
			$v ['height'] = $vals [1];
			$v ['width'] = $vals [0];
			$v ['h_w_str'] = $vals [3];
			$v ['mime'] = $vals ['mime'];
		}
		return $v;
	
	}
}


function date_picker($name, $value = -1, $enableHour = true) {

	'<div id="' . $name . 'custom_wrap" class="nudge-up>' . '<span id="' . $name . 'datepicker"  class="left">' . '<input class="text_field" type="text" name="' . $name . 'date_picker"/>' . '</span>' . '<input class="text_field" type="text" name="' . $name . '" value=""/>' . '<span class="ss_selectbox">' . form_dropdown ( $name . '_hour', get_value_list_time_unit ( 23, 1 ), array (), 'class="custom-select"' ) . '</span>' . '<span class="wrap-out left">' . lang ( 'strategy.basic.startdate.choose.timezone.caption' ) . '</span>' . '</div>';

}