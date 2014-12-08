<?php
namespace Repel\Framework;
class FComponent {
	
	public function __set( $name, $value ) {
		$name		 = strtolower( $name );
		$this->$name = $value;
	}

	public function &__get( $name ) {
		$name = strtolower( $name );
		return $this->$name;
	}

}
