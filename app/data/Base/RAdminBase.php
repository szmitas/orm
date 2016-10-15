<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RAdminBase extends RActiveRecord {

	public $TABLE = "admins";

	public $TYPES = array(
		"admin_id" => "integer",
		"company_id" => "integer",
		"deleted" => "integer",
		"email" => "text",
		"first_name" => "text",
		"last_name" => "text",
		"login" => "text",
		"password" => "text",
	);

	public $AUTO_INCREMENT = array(
		"admin_id",
	);

	public $PRIMARY_KEYS = array(
		"admin_id",
	);

	public $DEFAULT = array(
		"admin_id",
		"deleted",
	);

	// properties
	public $admin_id;
	public $company_id;
	public $deleted;
	public $email;
	public $first_name;
	public $last_name;
	public $login;
	public $password;

	// foreign key objects
	private $_company = null;

	// relationships objects
	private $_privileges = null;
	// relationship object
	private $_relationship = null;

	// foreign key methods
	public function getCompany() {
	if($this->_company === null) {
		$this->_company = DCompany::finder()->findByPK($this->company_id);
	}
	return $this->_company;
	}
	// relationship methods
	public function getPrivileges() {
		if($this->_privileges === null) {
			$admins_privileges = DAdminPrivilege::finder()->findByAdminId($this->admin_id);
			$privileges_pks = array();
			foreach($admins_privileges as $a) {
				$privileges_pks[] = $a->privilege_id;
			}
			$this->_privileges = DPrivilege::finder()->findByPKs($privileges_pks);
			foreach($this->_privileges as $p) {
				foreach($admins_privileges as $a) {
					if($p->privilege_id === $a->privilege_id) {
						$p->setRelationship($a);
						unset($a);
						break;
					}
				}
			}
		}
		return $this->_privileges;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
	// others
	public function delete() {
		$this->deleted = time();
		return $this->save();
	}
	public function save() {
		$id = parent::save();
		if($this->admin_id === null) {
			$this->admin_id = $id;
		}
		return $id;
	}
}

