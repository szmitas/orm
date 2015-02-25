<?php

namespace Repel\Framework;

use Repel\Adapter\Generator;

class RActiveRecord {

	public $_record = false;

	public function __construct() {
		
	}

	static public function finder() {
		$className	 = get_called_class();
		$queryClass	 = "{$className}Query";
		return new $queryClass( $className );
	}

	public function save() {
		if ( $this->_record ) {
			return RExecutor::instance( $this )->update();
		} else {
			return RExecutor::instance( $this )->insert();
		}
	}

	public function copy() {
		$class		 = get_called_class();
		$new_object	 = new $class();

		$primary_key = $new_object->PRIMARY_KEYS[0];

		foreach ( $new_object->TYPES as $name => $type ) {
			if ( !in_array( $name, $new_object->PRIMARY_KEYS ) ) {
				$new_object->$name = $this->$name;
			}
		}

		return $new_object;
	}

}
