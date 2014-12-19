<?php

use Repel\Framework\RActiveRecord;
use Repel\Framework\RActiveQuery;

class _BaseActiveRecords {};

class DAdminBase extends RActiveRecord {

	public $TABLE = "admins";

	// properties
	public $admin_id;
	public $company_id;
	public $deleted;
	public $email;
	public $first_name;
	public $last_name;
	public $login;
	public $password;

	public $TYPES = array(
		"admin_id" => "integer",
		"company_id" => "integer",
		"deleted" => "integer",
		"email" => "text",
		"first_name" => "text",
		"last_name" => "text",
		"login" => "text",
		"password" => "text",
	);
	// foreign key objects
	private $_company = null;

	// relationships objects
	private $_privileges = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getPrivileges() {
		if($this->_privileges === null) {
			$admins_privileges = DAdminPrivilege::finder()->findByAdminId($this->admin_id);
			$privileges_pks = array();
			foreach($admins_privileges as $a) {
				$privileges_pks[] = $a->privilege_id;
			}
			$this->_privileges = DPrivilege::finder()->findByPKs($privileges_pks);
			foreach($this->_privileges as $p) {
				foreach($admins_privileges as $a) {
					if($p->privilege_id === $a->privilege_id) {
						$p->setRelationship($a);
						unset($a);
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

class DAdminBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"admin_id" => "integer",
		"company_id" => "integer",
		"deleted" => "integer",
		"email" => "text",
		"first_name" => "text",
		"last_name" => "text",
		"login" => "text",
		"password" => "text",
	);
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
		return self::findOneBy("admin_id", $admin_id);
	}

	public function findOneByCompanyId($company_id) {
		return self::findOneBy("company_id", $company_id);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneBy("deleted", $deleted);
	}

	public function findOneByEmail($email) {
		return self::findOneBy("email", $email);
	}

	public function findOneByFirstName($first_name) {
		return self::findOneBy("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return self::findOneBy("last_name", $last_name);
	}

	public function findOneByLogin($login) {
		return self::findOneBy("login", $login);
	}

	public function findOneByPassword($password) {
		return self::findOneBy("password", $password);
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

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdmin extends DAdminBase {

}



class DAdminQuery extends DAdminBaseQuery {

}

class DAdminPrivilegeBase extends RActiveRecord {

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

class DAdminPrivilegeBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"admin_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);
	public function findByAdminId($admin_id) {
		return self::findByColumn("admin_id", $admin_id);
	}

	public function findByDate($date) {
		return self::findByColumn("date", $date);
	}

	public function findByDeleted($deleted) {
		return self::findByColumn("deleted", $deleted);
	}

	public function findByPrivilegeId($privilege_id) {
		return self::findByColumn("privilege_id", $privilege_id);
	}

	public function findOneByAdminId($admin_id) {
		return self::findOneBy("admin_id", $admin_id);
	}

	public function findOneByDate($date) {
		return self::findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return self::findOneBy("deleted", $deleted);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneBy("privilege_id", $privilege_id);
	}

	public function filterByAdminId($admin_id) {
		return self::filterByColumn("admin_id", $admin_id);
	}

	public function filterByDate($date) {
		return self::filterByColumn("date", $date);
	}

	public function filterByDeleted($deleted) {
		return self::filterByColumn("deleted", $deleted);
	}

	public function filterByPrivilegeId($privilege_id) {
		return self::filterByColumn("privilege_id", $privilege_id);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdminPrivilege extends DAdminPrivilegeBase {

}



class DAdminPrivilegeQuery extends DAdminPrivilegeBaseQuery {

}

class DCompanyBase extends RActiveRecord {

	public $TABLE = "companies";

	// properties
	public $company_id;
	public $deleted;
	public $full_name;
	public $name;

	public $TYPES = array(
		"company_id" => "integer",
		"deleted" => "integer",
		"full_name" => "text",
		"name" => "text",
	);

	// relationships objects
	private $_admins = null;

	// relationship methods
	public function getAdmins() {
		if($this->_admins === null) {
			$this->_admins = DAdmin::finder()->findByCompanyId($this->company_id);
		}
		return $this->_admins;
		}

}

class DCompanyBaseQuery extends RActiveQuery {

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


class DCompany extends DCompanyBase {

}



class DCompanyQuery extends DCompanyBaseQuery {

}

class DDocumentBase extends RActiveRecord {

	public $TABLE = "documents";

	// properties
	public $content;
	public $date;
	public $document_id;
	public $full_number;
	public $user_data_id;

	public $TYPES = array(
		"content" => "text",
		"date" => "timestamp with time zone",
		"document_id" => "integer",
		"full_number" => "text",
		"user_data_id" => "integer",
	);
	// foreign key objects
	private $_user_data = null;


}

class DDocumentBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"content" => "text",
		"date" => "timestamp with time zone",
		"document_id" => "integer",
		"full_number" => "text",
		"user_data_id" => "integer",
	);
	public function findByContent($content) {
		return self::findByColumn("content", $content);
	}

	public function findByDate($date) {
		return self::findByColumn("date", $date);
	}

	public function findByDocumentId($document_id) {
		return self::findByColumn("document_id", $document_id);
	}

	public function findByFullNumber($full_number) {
		return self::findByColumn("full_number", $full_number);
	}

	public function findByUserDataId($user_data_id) {
		return self::findByColumn("user_data_id", $user_data_id);
	}

	public function findOneByContent($content) {
		return self::findOneBy("content", $content);
	}

	public function findOneByDate($date) {
		return self::findOneBy("date", $date);
	}

	public function findOneByDocumentId($document_id) {
		return self::findOneBy("document_id", $document_id);
	}

	public function findOneByFullNumber($full_number) {
		return self::findOneBy("full_number", $full_number);
	}

	public function findOneByUserDataId($user_data_id) {
		return self::findOneBy("user_data_id", $user_data_id);
	}

	public function filterByContent($content) {
		return self::filterByColumn("content", $content);
	}

	public function filterByDate($date) {
		return self::filterByColumn("date", $date);
	}

	public function filterByDocumentId($document_id) {
		return self::filterByColumn("document_id", $document_id);
	}

	public function filterByFullNumber($full_number) {
		return self::filterByColumn("full_number", $full_number);
	}

	public function filterByUserDataId($user_data_id) {
		return self::filterByColumn("user_data_id", $user_data_id);
	}

	// others
}


class DDocument extends DDocumentBase {

}



class DDocumentQuery extends DDocumentBaseQuery {

}

class DPrivilegeBase extends RActiveRecord {

	public $TABLE = "privileges";

	// properties
	public $description;
	public $name;
	public $privilege_id;

	public $TYPES = array(
		"description" => "text",
		"name" => "text",
		"privilege_id" => "integer",
	);

	// relationships objects
	private $_admins = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getAdmins() {
		if($this->_admins === null) {
			$admins_privileges = DAdminPrivilege::finder()->findByPrivilegeId($this->privilege_id);
			$admins_pks = array();
			foreach($admins_privileges as $a) {
				$admins_pks[] = $a->admin_id;
			}
			$this->_admins = DAdmin::finder()->findByPKs($admins_pks);
			foreach($this->_admins as $a) {
				foreach($admins_privileges as $a) {
					if($a->admin_id === $a->admin_id) {
						$a->setRelationship($a);
						unset($a);
						break;
					}
				}
			}
		}
		return $this->_admins;
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
		return self::findOneBy("description", $description);
	}

	public function findOneByName($name) {
		return self::findOneBy("name", $name);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return self::findOneBy("privilege_id", $privilege_id);
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


class DPrivilege extends DPrivilegeBase {

}



class DPrivilegeQuery extends DPrivilegeBaseQuery {

}

class DUserDataBase extends RActiveRecord {

	public $TABLE = "user_datas";

	// properties
	public $active;
	public $address;
	public $city;
	public $date_created;
	public $first_name;
	public $last_name;
	public $user_data_id;
	public $user_id;
	public $zip;

	public $TYPES = array(
		"active" => "integer",
		"address" => "text",
		"city" => "text",
		"date_created" => "timestamp with time zone",
		"first_name" => "text",
		"last_name" => "text",
		"user_data_id" => "integer",
		"user_id" => "integer",
		"zip" => "text",
	);
	// foreign key objects
	private $_user = null;

	// relationships objects
	private $_documents = null;

	// relationship methods
	public function getDocuments() {
		if($this->_documents === null) {
			$this->_documents = DDocument::finder()->findByUserDataId($this->user_data_id);
		}
		return $this->_documents;
		}

}

class DUserDataBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"active" => "integer",
		"address" => "text",
		"city" => "text",
		"date_created" => "timestamp with time zone",
		"first_name" => "text",
		"last_name" => "text",
		"user_data_id" => "integer",
		"user_id" => "integer",
		"zip" => "text",
	);
	public function findByActive($active) {
		return self::findByColumn("active", $active);
	}

	public function findByAddress($address) {
		return self::findByColumn("address", $address);
	}

	public function findByCity($city) {
		return self::findByColumn("city", $city);
	}

	public function findByDateCreated($date_created) {
		return self::findByColumn("date_created", $date_created);
	}

	public function findByFirstName($first_name) {
		return self::findByColumn("first_name", $first_name);
	}

	public function findByLastName($last_name) {
		return self::findByColumn("last_name", $last_name);
	}

	public function findByUserDataId($user_data_id) {
		return self::findByColumn("user_data_id", $user_data_id);
	}

	public function findByUserId($user_id) {
		return self::findByColumn("user_id", $user_id);
	}

	public function findByZip($zip) {
		return self::findByColumn("zip", $zip);
	}

	public function findOneByActive($active) {
		return self::findOneBy("active", $active);
	}

	public function findOneByAddress($address) {
		return self::findOneBy("address", $address);
	}

	public function findOneByCity($city) {
		return self::findOneBy("city", $city);
	}

	public function findOneByDateCreated($date_created) {
		return self::findOneBy("date_created", $date_created);
	}

	public function findOneByFirstName($first_name) {
		return self::findOneBy("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return self::findOneBy("last_name", $last_name);
	}

	public function findOneByUserDataId($user_data_id) {
		return self::findOneBy("user_data_id", $user_data_id);
	}

	public function findOneByUserId($user_id) {
		return self::findOneBy("user_id", $user_id);
	}

	public function findOneByZip($zip) {
		return self::findOneBy("zip", $zip);
	}

	public function filterByActive($active) {
		return self::filterByColumn("active", $active);
	}

	public function filterByAddress($address) {
		return self::filterByColumn("address", $address);
	}

	public function filterByCity($city) {
		return self::filterByColumn("city", $city);
	}

	public function filterByDateCreated($date_created) {
		return self::filterByColumn("date_created", $date_created);
	}

	public function filterByFirstName($first_name) {
		return self::filterByColumn("first_name", $first_name);
	}

	public function filterByLastName($last_name) {
		return self::filterByColumn("last_name", $last_name);
	}

	public function filterByUserDataId($user_data_id) {
		return self::filterByColumn("user_data_id", $user_data_id);
	}

	public function filterByUserId($user_id) {
		return self::filterByColumn("user_id", $user_id);
	}

	public function filterByZip($zip) {
		return self::filterByColumn("zip", $zip);
	}

	// others
}


class DUserData extends DUserDataBase {

}



class DUserDataQuery extends DUserDataBaseQuery {

}

class DUserBase extends RActiveRecord {

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

class DUserBaseQuery extends RActiveQuery {

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


class DUser extends DUserBase {

}



class DUserQuery extends DUserBaseQuery {

}

