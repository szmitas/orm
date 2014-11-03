<?php

require_once "_BaseActiveRecords.php";

class DConfigHistoryRecord extends D_ConfigHistoryBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}