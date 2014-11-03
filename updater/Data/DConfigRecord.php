<?php

require_once "_BaseActiveRecords.php";

class DConfigRecord extends D_ConfigBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}