<?php

require_once "_BaseActiveRecords.php";

class DClassificationRecord extends D_ClassificationBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}