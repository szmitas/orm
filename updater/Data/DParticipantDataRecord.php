<?php

require_once "_BaseActiveRecords.php";

class DParticipantDataRecord extends D_ParticipantDataBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}