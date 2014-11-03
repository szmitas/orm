<?php

require_once "_BaseActiveRecords.php";

class DPostRecord extends D_PostBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}