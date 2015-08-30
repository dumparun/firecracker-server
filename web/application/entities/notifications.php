<?php


/**
 * @author RAHUL
 *
 */


class Notifications extends Entity {

	public $notification_id;

	public $sender_id;

	public $message;

	public $receiver_type;

	public $receiver_id;

	





	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}