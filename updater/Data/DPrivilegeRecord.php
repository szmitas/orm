<?php

require_once "_BaseActiveRecords.php";

class DPrivilegeRecord extends D_PrivilegeBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}