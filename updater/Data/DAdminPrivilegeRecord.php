<?php

require_once "_BaseActiveRecords.php";

class DAdminPrivilegeRecord extends D_AdminPrivilegeBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}