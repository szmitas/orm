<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RPrivilegeQueryBase extends RActiveQuery {

	public $TYPES = array(
		"description" => "text",
		"name" => "text",
		"privilege_id" => "integer",
	);
	public function findByDescription($description) {
		return self::findByColumn("description", $description);
	}

	public function findByName($name) {
		return self::findByColumn("name", $name);
	}

	public function findByPrivilegeId($privilege_id) {
		return self::findByColumn("privilege_id", $privilege_id);
	}

	public function findOneByDescription($description) {
		return self::findOneByColumn("description", $description);
	}

	public function findOneByName($name) {
		return self::findOneByColumn("name", $name);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneByColumn("privilege_id", $privilege_id);
	}

	public function filterByDescription($description) {
		return self::filterByColumn("description", $description);
	}

	public function filterByName($name) {
		return self::filterByColumn("name", $name);
	}

	public function filterByPrivilegeId($privilege_id) {
		return self::filterByColumn("privilege_id", $privilege_id);
	}

	// others
}
