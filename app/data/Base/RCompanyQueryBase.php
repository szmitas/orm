<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RCompanyQueryBase extends RActiveQuery {

	public $TYPES = array(
		"company_id" => "integer",
		"deleted" => "integer",
		"full_name" => "text",
		"name" => "text",
	);
	public function findByCompanyId($company_id) {
		return self::findByColumn("company_id", $company_id);
	}

	public function findByDeleted($deleted) {
		return self::findByColumn("deleted", $deleted);
	}

	public function findByFullName($full_name) {
		return self::findByColumn("full_name", $full_name);
	}

	public function findByName($name) {
		return self::findByColumn("name", $name);
	}

	public function findOneByCompanyId($company_id) {
		return self::findOneBy("company_id", $company_id);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneBy("deleted", $deleted);
	}

	public function findOneByFullName($full_name) {
		return self::findOneBy("full_name", $full_name);
	}

	public function findOneByName($name) {
		return self::findOneBy("name", $name);
	}

	public function filterByCompanyId($company_id) {
		return self::filterByColumn("company_id", $company_id);
	}

	public function filterByDeleted($deleted) {
		return self::filterByColumn("deleted", $deleted);
	}

	public function filterByFullName($full_name) {
		return self::filterByColumn("full_name", $full_name);
	}

	public function filterByName($name) {
		return self::filterByColumn("name", $name);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}
