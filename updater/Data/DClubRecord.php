<?php

require_once "_BaseActiveRecords.php";

class DClubRecord extends D_ClubBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}