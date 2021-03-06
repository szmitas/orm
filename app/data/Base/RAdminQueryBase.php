<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RAdminQueryBase extends RActiveQuery {

	public function findByAdminId($admin_id) {
		return self::findByColumn("admin_id", $admin_id);
	}

	public function findByCompanyId($company_id) {
		return self::findByColumn("company_id", $company_id);
	}

	public function findByDeleted($deleted) {
		return self::findByColumn("deleted", $deleted);
	}

	public function findByEmail($email) {
		return self::findByColumn("email", $email);
	}

	public function findByFirstName($first_name) {
		return self::findByColumn("first_name", $first_name);
	}

	public function findByLastName($last_name) {
		return self::findByColumn("last_name", $last_name);
	}

	public function findByLogin($login) {
		return self::findByColumn("login", $login);
	}

	public function findByPassword($password) {
		return self::findByColumn("password", $password);
	}

	public function findOneByAdminId($admin_id) {
		return self::findOneByColumn("admin_id", $admin_id);
	}

	public function findOneByCompanyId($company_id) {
		return self::findOneByColumn("company_id", $company_id);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneByColumn("deleted", $deleted);
	}

	public function findOneByEmail($email) {
		return self::findOneByColumn("email", $email);
	}

	public function findOneByFirstName($first_name) {
		return self::findOneByColumn("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return self::findOneByColumn("last_name", $last_name);
	}

	public function findOneByLogin($login) {
		return self::findOneByColumn("login", $login);
	}

	public function findOneByPassword($password) {
		return self::findOneByColumn("password", $password);
	}

	public function filterByAdminId($admin_id) {
		return self::filterByColumn("admin_id", $admin_id);
	}

	public function filterByCompanyId($company_id) {
		return self::filterByColumn("company_id", $company_id);
	}

	public function filterByDeleted($deleted) {
		return self::filterByColumn("deleted", $deleted);
	}

	public function filterByEmail($email) {
		return self::filterByColumn("email", $email);
	}

	public function filterByFirstName($first_name) {
		return self::filterByColumn("first_name", $first_name);
	}

	public function filterByLastName($last_name) {
		return self::filterByColumn("last_name", $last_name);
	}

	public function filterByLogin($login) {
		return self::filterByColumn("login", $login);
	}

	public function filterByPassword($password) {
		return self::filterByColumn("password", $password);
	}

}
