<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RUserBase extends RActiveRecord {

	public $TABLE = "users";

	public $TYPES = array(
		"date_created" => "timestamp with time zone",
		"deleted" => "integer",
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);

	public $AUTO_INCREMENT = array(
		"user_id",
	);

	public $PRIMARY_KEYS = array(
		"user_id",
	);

	public $DEFAULT = array(
		"date_created",
		"deleted",
		"user_id",
	);

	// properties
	public $date_created;
	public $deleted;
	public $login;
	public $password;
	public $user_id;

	// relationships objects
	private $_user_datas = null;

	// relationship methods
	public function getUserDatas() {
		if($this->_user_datas === null) {
			$this->_user_datas = DUserData::finder()->findByUserId($this->user_id);
		}
		return $this->_user_datas;
		}

	// others
	public function delete() {
		$this->deleted = time();
		return $this->save();
	}
	public function save() {
		$id = parent::save();
		if($this->user_id === null) {
			$this->user_id = $id;
		}
		return $id;
	}
}

