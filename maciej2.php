<?php
class _BaseActiveRecords {};

class DPrivilegeBase extends RActiveRecord {

	public $TABLE = "privileges";

	// properties
	public $name;
	public $privilege_id;

	public $TYPES = array(
		"name" => "text",
		"privilege_id" => "integer",
	);

	// relationships objects
	private $_users = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getUsers() {
		if($this->_users === null) {
			$users_privileges = DUserPrivilege::finder()->findByPrivilegeId($this->privilege_id);
			$users_pks = array();
			foreach($users_privileges as $u) {
				$users_pks[] = $u->user_id;
			}
			$this->_users = DUser::finder()->findByPKs($users_pks);
			foreach($this->_users as $u) {
				foreach($users_privileges as $u) {
					if($u->user_id === $u->user_id) {
						$u->setRelationship($u);
						unset($u);
						break;
					}
				}
			}
		}
		return $this->_users;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
}

class DPrivilegeBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"name" => "text",
		"privilege_id" => "integer",
	);
	public function findByName($name) {
		return self::findByColumn("name", $name);
	}

	public function findByPrivilegeId($privilege_id) {
		return self::findByColumn("privilege_id", $privilege_id);
	}

	public function findOneByName($name) {
		return self::findOneBy("name", $name);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneBy("privilege_id", $privilege_id);
	}

	public function filterByName($name) {
		return self::filterByColumn("name", $name);
	}

	public function filterByPrivilegeId($privilege_id) {
		return self::filterByColumn("privilege_id", $privilege_id);
	}

	// others
}


class DPrivilege extends DPrivilegeBase {

	public function save() {
		return parent::save();
	}

}



class DPrivilegeQuery extends DPrivilegeBaseQuery {

}

class DUserBase extends RActiveRecord {

	public $TABLE = "users";

	// properties
	public $login;
	public $password;
	public $user_id;

	public $TYPES = array(
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);

	// relationships objects
	private $_privileges = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getPrivileges() {
		if($this->_privileges === null) {
			$users_privileges = DUserPrivilege::finder()->findByUserId($this->user_id);
			$privileges_pks = array();
			foreach($users_privileges as $u) {
				$privileges_pks[] = $u->privilege_id;
			}
			$this->_privileges = DPrivilege::finder()->findByPKs($privileges_pks);
			foreach($this->_privileges as $p) {
				foreach($users_privileges as $u) {
					if($p->privilege_id === $u->privilege_id) {
						$p->setRelationship($u);
						unset($u);
						break;
					}
				}
			}
		}
		return $this->_privileges;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}
}

class DUserBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);
	public function findByLogin($login) {
		return self::findByColumn("login", $login);
	}

	public function findByPassword($password) {
		return self::findByColumn("password", $password);
	}

	public function findByUserId($user_id) {
		return self::findByColumn("user_id", $user_id);
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
}


class DUser extends DUserBase {

	public function save() {
		return parent::save();
	}

}



class DUserQuery extends DUserBaseQuery {

}

class DUserPrivilegeBase extends RActiveRecord {

	public $TABLE = "users_privileges";

	// properties
	public $description;
	public $privilege_id;
	public $user_id;

	public $TYPES = array(
		"description" => "text",
		"privilege_id" => "integer",
		"user_id" => "integer",
	);
	// foreign key objects
	private $_privilege = null;
	private $_user = null;


}

class DUserPrivilegeBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"description" => "text",
		"privilege_id" => "integer",
		"user_id" => "integer",
	);
	public function findByDescription($description) {
		return self::findByColumn("description", $description);
	}

	public function findByPrivilegeId($privilege_id) {
		return self::findByColumn("privilege_id", $privilege_id);
	}

	public function findByUserId($user_id) {
		return self::findByColumn("user_id", $user_id);
	}

	public function findOneByDescription($description) {
		return self::findOneBy("description", $description);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneBy("privilege_id", $privilege_id);
	}

	public function findOneByUserId($user_id) {
		return self::findOneBy("user_id", $user_id);
	}

	public function filterByDescription($description) {
		return self::filterByColumn("description", $description);
	}

	public function filterByPrivilegeId($privilege_id) {
		return self::filterByColumn("privilege_id", $privilege_id);
	}

	public function filterByUserId($user_id) {
		return self::filterByColumn("user_id", $user_id);
	}

	// others
}


class DUserPrivilege extends DUserPrivilegeBase {

	public function save() {
		return parent::save();
	}

}



class DUserPrivilegeQuery extends DUserPrivilegeBaseQuery {

}

