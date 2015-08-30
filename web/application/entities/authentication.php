<?php


/**
 * @author SUJITH
 *
 */

class Authentication extends Entity {

	public $user_id;

	public $email_id;

	public $password;

	public $salt;

	public $hash_code;

	public $status;

	public $user_type;



	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}