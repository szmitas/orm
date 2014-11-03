<?php

require_once "_BaseActiveRecords.php";

class DEventRecord extends D_EventBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}