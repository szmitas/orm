<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RUserdataBase extends RActiveRecord {

	public $TABLE = "user_datas";

	// properties
	public $address;
	public $city;
	public $date_created;
	public $first_name;
	public $last_name;
	public $user_data_id;
	public $user_id;
	public $zip;

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
	// foreign key objects
	private $_company = null;
	private $_admin = null;
	private $_privilege = null;
	private $_user_data = null;
	private $_user = null;

	// relationships objects
	private $_documents = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getDocuments() {
		if($this->_documents === null) {
			$this->_documents = DDocument::finder()->findByUserDataId($this->user_data_id);
		}
		return $this->_documents;
		}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
}

