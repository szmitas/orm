<?php

require_once "_BaseActiveRecords.php";

class DPostListViewRecord extends D_PostListViewBaseRecord {
	
	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}