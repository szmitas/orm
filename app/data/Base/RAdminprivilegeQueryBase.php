<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RAdminprivilegeQueryBase extends RActiveQuery {

	public $TYPES = array(
		"admin_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);
	public function findByAdminId($admin_id) {
		return self::findByColumn("admin_id", $admin_id);
	}

	public function findByDate($date) {
		return self::findByColumn("date", $date);
	}

	public function findByDeleted($deleted) {
		return self::findByColumn("deleted", $deleted);
	}

	public function findByPrivilegeId($privilege_id) {
		return self::findByColumn("privilege_id", $privilege_id);
	}

	public function findOneByAdminId($admin_id) {
		return self::findOneBy("admin_id", $admin_id);
	}

	public function findOneByDate($date) {
		return self::findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneBy("deleted", $deleted);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneBy("privilege_id", $privilege_id);
	}

	public function filterByAdminId($admin_id) {
		return self::filterByColumn("admin_id", $admin_id);
	}

	public function filterByDate($date) {
		return self::filterByColumn("date", $date);
	}

	public function filterByDeleted($deleted) {
		return self::filterByColumn("deleted", $deleted);
	}

	public function filterByPrivilegeId($privilege_id) {
		return self::filterByColumn("privilege_id", $privilege_id);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}
