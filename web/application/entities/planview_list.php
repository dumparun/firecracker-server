<?php

/**
 * @author Arun
 *
 */
class PlanViewList extends Entity {

	public $category;
	
	public $plannedAmount;
	
	public $expenditure;
	
	public function __construct($entity = false) {

		parent::__construct ( $entity );
	
	}

}