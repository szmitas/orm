<?php

require_once "_BaseActiveRecords.php";

class DParticipantRecord extends D_ParticipantBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}