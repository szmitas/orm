<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RDocumentBase extends RActiveRecord {

	public $TABLE = "documents";

	public $TYPES = array(
		"content" => "text",
		"date" => "timestamp with time zone",
		"document_id" => "integer",
		"full_number" => "text",
		"user_data_id" => "integer",
	);

	public $AUTO_INCREMENT = array(
		"document_id",
	);

	public $PRIMARY_KEYS = array(
		"document_id",
	);

	public $DEFAULT = array(
		"date",
		"document_id",
	);

	// properties
	public $content;
	public $date;
	public $document_id;
	public $full_number;
	public $user_data_id;

	// foreign key objects
	private $_user_data = null;

	// foreign key methods
	public function getUserData() {
	if($this->_user_data === null) {
		$this->_user_data = DUserData::finder()->findByPK($this->user_data_id);
	}
	return $this->_user_data;
	}
	// others
	public function save() {
		$id = parent::save();
		if($this->document_id === null) {
			$this->document_id = $id;
		}
		return $id;
	}
}

