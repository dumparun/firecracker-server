<?php
/**
 * @author SUJITH
 *
 */
class UserResponse extends Entity {

	public $userName;

	public $userEmail;

	public $userMobile;

	public $status;

	public $userImage;

	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}