<?php

require_once "_BaseActiveRecords.php";

class DMediaRecord extends D_MediaBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}