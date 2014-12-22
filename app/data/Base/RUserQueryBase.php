<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RUserQueryBase extends RActiveQuery {

	public $TYPES = array(
		"date_created" => "timestamp with time zone",
		"deleted" => "integer",
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);
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
		return self::findOneBy("date_created", $date_created);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneBy("deleted", $deleted);
	}

	public function findOneByLogin($login) {
		return self::findOneBy("login", $login);
	}

	public function findOneByPassword($password) {
		return self::findOneBy("password", $password);
	}

	public function findOneByUserId($user_id) {
		return self::findOneBy("user_id", $user_id);
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

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}
