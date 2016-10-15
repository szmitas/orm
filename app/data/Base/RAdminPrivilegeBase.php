<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RAdminPrivilegeBase extends RActiveRecord {

	public $TABLE = "admins_privileges";

	public $TYPES = array(
		"admin_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);

	public $AUTO_INCREMENT = array(
	);

	public $PRIMARY_KEYS = array(
	);

	public $DEFAULT = array(
		"date",
		"deleted",
	);

	// properties
	public $admin_id;
	public $date;
	public $deleted;
	public $privilege_id;

	// foreign key objects
	private $_admin = null;
	private $_privilege = null;

	// foreign key methods
	public function getAdmin() {
	if($this->_admin === null) {
		$this->_admin = DAdmin::finder()->findByPK($this->admin_id);
	}
	return $this->_admin;
	}
	public function getPrivilege() {
	if($this->_privilege === null) {
		$this->_privilege = DPrivilege::finder()->findByPK($this->privilege_id);
	}
	return $this->_privilege;
	}
	// others
	public function delete() {
		$this->deleted = time();
		return $this->save();
	}
}

