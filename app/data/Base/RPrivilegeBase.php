<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RPrivilegeBase extends RActiveRecord {

	public $TABLE = "privileges";

	public $TYPES = array(
		"description" => "text",
		"name" => "text",
		"privilege_id" => "integer",
	);

	public $AUTO_INCREMENT = array(
		"privilege_id",
	);

	public $PRIMARY_KEYS = array(
		"privilege_id",
	);

	public $DEFAULT = array(
		"privilege_id",
	);

	// properties
	public $description;
	public $name;
	public $privilege_id;

	// relationships objects
	private $_admins = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getAdmins() {
		if($this->_admins === null) {
			$admins_privileges = DAdminPrivilege::finder()->findByPrivilegeId($this->privilege_id);
			$admins_pks = array();
			foreach($admins_privileges as $a) {
				$admins_pks[] = $a->admin_id;
			}
			$this->_admins = DAdmin::finder()->findByPKs($admins_pks);
			foreach($this->_admins as $a) {
				foreach($admins_privileges as $a) {
					if($a->admin_id === $a->admin_id) {
						$a->setRelationship($a);
						unset($a);
						break;
					}
				}
			}
		}
		return $this->_admins;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
	// others
	public function save() {
		$id = parent::save();
		if($this->privilege_id === null) {
			$this->privilege_id = $id;
		}
		return $id;
	}
}

