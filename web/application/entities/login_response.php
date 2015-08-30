<?php

/**
 * @author Maganiva
 *
 */
class LoginResponse extends Entity {

	public $sessionKey;

	public $status;

	public $userId;

	public $studentsList;

	public $email_id;

	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}