<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RUserQueryBase extends RActiveQuery {

	public function findByDateCreated($date_created) {
		return self::findByColumn("date_created", $date_created);
	}

	public function findByDeleted($deleted) {
		return self::findByColumn("deleted", $deleted);
	}

	public function findByLogin($login) {
		return self::findByColumn("login", $login);
	}

	public function findByPassword($password) {
		return self::findByColumn("password", $password);
	}

	public function findByUserId($user_id) {
		return self::findByColumn("user_id", $user_id);
	}

	public function findOneByDateCreated($date_created) {
		return self::findOneByColumn("date_created", $date_created);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneByColumn("deleted", $deleted);
	}

	public function findOneByLogin($login) {
		return self::findOneByColumn("login", $login);
	}

	public function findOneByPassword($password) {
		return self::findOneByColumn("password", $password);
	}

	public function findOneByUserId($user_id) {
		return self::findOneByColumn("user_id", $user_id);
	}

	public function filterByDateCreated($date_created) {
		return self::filterByColumn("date_created", $date_created);
	}

	public function filterByDeleted($deleted) {
		return self::filterByColumn("deleted", $deleted);
	}

	public function filterByLogin($login) {
		return self::filterByColumn("login", $login);
	}

	public function filterByPassword($password) {
		return self::filterByColumn("password", $password);
	}

	public function filterByUserId($user_id) {
		return self::filterByColumn("user_id", $user_id);
	}

}
