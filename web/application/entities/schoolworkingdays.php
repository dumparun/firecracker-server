<?php


/**
 * @author SUJITH
 *
 */

class schoolWorkingDays extends Entity {

	public $user_id;

	public $monday;

	public $tuesday;

	public $wednesday;

	public $thursday;

	public $friday;

	public $saturday;

	public $sunday;

	public function __construct($entity = false) {

		parent::__construct ( $entity );

	}

}