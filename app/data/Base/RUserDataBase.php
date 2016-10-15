<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RUserDataBase extends RActiveRecord {

	public $TABLE = "user_datas";

	public $TYPES = array(
		"address" => "text",
		"city" => "text",
		"date_created" => "timestamp with time zone",
		"first_name" => "text",
		"last_name" => "text",
		"user_data_id" => "integer",
		"user_id" => "integer",
		"zip" => "text",
	);

	public $AUTO_INCREMENT = array(
		"user_data_id",
	);

	public $PRIMARY_KEYS = array(
		"user_data_id",
	);

	public $DEFAULT = array(
		"date_created",
		"user_data_id",
	);

	// properties
	public $address;
	public $city;
	public $date_created;
	public $first_name;
	public $last_name;
	public $user_data_id;
	public $user_id;
	public $zip;

	// foreign key objects
	private $_user = null;

	// relationships objects
	private $_documents = null;

	// foreign key methods
	public function getUser() {
	if($this->_user === null) {
		$this->_user = DUser::finder()->findByPK($this->user_id);
	}
	return $this->_user;
	}
	// relationship methods
	public function getDocuments() {
		if($this->_documents === null) {
			$this->_documents = DDocument::finder()->findByUserDataId($this->user_data_id);
		}
		return $this->_documents;
		}

	// others
	public function save() {
		$id = parent::save();
		if($this->user_data_id === null) {
			$this->user_data_id = $id;
		}
		return $id;
	}
}

