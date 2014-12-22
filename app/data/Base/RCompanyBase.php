<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RCompanyBase extends RActiveRecord {

	public $TABLE = "companies";

	// properties
	public $company_id;
	public $deleted;
	public $full_name;
	public $name;

	public $TYPES = array(
		"company_id" => "integer",
		"deleted" => "integer",
		"full_name" => "text",
		"name" => "text",
	);
	// foreign key objects
	private $_company = null;
	private $_admin = null;
	private $_privilege = null;

	// relationships objects
	private $_admins = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getAdmins() {
		if($this->_admins === null) {
			$this->_admins = DAdmin::finder()->findByCompanyId($this->company_id);
		}
		return $this->_admins;
		}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
}

