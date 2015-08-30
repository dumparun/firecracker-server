<?php


/**
 * @author Maganiva
 *
 */
class Auth_Model extends MY_Model {

	public $_table = 'auth';

	public $primary_key = 'user_id';


	function __construct() {

		parent::__construct ();

	}

	public function registerUser($user){

		$data = array(

				'email_id' => $user->email_id,

				'password' =>$user->password,

				'salt' => $user->salt,

				"hash_code" => $user->hash_code,

				'user_type' =>$user->user_type,

				'status' =>$user->status,


		);

		return parent::insert ( $data, false );

	}

	public function updateUser($user) {

		$data = array (

				'email_id' => $user->email_id,

				'password' =>$user->password,

				'salt' => $user->salt,

				"hash_code" => $user->hash_code,

				'user_type' =>$user->user_type,

				'status' =>$user->status,
		);

		return parent::update ( $user->user_id, $data, false );

	}



	public function getUserWithEmail($emailId) {

		$condition = array (
				"email_id" => $emailId,
		);

		return parent::get_by ( $condition );

	}

	public function getUserWithID($userID) {

		return parent::get ( $userID );

	}

	public function changeUserStatus($userID,$status) {

		$key = array (
				"status" => $status,
		);


		return parent::update ( $userID,$key, false);

	}

	public function getCountOfSchools($status = null){


		if($status === null){
			$key = array (
					"user_type" => 1,
			);
		}else{
			$key = array (
					"user_type" => 1,
					"status" => $status
			);
		}

		return parent::count_by ( $key);

	}
	public function getCountOfFaculty($status = null){


		if($status === null){
			$key = array (
					"user_type" => 2,
			);
		}else{
			$key = array (
					"user_type" => 2,
					"status" => $status
			);
		}

		return parent::count_by ( $key);

	}
	public function getCountOfStudents($status = null){


		if($status === null){
			$key = array (
					"user_type" => 3,
			);
		}else{
			$key = array (
					"user_type" => 3,
					"status" => $status
			);
		}

		return parent::count_by ( $key);

	}
	public function fetchFieldDetails(){
		return $this->_database->list_fields('`auth`');
	}


}