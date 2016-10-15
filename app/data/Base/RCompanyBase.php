<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RCompanyBase extends RActiveRecord {

	public $TABLE = "companies";

	public $TYPES = array(
		"company_id" => "integer",
		"deleted" => "integer",
		"full_name" => "text",
		"name" => "text",
	);

	public $AUTO_INCREMENT = array(
		"company_id",
	);

	public $PRIMARY_KEYS = array(
		"company_id",
	);

	public $DEFAULT = array(
		"company_id",
		"deleted",
	);

	// properties
	public $company_id;
	public $deleted;
	public $full_name;
	public $name;

	// relationships objects
	private $_admins = null;

	// relationship methods
	public function getAdmins() {
		if($this->_admins === null) {
			$this->_admins = DAdmin::finder()->findByCompanyId($this->company_id);
		}
		return $this->_admins;
		}

	// others
	public function delete() {
		$this->deleted = time();
		return $this->save();
	}
	public function save() {
		$id = parent::save();
		if($this->company_id === null) {
			$this->company_id = $id;
		}
		return $id;
	}
}

