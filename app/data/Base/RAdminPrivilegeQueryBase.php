<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RAdminPrivilegeQueryBase extends RActiveQuery {

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
		return self::findOneByColumn("admin_id", $admin_id);
	}

	public function findOneByDate($date) {
		return self::findOneByColumn("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneByColumn("deleted", $deleted);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneByColumn("privilege_id", $privilege_id);
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

}
