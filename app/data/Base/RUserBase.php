<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RUserBase extends RActiveRecord {

	public $TABLE = "users";

	// properties
	public $date_created;
	public $deleted;
	public $login;
	public $password;
	public $user_id;

	public $TYPES = array(
		"date_created" => "timestamp with time zone",
		"deleted" => "integer",
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);

	// relationships objects
	private $_user_datas = null;

	// relationship methods
	public function getUserDatas() {
		if($this->_user_datas === null) {
			$this->_user_datas = DUserData::finder()->findByUserId($this->user_id);
		}
		return $this->_user_datas;
		}

}

