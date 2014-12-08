<?php
class _BaseActiveRecords {};

class DPrivilegeBase extends FActiveRecord {

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

class DPrivilegeBaseQuery extends FActiveQuery {

	public $TYPES = array(
		"name" => "text",
		"privilege_id" => "integer",
	);
	public function findByName($name) {
		return DPrivilege::finder()->find("name = :name", array(":name" => $name));
	}

	public function findByPrivilegeId($privilege_id) {
		return DPrivilege::finder()->find("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function findByPrivilegeIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DPrivilege::finder()->find("privilege_id IN ({$in_values})", $parameters);
	}

	public function findOneByName($name) {
		return DPrivilege::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DPrivilege::finder()->findOne("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function filterByName($name) {
	}

	public function filterByPrivilegeId($privilege_id) {
	}

	public function filterByPrivilegeIds(array $ids) {
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

class DUserBase extends FActiveRecord {

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

class DUserBaseQuery extends FActiveQuery {

	public $TYPES = array(
		"login" => "text",
		"password" => "text",
		"user_id" => "integer",
	);
	public function findByLogin($login) {
		return DUser::finder()->find("login = :login", array(":login" => $login));
	}

	public function findByPassword($password) {
		return DUser::finder()->find("password = :password", array(":password" => $password));
	}

	public function findByUserId($user_id) {
		return DUser::finder()->find("user_id = :user_id", array(":user_id" => $user_id));
	}

	public function findByUserIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DUser::finder()->find("user_id IN ({$in_values})", $parameters);
	}

	public function findOneByLogin($login) {
		return DUser::finder()->findOne("login = :login", array(":login" => $login));
	}

	public function findOneByPassword($password) {
		return DUser::finder()->findOne("password = :password", array(":password" => $password));
	}

	public function findOneByUserId($user_id) {
		return DUser::finder()->findOne("user_id = :user_id", array(":user_id" => $user_id));
	}

	public function filterByLogin($login) {
	}

	public function filterByPassword($password) {
	}

	public function filterByUserId($user_id) {
	}

	public function filterByUserIds(array $ids) {
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

class DUserPrivilegeBase extends FActiveRecord {

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

class DUserPrivilegeBaseQuery extends FActiveQuery {

	public $TYPES = array(
		"description" => "text",
		"privilege_id" => "integer",
		"user_id" => "integer",
	);
	public function findByDescription($description) {
		return DUserPrivilege::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByPrivilegeId($privilege_id) {
		return DUserPrivilege::finder()->find("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function findByPrivilegeIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DUserPrivilege::finder()->find("privilege_id IN ({$in_values})", $parameters);
	}

	public function findByUserId($user_id) {
		return DUserPrivilege::finder()->find("user_id = :user_id", array(":user_id" => $user_id));
	}

	public function findByUserIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DUserPrivilege::finder()->find("user_id IN ({$in_values})", $parameters);
	}

	public function findOneByDescription($description) {
		return DUserPrivilege::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DUserPrivilege::finder()->findOne("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function findOneByUserId($user_id) {
		return DUserPrivilege::finder()->findOne("user_id = :user_id", array(":user_id" => $user_id));
	}

	public function filterByDescription($description) {
	}

	public function filterByPrivilegeId($privilege_id) {
	}

	public function filterByPrivilegeIds(array $ids) {
	}

	public function filterByUserId($user_id) {
	}

	public function filterByUserIds(array $ids) {
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

