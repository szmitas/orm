<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RAdminPrivilegeBase extends RActiveRecord {

	public $TABLE = "admins_privileges";

	// properties
	public $admin_id;
	public $date;
	public $deleted;
	public $privilege_id;

	public $TYPES = array(
		"admin_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);
	// foreign key objects
	private $_admin = null;
	private $_privilege = null;


}

