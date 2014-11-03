<?php

require_once "_BaseActiveRecords.php";

class DAdminRecord extends D_AdminBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}