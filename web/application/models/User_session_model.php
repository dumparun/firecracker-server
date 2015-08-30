<?php


/**
 * @author SIJIN L JOSE
 *
 */
class User_session_Model extends MY_Model {

	public $_table = 'user_session';

	public $primary_key = 'user_id';


	public $belongs_to = array (
			'user' => array (
					'model' => 'Auth_model',
					'primary_key' => 'user_id'
			),

	);



	function __construct() {

		parent::__construct ();

	}


	public function addSessionKeyForUser($userId,$sessionKey) {
		$data = array (
				'user_id' => $userId,
				'session_key' => $sessionKey,
				'registration_time' => date('Y-m-d H:i:s')

		);

		return parent::insert ( $data, false );
	}


	public function getCountOfUserWithKey($key){

		return parent::count_by ('session_key ',$key);

	}


	public function fetchwithSessionKey($key){

		return parent::with('user')->get_by ('session_key ',$key);

	}


	public function fetchSessionKeyWithUserId($userId){

		return parent::get_by ('user_id ',$userId);

	}



}