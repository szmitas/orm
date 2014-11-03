<?php

require_once "_BaseActiveRecords.php";

class DAgeCategorieRecord extends D_AgeCategorieBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}