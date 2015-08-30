<?php


/**
 *
 * @author Maganiva
 *
 */
class Entity {


	public function __construct($entity = false) {
		if ($entity)
			$this->set ( $entity );
	}


	public function set($entity) {

		foreach ( $entity as $key => $value ) {
			if (is_object ( $value )) {
				$sub = (class_exists ( $key )) ? new $key () : new Entity ();
				$sub->set ( $value );
				$value = $sub;
			} else if (is_array ( $value )) {
				$sub = (class_exists ( $key )) ? new $key () : new Entity ();
				$sub->set ( $value );
			}
			$this->{$key} = $value;
		}
	}
}
