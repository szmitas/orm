<?php

require_once "_BaseActiveRecords.php";

class DParticipantClassificationRecord extends D_ParticipantClassificationBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}