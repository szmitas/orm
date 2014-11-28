<?php
class _BaseActiveRecords {};

class DAdminBaseRecord extends FActiveRecord {

	public $TABLE = "admins";

	// properties
	public $admin_id;
	public $deleted;
	public $email;
	public $login;

	public $TYPES = array(
		"admin_id" => "integer",
		"deleted" => "integer",
		"email" => "text",
		"login" => "text",
	);

	// relationships objects
	private $_events = null;
	private $_posts = null;
	private $_privileges = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByAdminId($this->admin_id);
		}
		return $this->_events;
		}

	public function getPosts() {
		if($this->_posts === null) {
			$this->_posts = DPostRecord::finder()->findByAdminId($this->admin_id);
		}
		return $this->_posts;
		}

	public function getPrivileges() {
		if($this->_privileges === null) {
			$admins_privileges = DAdminPrivilegeRecord::finder()->findByAdminId($this->admin_id);
			$privileges_pks = array();
			foreach($admins_privileges as $a) {
				$privileges_pks[] = $a->privilege_id;
			}
			$this->_privileges = DPrivilegeRecord::finder()->findByPKs($privileges_pks);
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

	// finders and filters
	public function findByAdminId($admin_id) {
		return DAdminRecord::finder()->find("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findByAdminIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DAdminRecord::finder()->find("admin_id IN ({$in_values})", $parameters);
	}

	public function findByDeleted($deleted) {
		return DAdminRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByEmail($email) {
		return DAdminRecord::finder()->find("email = :email", array(":email" => $email));
	}

	public function findByLogin($login) {
		return DAdminRecord::finder()->find("login = :login", array(":login" => $login));
	}

	public function findOneByAdminId($admin_id) {
		return DAdminRecord::finder()->findOne("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findOneByDeleted($deleted) {
		return DAdminRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByEmail($email) {
		return DAdminRecord::finder()->findOne("email = :email", array(":email" => $email));
	}

	public function findOneByLogin($login) {
		return DAdminRecord::finder()->findOne("login = :login", array(":login" => $login));
	}

	public function filterByAdminId($admin_id) {
	}

	public function filterByAdminIds(array $ids) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByEmail($email) {
	}

	public function filterByLogin($login) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdminRecord extends DAdminBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DAdminPrivilegeBaseRecord extends FActiveRecord {

	public $TABLE = "admins_privileges";

	// properties
	public $admin_id;
	public $admin_privilege_id;
	public $create_date;
	public $deleted;
	public $privilege_id;

	public $TYPES = array(
		"admin_id" => "integer",
		"admin_privilege_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);
	// foreign key objects
	private $_admin = null;
	private $_privilege = null;



	// finders and filters
	public function findByAdminId($admin_id) {
		return DAdminPrivilegeRecord::finder()->find("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findByAdminIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DAdminPrivilegeRecord::finder()->find("admin_id IN ({$in_values})", $parameters);
	}

	public function findByAdminPrivilegeId($admin_privilege_id) {
		return DAdminPrivilegeRecord::finder()->find("admin_privilege_id = :admin_privilege_id", array(":admin_privilege_id" => $admin_privilege_id));
	}

	public function findByAdminPrivilegeIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DAdminPrivilegeRecord::finder()->find("admin_privilege_id IN ({$in_values})", $parameters);
	}

	public function findByCreateDate($create_date) {
		return DAdminPrivilegeRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DAdminPrivilegeRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByPrivilegeId($privilege_id) {
		return DAdminPrivilegeRecord::finder()->find("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
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
		return DAdminPrivilegeRecord::finder()->find("privilege_id IN ({$in_values})", $parameters);
	}

	public function findOneByAdminId($admin_id) {
		return DAdminPrivilegeRecord::finder()->findOne("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findOneByAdminPrivilegeId($admin_privilege_id) {
		return DAdminPrivilegeRecord::finder()->findOne("admin_privilege_id = :admin_privilege_id", array(":admin_privilege_id" => $admin_privilege_id));
	}

	public function findOneByCreateDate($create_date) {
		return DAdminPrivilegeRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DAdminPrivilegeRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DAdminPrivilegeRecord::finder()->findOne("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function filterByAdminId($admin_id) {
	}

	public function filterByAdminIds(array $ids) {
	}

	public function filterByAdminPrivilegeId($admin_privilege_id) {
	}

	public function filterByAdminPrivilegeIds(array $ids) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByPrivilegeId($privilege_id) {
	}

	public function filterByPrivilegeIds(array $ids) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdminPrivilegeRecord extends DAdminPrivilegeBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DAgeCategoryBaseRecord extends FActiveRecord {

	public $TABLE = "age_categories";

	// properties
	public $age_category_id;
	public $age_from;
	public $age_to;
	public $create_date;
	public $deleted;
	public $name;
	public $sex;
	public $year;

	public $TYPES = array(
		"age_category_id" => "integer",
		"age_from" => "integer",
		"age_to" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"name" => "text",
		"sex" => "text",
		"year" => "text",
	);

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByAgeCategoryId($this->age_category_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByAgeCategoryId($age_category_id) {
		return DAgeCategoryRecord::finder()->find("age_category_id = :age_category_id", array(":age_category_id" => $age_category_id));
	}

	public function findByAgeCategoryIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DAgeCategoryRecord::finder()->find("age_category_id IN ({$in_values})", $parameters);
	}

	public function findByAgeFrom($age_from) {
		return DAgeCategoryRecord::finder()->find("age_from = :age_from", array(":age_from" => $age_from));
	}

	public function findByAgeTo($age_to) {
		return DAgeCategoryRecord::finder()->find("age_to = :age_to", array(":age_to" => $age_to));
	}

	public function findByCreateDate($create_date) {
		return DAgeCategoryRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DAgeCategoryRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByName($name) {
		return DAgeCategoryRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findBySex($sex) {
		return DAgeCategoryRecord::finder()->find("sex = :sex", array(":sex" => $sex));
	}

	public function findByYear($year) {
		return DAgeCategoryRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByAgeCategoryId($age_category_id) {
		return DAgeCategoryRecord::finder()->findOne("age_category_id = :age_category_id", array(":age_category_id" => $age_category_id));
	}

	public function findOneByAgeFrom($age_from) {
		return DAgeCategoryRecord::finder()->findOne("age_from = :age_from", array(":age_from" => $age_from));
	}

	public function findOneByAgeTo($age_to) {
		return DAgeCategoryRecord::finder()->findOne("age_to = :age_to", array(":age_to" => $age_to));
	}

	public function findOneByCreateDate($create_date) {
		return DAgeCategoryRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DAgeCategoryRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByName($name) {
		return DAgeCategoryRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneBySex($sex) {
		return DAgeCategoryRecord::finder()->findOne("sex = :sex", array(":sex" => $sex));
	}

	public function findOneByYear($year) {
		return DAgeCategoryRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByAgeCategoryId($age_category_id) {
	}

	public function filterByAgeCategoryIds(array $ids) {
	}

	public function filterByAgeFrom($age_from) {
	}

	public function filterByAgeTo($age_to) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByName($name) {
	}

	public function filterBySex($sex) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAgeCategoryRecord extends DAgeCategoryBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DChildrenRunGroupBaseRecord extends FActiveRecord {

	public $TABLE = "childrens_runs_groups";

	// properties
	public $active;
	public $children_run_group_id;
	public $create_date;
	public $deleted;
	public $limit;
	public $name;
	public $year;

	public $TYPES = array(
		"active" => "integer",
		"children_run_group_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"limit" => "integer",
		"name" => "text",
		"year" => "integer",
	);

	// relationships objects
	private $_childrens_runs_participants = null;

	// relationship methods
	public function getChildrensRunsParticipants() {
		if($this->_childrens_runs_participants === null) {
			$this->_childrens_runs_participants = DChildrenRunParticipantRecord::finder()->findByChildrenRunGroupId($this->children_run_group_id);
		}
		return $this->_childrens_runs_participants;
		}


	// finders and filters
	public function findByActive($active) {
		return DChildrenRunGroupRecord::finder()->find("active = :active", array(":active" => $active));
	}

	public function findByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunGroupRecord::finder()->find("children_run_group_id = :children_run_group_id", array(":children_run_group_id" => $children_run_group_id));
	}

	public function findByChildrenRunGroupIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DChildrenRunGroupRecord::finder()->find("children_run_group_id IN ({$in_values})", $parameters);
	}

	public function findByCreateDate($create_date) {
		return DChildrenRunGroupRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DChildrenRunGroupRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByLimit($limit) {
		return DChildrenRunGroupRecord::finder()->find("limit = :limit", array(":limit" => $limit));
	}

	public function findByName($name) {
		return DChildrenRunGroupRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findByYear($year) {
		return DChildrenRunGroupRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByActive($active) {
		return DChildrenRunGroupRecord::finder()->findOne("active = :active", array(":active" => $active));
	}

	public function findOneByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunGroupRecord::finder()->findOne("children_run_group_id = :children_run_group_id", array(":children_run_group_id" => $children_run_group_id));
	}

	public function findOneByCreateDate($create_date) {
		return DChildrenRunGroupRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DChildrenRunGroupRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByLimit($limit) {
		return DChildrenRunGroupRecord::finder()->findOne("limit = :limit", array(":limit" => $limit));
	}

	public function findOneByName($name) {
		return DChildrenRunGroupRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneByYear($year) {
		return DChildrenRunGroupRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByActive($active) {
	}

	public function filterByChildrenRunGroupId($children_run_group_id) {
	}

	public function filterByChildrenRunGroupIds(array $ids) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByLimit($limit) {
	}

	public function filterByName($name) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DChildrenRunGroupRecord extends DChildrenRunGroupBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DChildrenRunParticipantBaseRecord extends FActiveRecord {

	public $TABLE = "childrens_runs_participants";

	// properties
	public $birth_date;
	public $children_run_group_id;
	public $children_run_participant_id;
	public $city;
	public $deleted;
	public $first_name;
	public $last_name;
	public $register_date;
	public $year;

	public $TYPES = array(
		"birth_date" => "text",
		"children_run_group_id" => "integer",
		"children_run_participant_id" => "integer",
		"city" => "text",
		"deleted" => "integer",
		"first_name" => "text",
		"last_name" => "text",
		"register_date" => "timestamp with time zone",
		"year" => "text",
	);
	// foreign key objects
	private $_children_run_group = null;



	// finders and filters
	public function findByBirthDate($birth_date) {
		return DChildrenRunParticipantRecord::finder()->find("birth_date = :birth_date", array(":birth_date" => $birth_date));
	}

	public function findByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunParticipantRecord::finder()->find("children_run_group_id = :children_run_group_id", array(":children_run_group_id" => $children_run_group_id));
	}

	public function findByChildrenRunGroupIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DChildrenRunParticipantRecord::finder()->find("children_run_group_id IN ({$in_values})", $parameters);
	}

	public function findByChildrenRunParticipantId($children_run_participant_id) {
		return DChildrenRunParticipantRecord::finder()->find("children_run_participant_id = :children_run_participant_id", array(":children_run_participant_id" => $children_run_participant_id));
	}

	public function findByChildrenRunParticipantIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DChildrenRunParticipantRecord::finder()->find("children_run_participant_id IN ({$in_values})", $parameters);
	}

	public function findByCity($city) {
		return DChildrenRunParticipantRecord::finder()->find("city = :city", array(":city" => $city));
	}

	public function findByDeleted($deleted) {
		return DChildrenRunParticipantRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByFirstName($first_name) {
		return DChildrenRunParticipantRecord::finder()->find("first_name = :first_name", array(":first_name" => $first_name));
	}

	public function findByLastName($last_name) {
		return DChildrenRunParticipantRecord::finder()->find("last_name = :last_name", array(":last_name" => $last_name));
	}

	public function findByRegisterDate($register_date) {
		return DChildrenRunParticipantRecord::finder()->find("register_date = :register_date", array(":register_date" => $register_date));
	}

	public function findByYear($year) {
		return DChildrenRunParticipantRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByBirthDate($birth_date) {
		return DChildrenRunParticipantRecord::finder()->findOne("birth_date = :birth_date", array(":birth_date" => $birth_date));
	}

	public function findOneByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunParticipantRecord::finder()->findOne("children_run_group_id = :children_run_group_id", array(":children_run_group_id" => $children_run_group_id));
	}

	public function findOneByChildrenRunParticipantId($children_run_participant_id) {
		return DChildrenRunParticipantRecord::finder()->findOne("children_run_participant_id = :children_run_participant_id", array(":children_run_participant_id" => $children_run_participant_id));
	}

	public function findOneByCity($city) {
		return DChildrenRunParticipantRecord::finder()->findOne("city = :city", array(":city" => $city));
	}

	public function findOneByDeleted($deleted) {
		return DChildrenRunParticipantRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByFirstName($first_name) {
		return DChildrenRunParticipantRecord::finder()->findOne("first_name = :first_name", array(":first_name" => $first_name));
	}

	public function findOneByLastName($last_name) {
		return DChildrenRunParticipantRecord::finder()->findOne("last_name = :last_name", array(":last_name" => $last_name));
	}

	public function findOneByRegisterDate($register_date) {
		return DChildrenRunParticipantRecord::finder()->findOne("register_date = :register_date", array(":register_date" => $register_date));
	}

	public function findOneByYear($year) {
		return DChildrenRunParticipantRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByBirthDate($birth_date) {
	}

	public function filterByChildrenRunGroupId($children_run_group_id) {
	}

	public function filterByChildrenRunGroupIds(array $ids) {
	}

	public function filterByChildrenRunParticipantId($children_run_participant_id) {
	}

	public function filterByChildrenRunParticipantIds(array $ids) {
	}

	public function filterByCity($city) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByFirstName($first_name) {
	}

	public function filterByLastName($last_name) {
	}

	public function filterByRegisterDate($register_date) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DChildrenRunParticipantRecord extends DChildrenRunParticipantBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DClassificationBaseRecord extends FActiveRecord {

	public $TABLE = "classifications";

	// properties
	public $classification_id;
	public $create_date;
	public $deleted;
	public $description;
	public $name;
	public $year;

	public $TYPES = array(
		"classification_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"description" => "text",
		"name" => "text",
		"year" => "text",
	);

	// relationships objects
	private $_events = null;
	private $_participants = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByClassificationId($this->classification_id);
		}
		return $this->_events;
		}

	public function getParticipants() {
		if($this->_participants === null) {
			$participants_classifications = DParticipantClassificationRecord::finder()->findByClassificationId($this->classification_id);
			$participants_pks = array();
			foreach($participants_classifications as $p) {
				$participants_pks[] = $p->participant_id;
			}
			$this->_participants = DParticipantRecord::finder()->findByPKs($participants_pks);
			foreach($this->_participants as $p) {
				foreach($participants_classifications as $p) {
					if($p->participant_id === $p->participant_id) {
						$p->setRelationship($p);
						unset($p);
						break;
					}
				}
			}
		}
		return $this->_participants;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}

	// finders and filters
	public function findByClassificationId($classification_id) {
		return DClassificationRecord::finder()->find("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findByClassificationIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DClassificationRecord::finder()->find("classification_id IN ({$in_values})", $parameters);
	}

	public function findByCreateDate($create_date) {
		return DClassificationRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DClassificationRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByDescription($description) {
		return DClassificationRecord::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByName($name) {
		return DClassificationRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findByYear($year) {
		return DClassificationRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByClassificationId($classification_id) {
		return DClassificationRecord::finder()->findOne("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findOneByCreateDate($create_date) {
		return DClassificationRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DClassificationRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByDescription($description) {
		return DClassificationRecord::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByName($name) {
		return DClassificationRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneByYear($year) {
		return DClassificationRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByClassificationId($classification_id) {
	}

	public function filterByClassificationIds(array $ids) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByDescription($description) {
	}

	public function filterByName($name) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DClassificationRecord extends DClassificationBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DClubBaseRecord extends FActiveRecord {

	public $TABLE = "clubs";

	// properties
	public $club_id;
	public $deleted;
	public $name;
	public $year;

	public $TYPES = array(
		"club_id" => "integer",
		"deleted" => "integer",
		"name" => "text",
		"year" => "text",
	);

	// relationships objects
	private $_events = null;
	private $_participant_datas = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByClubId($this->club_id);
		}
		return $this->_events;
		}

	public function getParticipantDatas() {
		if($this->_participant_datas === null) {
			$this->_participant_datas = DParticipantDataRecord::finder()->findByClubId($this->club_id);
		}
		return $this->_participant_datas;
		}


	// finders and filters
	public function findByClubId($club_id) {
		return DClubRecord::finder()->find("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findByClubIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DClubRecord::finder()->find("club_id IN ({$in_values})", $parameters);
	}

	public function findByDeleted($deleted) {
		return DClubRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByName($name) {
		return DClubRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findByYear($year) {
		return DClubRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByClubId($club_id) {
		return DClubRecord::finder()->findOne("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findOneByDeleted($deleted) {
		return DClubRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByName($name) {
		return DClubRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneByYear($year) {
		return DClubRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByClubId($club_id) {
	}

	public function filterByClubIds(array $ids) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByName($name) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DClubRecord extends DClubBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DCommentBaseRecord extends FActiveRecord {

	public $TABLE = "comments";

	// properties
	public $comment;
	public $comment_id;
	public $date;
	public $deleted;
	public $full_name;
	public $year;

	public $TYPES = array(
		"comment" => "text",
		"comment_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"full_name" => "text",
		"year" => "text",
	);

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByCommentId($this->comment_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByComment($comment) {
		return DCommentRecord::finder()->find("comment = :comment", array(":comment" => $comment));
	}

	public function findByCommentId($comment_id) {
		return DCommentRecord::finder()->find("comment_id = :comment_id", array(":comment_id" => $comment_id));
	}

	public function findByCommentIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DCommentRecord::finder()->find("comment_id IN ({$in_values})", $parameters);
	}

	public function findByDate($date) {
		return DCommentRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByDeleted($deleted) {
		return DCommentRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByFullName($full_name) {
		return DCommentRecord::finder()->find("full_name = :full_name", array(":full_name" => $full_name));
	}

	public function findByYear($year) {
		return DCommentRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByComment($comment) {
		return DCommentRecord::finder()->findOne("comment = :comment", array(":comment" => $comment));
	}

	public function findOneByCommentId($comment_id) {
		return DCommentRecord::finder()->findOne("comment_id = :comment_id", array(":comment_id" => $comment_id));
	}

	public function findOneByDate($date) {
		return DCommentRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByDeleted($deleted) {
		return DCommentRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByFullName($full_name) {
		return DCommentRecord::finder()->findOne("full_name = :full_name", array(":full_name" => $full_name));
	}

	public function findOneByYear($year) {
		return DCommentRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByComment($comment) {
	}

	public function filterByCommentId($comment_id) {
	}

	public function filterByCommentIds(array $ids) {
	}

	public function filterByDate($date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByFullName($full_name) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DCommentRecord extends DCommentBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DConfigBaseRecord extends FActiveRecord {

	public $TABLE = "config";

	// properties
	public $date;
	public $deleted;
	public $key;
	public $value;

	public $TYPES = array(
		"date" => "text",
		"deleted" => "integer",
		"key" => "character varying",
		"value" => "text",
	);



	// finders and filters
	public function findByDate($date) {
		return DConfigRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByDeleted($deleted) {
		return DConfigRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByKey($key) {
		return DConfigRecord::finder()->find("key = :key", array(":key" => $key));
	}

	public function findByValue($value) {
		return DConfigRecord::finder()->find("value = :value", array(":value" => $value));
	}

	public function findOneByDate($date) {
		return DConfigRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByDeleted($deleted) {
		return DConfigRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByKey($key) {
		return DConfigRecord::finder()->findOne("key = :key", array(":key" => $key));
	}

	public function findOneByValue($value) {
		return DConfigRecord::finder()->findOne("value = :value", array(":value" => $value));
	}

	public function filterByDate($date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByKey($key) {
	}

	public function filterByValue($value) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DConfigRecord extends DConfigBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DConfigHistoryBaseRecord extends FActiveRecord {

	public $TABLE = "config_history";

	// properties
	public $config_history_id;
	public $date;
	public $key;
	public $value;

	public $TYPES = array(
		"config_history_id" => "integer",
		"date" => "timestamp with time zone",
		"key" => "text",
		"value" => "text",
	);

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByConfigHistoryId($this->config_history_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByConfigHistoryId($config_history_id) {
		return DConfigHistoryRecord::finder()->find("config_history_id = :config_history_id", array(":config_history_id" => $config_history_id));
	}

	public function findByConfigHistoryIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DConfigHistoryRecord::finder()->find("config_history_id IN ({$in_values})", $parameters);
	}

	public function findByDate($date) {
		return DConfigHistoryRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByKey($key) {
		return DConfigHistoryRecord::finder()->find("key = :key", array(":key" => $key));
	}

	public function findByValue($value) {
		return DConfigHistoryRecord::finder()->find("value = :value", array(":value" => $value));
	}

	public function findOneByConfigHistoryId($config_history_id) {
		return DConfigHistoryRecord::finder()->findOne("config_history_id = :config_history_id", array(":config_history_id" => $config_history_id));
	}

	public function findOneByDate($date) {
		return DConfigHistoryRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByKey($key) {
		return DConfigHistoryRecord::finder()->findOne("key = :key", array(":key" => $key));
	}

	public function findOneByValue($value) {
		return DConfigHistoryRecord::finder()->findOne("value = :value", array(":value" => $value));
	}

	public function filterByConfigHistoryId($config_history_id) {
	}

	public function filterByConfigHistoryIds(array $ids) {
	}

	public function filterByDate($date) {
	}

	public function filterByKey($key) {
	}

	public function filterByValue($value) {
	}

	// others
}


class DConfigHistoryRecord extends DConfigHistoryBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DEventBaseRecord extends FActiveRecord {

	public $TABLE = "events";

	// properties
	public $admin_id;
	public $age_category_id;
	public $classification_id;
	public $club_id;
	public $comment_id;
	public $config_history_id;
	public $date;
	public $deleted;
	public $event_id;
	public $ip;
	public $module_id;
	public $params;
	public $participant_data_id;
	public $participant_id;
	public $post_id;
	public $supporter_id;
	public $type;

	public $TYPES = array(
		"admin_id" => "integer",
		"age_category_id" => "integer",
		"classification_id" => "integer",
		"club_id" => "integer",
		"comment_id" => "integer",
		"config_history_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"event_id" => "integer",
		"ip" => "text",
		"module_id" => "integer",
		"params" => "text",
		"participant_data_id" => "integer",
		"participant_id" => "integer",
		"post_id" => "integer",
		"supporter_id" => "integer",
		"type" => "text",
	);
	// foreign key objects
	private $_admin = null;
	private $_age_category = null;
	private $_classification = null;
	private $_club = null;
	private $_comment = null;
	private $_config_history = null;
	private $_module = null;
	private $_participant_data = null;
	private $_participant = null;
	private $_post = null;
	private $_supporter = null;



	// finders and filters
	public function findByAdminId($admin_id) {
		return DEventRecord::finder()->find("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findByAdminIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("admin_id IN ({$in_values})", $parameters);
	}

	public function findByAgeCategoryId($age_category_id) {
		return DEventRecord::finder()->find("age_category_id = :age_category_id", array(":age_category_id" => $age_category_id));
	}

	public function findByAgeCategoryIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("age_category_id IN ({$in_values})", $parameters);
	}

	public function findByClassificationId($classification_id) {
		return DEventRecord::finder()->find("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findByClassificationIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("classification_id IN ({$in_values})", $parameters);
	}

	public function findByClubId($club_id) {
		return DEventRecord::finder()->find("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findByClubIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("club_id IN ({$in_values})", $parameters);
	}

	public function findByCommentId($comment_id) {
		return DEventRecord::finder()->find("comment_id = :comment_id", array(":comment_id" => $comment_id));
	}

	public function findByCommentIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("comment_id IN ({$in_values})", $parameters);
	}

	public function findByConfigHistoryId($config_history_id) {
		return DEventRecord::finder()->find("config_history_id = :config_history_id", array(":config_history_id" => $config_history_id));
	}

	public function findByConfigHistoryIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("config_history_id IN ({$in_values})", $parameters);
	}

	public function findByDate($date) {
		return DEventRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByDeleted($deleted) {
		return DEventRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByEventId($event_id) {
		return DEventRecord::finder()->find("event_id = :event_id", array(":event_id" => $event_id));
	}

	public function findByEventIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("event_id IN ({$in_values})", $parameters);
	}

	public function findByIp($ip) {
		return DEventRecord::finder()->find("ip = :ip", array(":ip" => $ip));
	}

	public function findByModuleId($module_id) {
		return DEventRecord::finder()->find("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findByModuleIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("module_id IN ({$in_values})", $parameters);
	}

	public function findByParams($params) {
		return DEventRecord::finder()->find("params = :params", array(":params" => $params));
	}

	public function findByParticipantDataId($participant_data_id) {
		return DEventRecord::finder()->find("participant_data_id = :participant_data_id", array(":participant_data_id" => $participant_data_id));
	}

	public function findByParticipantDataIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("participant_data_id IN ({$in_values})", $parameters);
	}

	public function findByParticipantId($participant_id) {
		return DEventRecord::finder()->find("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findByParticipantIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("participant_id IN ({$in_values})", $parameters);
	}

	public function findByPostId($post_id) {
		return DEventRecord::finder()->find("post_id = :post_id", array(":post_id" => $post_id));
	}

	public function findByPostIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("post_id IN ({$in_values})", $parameters);
	}

	public function findBySupporterId($supporter_id) {
		return DEventRecord::finder()->find("supporter_id = :supporter_id", array(":supporter_id" => $supporter_id));
	}

	public function findBySupporterIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DEventRecord::finder()->find("supporter_id IN ({$in_values})", $parameters);
	}

	public function findByType($type) {
		return DEventRecord::finder()->find("type = :type", array(":type" => $type));
	}

	public function findOneByAdminId($admin_id) {
		return DEventRecord::finder()->findOne("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findOneByAgeCategoryId($age_category_id) {
		return DEventRecord::finder()->findOne("age_category_id = :age_category_id", array(":age_category_id" => $age_category_id));
	}

	public function findOneByClassificationId($classification_id) {
		return DEventRecord::finder()->findOne("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findOneByClubId($club_id) {
		return DEventRecord::finder()->findOne("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findOneByCommentId($comment_id) {
		return DEventRecord::finder()->findOne("comment_id = :comment_id", array(":comment_id" => $comment_id));
	}

	public function findOneByConfigHistoryId($config_history_id) {
		return DEventRecord::finder()->findOne("config_history_id = :config_history_id", array(":config_history_id" => $config_history_id));
	}

	public function findOneByDate($date) {
		return DEventRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByDeleted($deleted) {
		return DEventRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByEventId($event_id) {
		return DEventRecord::finder()->findOne("event_id = :event_id", array(":event_id" => $event_id));
	}

	public function findOneByIp($ip) {
		return DEventRecord::finder()->findOne("ip = :ip", array(":ip" => $ip));
	}

	public function findOneByModuleId($module_id) {
		return DEventRecord::finder()->findOne("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findOneByParams($params) {
		return DEventRecord::finder()->findOne("params = :params", array(":params" => $params));
	}

	public function findOneByParticipantDataId($participant_data_id) {
		return DEventRecord::finder()->findOne("participant_data_id = :participant_data_id", array(":participant_data_id" => $participant_data_id));
	}

	public function findOneByParticipantId($participant_id) {
		return DEventRecord::finder()->findOne("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findOneByPostId($post_id) {
		return DEventRecord::finder()->findOne("post_id = :post_id", array(":post_id" => $post_id));
	}

	public function findOneBySupporterId($supporter_id) {
		return DEventRecord::finder()->findOne("supporter_id = :supporter_id", array(":supporter_id" => $supporter_id));
	}

	public function findOneByType($type) {
		return DEventRecord::finder()->findOne("type = :type", array(":type" => $type));
	}

	public function filterByAdminId($admin_id) {
	}

	public function filterByAdminIds(array $ids) {
	}

	public function filterByAgeCategoryId($age_category_id) {
	}

	public function filterByAgeCategoryIds(array $ids) {
	}

	public function filterByClassificationId($classification_id) {
	}

	public function filterByClassificationIds(array $ids) {
	}

	public function filterByClubId($club_id) {
	}

	public function filterByClubIds(array $ids) {
	}

	public function filterByCommentId($comment_id) {
	}

	public function filterByCommentIds(array $ids) {
	}

	public function filterByConfigHistoryId($config_history_id) {
	}

	public function filterByConfigHistoryIds(array $ids) {
	}

	public function filterByDate($date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByEventId($event_id) {
	}

	public function filterByEventIds(array $ids) {
	}

	public function filterByIp($ip) {
	}

	public function filterByModuleId($module_id) {
	}

	public function filterByModuleIds(array $ids) {
	}

	public function filterByParams($params) {
	}

	public function filterByParticipantDataId($participant_data_id) {
	}

	public function filterByParticipantDataIds(array $ids) {
	}

	public function filterByParticipantId($participant_id) {
	}

	public function filterByParticipantIds(array $ids) {
	}

	public function filterByPostId($post_id) {
	}

	public function filterByPostIds(array $ids) {
	}

	public function filterBySupporterId($supporter_id) {
	}

	public function filterBySupporterIds(array $ids) {
	}

	public function filterByType($type) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DEventRecord extends DEventBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DMediaBaseRecord extends FActiveRecord {

	public $TABLE = "media";

	// properties
	public $deleted;
	public $description;
	public $description_alt;
	public $media_id;
	public $path;
	public $type;
	public $upload_date;

	public $TYPES = array(
		"deleted" => "integer",
		"description" => "text",
		"description_alt" => "text",
		"media_id" => "integer",
		"path" => "text",
		"type" => "text",
		"upload_date" => "timestamp with time zone",
	);

	// relationships objects
	private $_posts = null;
	private $_supporters = null;

	// relationship methods
	public function getPosts() {
		if($this->_posts === null) {
			$this->_posts = DPostRecord::finder()->findByMediaId($this->media_id);
		}
		return $this->_posts;
		}

	public function getSupporters() {
		if($this->_supporters === null) {
			$this->_supporters = DSupporterRecord::finder()->findByMediaId($this->media_id);
		}
		return $this->_supporters;
		}


	// finders and filters
	public function findByDeleted($deleted) {
		return DMediaRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByDescription($description) {
		return DMediaRecord::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByDescriptionAlt($description_alt) {
		return DMediaRecord::finder()->find("description_alt = :description_alt", array(":description_alt" => $description_alt));
	}

	public function findByMediaId($media_id) {
		return DMediaRecord::finder()->find("media_id = :media_id", array(":media_id" => $media_id));
	}

	public function findByMediaIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DMediaRecord::finder()->find("media_id IN ({$in_values})", $parameters);
	}

	public function findByPath($path) {
		return DMediaRecord::finder()->find("path = :path", array(":path" => $path));
	}

	public function findByType($type) {
		return DMediaRecord::finder()->find("type = :type", array(":type" => $type));
	}

	public function findByUploadDate($upload_date) {
		return DMediaRecord::finder()->find("upload_date = :upload_date", array(":upload_date" => $upload_date));
	}

	public function findOneByDeleted($deleted) {
		return DMediaRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByDescription($description) {
		return DMediaRecord::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByDescriptionAlt($description_alt) {
		return DMediaRecord::finder()->findOne("description_alt = :description_alt", array(":description_alt" => $description_alt));
	}

	public function findOneByMediaId($media_id) {
		return DMediaRecord::finder()->findOne("media_id = :media_id", array(":media_id" => $media_id));
	}

	public function findOneByPath($path) {
		return DMediaRecord::finder()->findOne("path = :path", array(":path" => $path));
	}

	public function findOneByType($type) {
		return DMediaRecord::finder()->findOne("type = :type", array(":type" => $type));
	}

	public function findOneByUploadDate($upload_date) {
		return DMediaRecord::finder()->findOne("upload_date = :upload_date", array(":upload_date" => $upload_date));
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByDescription($description) {
	}

	public function filterByDescriptionAlt($description_alt) {
	}

	public function filterByMediaId($media_id) {
	}

	public function filterByMediaIds(array $ids) {
	}

	public function filterByPath($path) {
	}

	public function filterByType($type) {
	}

	public function filterByUploadDate($upload_date) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DMediaRecord extends DMediaBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DModuleBaseRecord extends FActiveRecord {

	public $TABLE = "modules";

	// properties
	public $active;
	public $deleted;
	public $description;
	public $key;
	public $module_id;
	public $name;

	public $TYPES = array(
		"active" => "integer",
		"deleted" => "integer",
		"description" => "text",
		"key" => "text",
		"module_id" => "integer",
		"name" => "text",
	);

	// relationships objects
	private $_events = null;
	private $_modules_config = null;
	private $_modules_config_history = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByModuleId($this->module_id);
		}
		return $this->_events;
		}

	public function getModulesConfig() {
		if($this->_modules_config === null) {
			$this->_modules_config = DModuleConfigRecord::finder()->findByModuleId($this->module_id);
		}
		return $this->_modules_config;
		}

	public function getModulesConfigHistory() {
		if($this->_modules_config_history === null) {
			$this->_modules_config_history = DModuleConfigHistoryRecord::finder()->findByModuleId($this->module_id);
		}
		return $this->_modules_config_history;
		}


	// finders and filters
	public function findByActive($active) {
		return DModuleRecord::finder()->find("active = :active", array(":active" => $active));
	}

	public function findByDeleted($deleted) {
		return DModuleRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByDescription($description) {
		return DModuleRecord::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByKey($key) {
		return DModuleRecord::finder()->find("key = :key", array(":key" => $key));
	}

	public function findByModuleId($module_id) {
		return DModuleRecord::finder()->find("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findByModuleIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DModuleRecord::finder()->find("module_id IN ({$in_values})", $parameters);
	}

	public function findByName($name) {
		return DModuleRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findOneByActive($active) {
		return DModuleRecord::finder()->findOne("active = :active", array(":active" => $active));
	}

	public function findOneByDeleted($deleted) {
		return DModuleRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByDescription($description) {
		return DModuleRecord::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByKey($key) {
		return DModuleRecord::finder()->findOne("key = :key", array(":key" => $key));
	}

	public function findOneByModuleId($module_id) {
		return DModuleRecord::finder()->findOne("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findOneByName($name) {
		return DModuleRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function filterByActive($active) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByDescription($description) {
	}

	public function filterByKey($key) {
	}

	public function filterByModuleId($module_id) {
	}

	public function filterByModuleIds(array $ids) {
	}

	public function filterByName($name) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DModuleRecord extends DModuleBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DModuleConfigBaseRecord extends FActiveRecord {

	public $TABLE = "modules_config";

	// properties
	public $key;
	public $module_config_id;
	public $module_id;
	public $value;

	public $TYPES = array(
		"key" => "text",
		"module_config_id" => "integer",
		"module_id" => "integer",
		"value" => "text",
	);
	// foreign key objects
	private $_module = null;



	// finders and filters
	public function findByKey($key) {
		return DModuleConfigRecord::finder()->find("key = :key", array(":key" => $key));
	}

	public function findByModuleConfigId($module_config_id) {
		return DModuleConfigRecord::finder()->find("module_config_id = :module_config_id", array(":module_config_id" => $module_config_id));
	}

	public function findByModuleConfigIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DModuleConfigRecord::finder()->find("module_config_id IN ({$in_values})", $parameters);
	}

	public function findByModuleId($module_id) {
		return DModuleConfigRecord::finder()->find("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findByModuleIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DModuleConfigRecord::finder()->find("module_id IN ({$in_values})", $parameters);
	}

	public function findByValue($value) {
		return DModuleConfigRecord::finder()->find("value = :value", array(":value" => $value));
	}

	public function findOneByKey($key) {
		return DModuleConfigRecord::finder()->findOne("key = :key", array(":key" => $key));
	}

	public function findOneByModuleConfigId($module_config_id) {
		return DModuleConfigRecord::finder()->findOne("module_config_id = :module_config_id", array(":module_config_id" => $module_config_id));
	}

	public function findOneByModuleId($module_id) {
		return DModuleConfigRecord::finder()->findOne("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findOneByValue($value) {
		return DModuleConfigRecord::finder()->findOne("value = :value", array(":value" => $value));
	}

	public function filterByKey($key) {
	}

	public function filterByModuleConfigId($module_config_id) {
	}

	public function filterByModuleConfigIds(array $ids) {
	}

	public function filterByModuleId($module_id) {
	}

	public function filterByModuleIds(array $ids) {
	}

	public function filterByValue($value) {
	}

	// others
}


class DModuleConfigRecord extends DModuleConfigBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DModuleConfigHistoryBaseRecord extends FActiveRecord {

	public $TABLE = "modules_config_history";

	// properties
	public $date;
	public $key;
	public $module_config_history_id;
	public $module_id;
	public $value;

	public $TYPES = array(
		"date" => "timestamp with time zone",
		"key" => "text",
		"module_config_history_id" => "integer",
		"module_id" => "integer",
		"value" => "text",
	);
	// foreign key objects
	private $_module = null;



	// finders and filters
	public function findByDate($date) {
		return DModuleConfigHistoryRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByKey($key) {
		return DModuleConfigHistoryRecord::finder()->find("key = :key", array(":key" => $key));
	}

	public function findByModuleConfigHistoryId($module_config_history_id) {
		return DModuleConfigHistoryRecord::finder()->find("module_config_history_id = :module_config_history_id", array(":module_config_history_id" => $module_config_history_id));
	}

	public function findByModuleConfigHistoryIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DModuleConfigHistoryRecord::finder()->find("module_config_history_id IN ({$in_values})", $parameters);
	}

	public function findByModuleId($module_id) {
		return DModuleConfigHistoryRecord::finder()->find("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findByModuleIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DModuleConfigHistoryRecord::finder()->find("module_id IN ({$in_values})", $parameters);
	}

	public function findByValue($value) {
		return DModuleConfigHistoryRecord::finder()->find("value = :value", array(":value" => $value));
	}

	public function findOneByDate($date) {
		return DModuleConfigHistoryRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByKey($key) {
		return DModuleConfigHistoryRecord::finder()->findOne("key = :key", array(":key" => $key));
	}

	public function findOneByModuleConfigHistoryId($module_config_history_id) {
		return DModuleConfigHistoryRecord::finder()->findOne("module_config_history_id = :module_config_history_id", array(":module_config_history_id" => $module_config_history_id));
	}

	public function findOneByModuleId($module_id) {
		return DModuleConfigHistoryRecord::finder()->findOne("module_id = :module_id", array(":module_id" => $module_id));
	}

	public function findOneByValue($value) {
		return DModuleConfigHistoryRecord::finder()->findOne("value = :value", array(":value" => $value));
	}

	public function filterByDate($date) {
	}

	public function filterByKey($key) {
	}

	public function filterByModuleConfigHistoryId($module_config_history_id) {
	}

	public function filterByModuleConfigHistoryIds(array $ids) {
	}

	public function filterByModuleId($module_id) {
	}

	public function filterByModuleIds(array $ids) {
	}

	public function filterByValue($value) {
	}

	// others
}


class DModuleConfigHistoryRecord extends DModuleConfigHistoryBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DParticipantDataBaseRecord extends FActiveRecord {

	public $TABLE = "participant_datas";

	// properties
	public $birth_date;
	public $city;
	public $club_id;
	public $create_date;
	public $deleted;
	public $email;
	public $first_name;
	public $last_name;
	public $participant_data_id;
	public $participant_id;
	public $phone;
	public $sex;

	public $TYPES = array(
		"birth_date" => "text",
		"city" => "text",
		"club_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"email" => "text",
		"first_name" => "text",
		"last_name" => "text",
		"participant_data_id" => "integer",
		"participant_id" => "integer",
		"phone" => "text",
		"sex" => "text",
	);
	// foreign key objects
	private $_club = null;
	private $_participant = null;

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByParticipantDataId($this->participant_data_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByBirthDate($birth_date) {
		return DParticipantDataRecord::finder()->find("birth_date = :birth_date", array(":birth_date" => $birth_date));
	}

	public function findByCity($city) {
		return DParticipantDataRecord::finder()->find("city = :city", array(":city" => $city));
	}

	public function findByClubId($club_id) {
		return DParticipantDataRecord::finder()->find("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findByClubIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantDataRecord::finder()->find("club_id IN ({$in_values})", $parameters);
	}

	public function findByCreateDate($create_date) {
		return DParticipantDataRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DParticipantDataRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByEmail($email) {
		return DParticipantDataRecord::finder()->find("email = :email", array(":email" => $email));
	}

	public function findByFirstName($first_name) {
		return DParticipantDataRecord::finder()->find("first_name = :first_name", array(":first_name" => $first_name));
	}

	public function findByLastName($last_name) {
		return DParticipantDataRecord::finder()->find("last_name = :last_name", array(":last_name" => $last_name));
	}

	public function findByParticipantDataId($participant_data_id) {
		return DParticipantDataRecord::finder()->find("participant_data_id = :participant_data_id", array(":participant_data_id" => $participant_data_id));
	}

	public function findByParticipantDataIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantDataRecord::finder()->find("participant_data_id IN ({$in_values})", $parameters);
	}

	public function findByParticipantId($participant_id) {
		return DParticipantDataRecord::finder()->find("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findByParticipantIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantDataRecord::finder()->find("participant_id IN ({$in_values})", $parameters);
	}

	public function findByPhone($phone) {
		return DParticipantDataRecord::finder()->find("phone = :phone", array(":phone" => $phone));
	}

	public function findBySex($sex) {
		return DParticipantDataRecord::finder()->find("sex = :sex", array(":sex" => $sex));
	}

	public function findOneByBirthDate($birth_date) {
		return DParticipantDataRecord::finder()->findOne("birth_date = :birth_date", array(":birth_date" => $birth_date));
	}

	public function findOneByCity($city) {
		return DParticipantDataRecord::finder()->findOne("city = :city", array(":city" => $city));
	}

	public function findOneByClubId($club_id) {
		return DParticipantDataRecord::finder()->findOne("club_id = :club_id", array(":club_id" => $club_id));
	}

	public function findOneByCreateDate($create_date) {
		return DParticipantDataRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DParticipantDataRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByEmail($email) {
		return DParticipantDataRecord::finder()->findOne("email = :email", array(":email" => $email));
	}

	public function findOneByFirstName($first_name) {
		return DParticipantDataRecord::finder()->findOne("first_name = :first_name", array(":first_name" => $first_name));
	}

	public function findOneByLastName($last_name) {
		return DParticipantDataRecord::finder()->findOne("last_name = :last_name", array(":last_name" => $last_name));
	}

	public function findOneByParticipantDataId($participant_data_id) {
		return DParticipantDataRecord::finder()->findOne("participant_data_id = :participant_data_id", array(":participant_data_id" => $participant_data_id));
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipantDataRecord::finder()->findOne("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findOneByPhone($phone) {
		return DParticipantDataRecord::finder()->findOne("phone = :phone", array(":phone" => $phone));
	}

	public function findOneBySex($sex) {
		return DParticipantDataRecord::finder()->findOne("sex = :sex", array(":sex" => $sex));
	}

	public function filterByBirthDate($birth_date) {
	}

	public function filterByCity($city) {
	}

	public function filterByClubId($club_id) {
	}

	public function filterByClubIds(array $ids) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByEmail($email) {
	}

	public function filterByFirstName($first_name) {
	}

	public function filterByLastName($last_name) {
	}

	public function filterByParticipantDataId($participant_data_id) {
	}

	public function filterByParticipantDataIds(array $ids) {
	}

	public function filterByParticipantId($participant_id) {
	}

	public function filterByParticipantIds(array $ids) {
	}

	public function filterByPhone($phone) {
	}

	public function filterBySex($sex) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipantDataRecord extends DParticipantDataBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DParticipantBaseRecord extends FActiveRecord {

	public $TABLE = "participants";

	// properties
	public $application_number;
	public $deleted;
	public $participant_id;
	public $register_date;
	public $starting_number;
	public $year;

	public $TYPES = array(
		"application_number" => "integer",
		"deleted" => "integer",
		"participant_id" => "integer",
		"register_date" => "timestamp with time zone",
		"starting_number" => "integer",
		"year" => "integer",
	);

	// relationships objects
	private $_events = null;
	private $_participant_datas = null;
	private $_classifications = null;
	// relationship object
	private $_relationship = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByParticipantId($this->participant_id);
		}
		return $this->_events;
		}

	public function getParticipantDatas() {
		if($this->_participant_datas === null) {
			$this->_participant_datas = DParticipantDataRecord::finder()->findByParticipantId($this->participant_id);
		}
		return $this->_participant_datas;
		}

	public function getClassifications() {
		if($this->_classifications === null) {
			$participants_classifications = DParticipantClassificationRecord::finder()->findByParticipantId($this->participant_id);
			$classifications_pks = array();
			foreach($participants_classifications as $p) {
				$classifications_pks[] = $p->classification_id;
			}
			$this->_classifications = DClassificationRecord::finder()->findByPKs($classifications_pks);
			foreach($this->_classifications as $c) {
				foreach($participants_classifications as $p) {
					if($c->classification_id === $p->classification_id) {
						$c->setRelationship($p);
						unset($p);
						break;
					}
				}
			}
		}
		return $this->_classifications;
	}

	public function setRelationship($relationship) {
		return $this->_relationship = $relationship;
	}

	public function getRelationship() {
		return $this->_relationship;
	}

	// finders and filters
	public function findByApplicationNumber($application_number) {
		return DParticipantRecord::finder()->find("application_number = :application_number", array(":application_number" => $application_number));
	}

	public function findByDeleted($deleted) {
		return DParticipantRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByParticipantId($participant_id) {
		return DParticipantRecord::finder()->find("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findByParticipantIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantRecord::finder()->find("participant_id IN ({$in_values})", $parameters);
	}

	public function findByRegisterDate($register_date) {
		return DParticipantRecord::finder()->find("register_date = :register_date", array(":register_date" => $register_date));
	}

	public function findByStartingNumber($starting_number) {
		return DParticipantRecord::finder()->find("starting_number = :starting_number", array(":starting_number" => $starting_number));
	}

	public function findByYear($year) {
		return DParticipantRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByApplicationNumber($application_number) {
		return DParticipantRecord::finder()->findOne("application_number = :application_number", array(":application_number" => $application_number));
	}

	public function findOneByDeleted($deleted) {
		return DParticipantRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipantRecord::finder()->findOne("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findOneByRegisterDate($register_date) {
		return DParticipantRecord::finder()->findOne("register_date = :register_date", array(":register_date" => $register_date));
	}

	public function findOneByStartingNumber($starting_number) {
		return DParticipantRecord::finder()->findOne("starting_number = :starting_number", array(":starting_number" => $starting_number));
	}

	public function findOneByYear($year) {
		return DParticipantRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByApplicationNumber($application_number) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByParticipantId($participant_id) {
	}

	public function filterByParticipantIds(array $ids) {
	}

	public function filterByRegisterDate($register_date) {
	}

	public function filterByStartingNumber($starting_number) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipantRecord extends DParticipantBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DParticipantClassificationBaseRecord extends FActiveRecord {

	public $TABLE = "participants_classifications";

	// properties
	public $classification_id;
	public $date;
	public $deleted;
	public $participant_classification_id;
	public $participant_id;

	public $TYPES = array(
		"classification_id" => "integer",
		"date" => "text",
		"deleted" => "integer",
		"participant_classification_id" => "integer",
		"participant_id" => "integer",
	);
	// foreign key objects
	private $_classification = null;
	private $_participant = null;



	// finders and filters
	public function findByClassificationId($classification_id) {
		return DParticipantClassificationRecord::finder()->find("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findByClassificationIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantClassificationRecord::finder()->find("classification_id IN ({$in_values})", $parameters);
	}

	public function findByDate($date) {
		return DParticipantClassificationRecord::finder()->find("date = :date", array(":date" => $date));
	}

	public function findByDeleted($deleted) {
		return DParticipantClassificationRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByParticipantClassificationId($participant_classification_id) {
		return DParticipantClassificationRecord::finder()->find("participant_classification_id = :participant_classification_id", array(":participant_classification_id" => $participant_classification_id));
	}

	public function findByParticipantClassificationIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantClassificationRecord::finder()->find("participant_classification_id IN ({$in_values})", $parameters);
	}

	public function findByParticipantId($participant_id) {
		return DParticipantClassificationRecord::finder()->find("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function findByParticipantIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DParticipantClassificationRecord::finder()->find("participant_id IN ({$in_values})", $parameters);
	}

	public function findOneByClassificationId($classification_id) {
		return DParticipantClassificationRecord::finder()->findOne("classification_id = :classification_id", array(":classification_id" => $classification_id));
	}

	public function findOneByDate($date) {
		return DParticipantClassificationRecord::finder()->findOne("date = :date", array(":date" => $date));
	}

	public function findOneByDeleted($deleted) {
		return DParticipantClassificationRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByParticipantClassificationId($participant_classification_id) {
		return DParticipantClassificationRecord::finder()->findOne("participant_classification_id = :participant_classification_id", array(":participant_classification_id" => $participant_classification_id));
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipantClassificationRecord::finder()->findOne("participant_id = :participant_id", array(":participant_id" => $participant_id));
	}

	public function filterByClassificationId($classification_id) {
	}

	public function filterByClassificationIds(array $ids) {
	}

	public function filterByDate($date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByParticipantClassificationId($participant_classification_id) {
	}

	public function filterByParticipantClassificationIds(array $ids) {
	}

	public function filterByParticipantId($participant_id) {
	}

	public function filterByParticipantIds(array $ids) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipantClassificationRecord extends DParticipantClassificationBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DPostBaseRecord extends FActiveRecord {

	public $TABLE = "posts";

	// properties
	public $admin_id;
	public $content;
	public $create_date;
	public $deleted;
	public $modify_date;
	public $post_id;
	public $status;
	public $thumbnail_id;
	public $title;

	public $TYPES = array(
		"admin_id" => "integer",
		"content" => "text",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"modify_date" => "timestamp with time zone",
		"post_id" => "integer",
		"status" => "text",
		"thumbnail_id" => "integer",
		"title" => "text",
	);
	// foreign key objects
	private $_admin = null;
	private $_thumbnail = null;

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findByPostId($this->post_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByAdminId($admin_id) {
		return DPostRecord::finder()->find("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findByAdminIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DPostRecord::finder()->find("admin_id IN ({$in_values})", $parameters);
	}

	public function findByContent($content) {
		return DPostRecord::finder()->find("content = :content", array(":content" => $content));
	}

	public function findByCreateDate($create_date) {
		return DPostRecord::finder()->find("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findByDeleted($deleted) {
		return DPostRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByModifyDate($modify_date) {
		return DPostRecord::finder()->find("modify_date = :modify_date", array(":modify_date" => $modify_date));
	}

	public function findByPostId($post_id) {
		return DPostRecord::finder()->find("post_id = :post_id", array(":post_id" => $post_id));
	}

	public function findByPostIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DPostRecord::finder()->find("post_id IN ({$in_values})", $parameters);
	}

	public function findByStatus($status) {
		return DPostRecord::finder()->find("status = :status", array(":status" => $status));
	}

	public function findByThumbnailId($thumbnail_id) {
		return DPostRecord::finder()->find("thumbnail_id = :thumbnail_id", array(":thumbnail_id" => $thumbnail_id));
	}

	public function findByThumbnailIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DPostRecord::finder()->find("thumbnail_id IN ({$in_values})", $parameters);
	}

	public function findByTitle($title) {
		return DPostRecord::finder()->find("title = :title", array(":title" => $title));
	}

	public function findOneByAdminId($admin_id) {
		return DPostRecord::finder()->findOne("admin_id = :admin_id", array(":admin_id" => $admin_id));
	}

	public function findOneByContent($content) {
		return DPostRecord::finder()->findOne("content = :content", array(":content" => $content));
	}

	public function findOneByCreateDate($create_date) {
		return DPostRecord::finder()->findOne("create_date = :create_date", array(":create_date" => $create_date));
	}

	public function findOneByDeleted($deleted) {
		return DPostRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByModifyDate($modify_date) {
		return DPostRecord::finder()->findOne("modify_date = :modify_date", array(":modify_date" => $modify_date));
	}

	public function findOneByPostId($post_id) {
		return DPostRecord::finder()->findOne("post_id = :post_id", array(":post_id" => $post_id));
	}

	public function findOneByStatus($status) {
		return DPostRecord::finder()->findOne("status = :status", array(":status" => $status));
	}

	public function findOneByThumbnailId($thumbnail_id) {
		return DPostRecord::finder()->findOne("thumbnail_id = :thumbnail_id", array(":thumbnail_id" => $thumbnail_id));
	}

	public function findOneByTitle($title) {
		return DPostRecord::finder()->findOne("title = :title", array(":title" => $title));
	}

	public function filterByAdminId($admin_id) {
	}

	public function filterByAdminIds(array $ids) {
	}

	public function filterByContent($content) {
	}

	public function filterByCreateDate($create_date) {
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByModifyDate($modify_date) {
	}

	public function filterByPostId($post_id) {
	}

	public function filterByPostIds(array $ids) {
	}

	public function filterByStatus($status) {
	}

	public function filterByThumbnailId($thumbnail_id) {
	}

	public function filterByThumbnailIds(array $ids) {
	}

	public function filterByTitle($title) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DPostRecord extends DPostBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DPrivilegeBaseRecord extends FActiveRecord {

	public $TABLE = "privileges";

	// properties
	public $deleted;
	public $description;
	public $name;
	public $privilege_id;

	public $TYPES = array(
		"deleted" => "integer",
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
			$admins_privileges = DAdminPrivilegeRecord::finder()->findByPrivilegeId($this->privilege_id);
			$admins_pks = array();
			foreach($admins_privileges as $a) {
				$admins_pks[] = $a->admin_id;
			}
			$this->_admins = DAdminRecord::finder()->findByPKs($admins_pks);
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

	// finders and filters
	public function findByDeleted($deleted) {
		return DPrivilegeRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByDescription($description) {
		return DPrivilegeRecord::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByName($name) {
		return DPrivilegeRecord::finder()->find("name = :name", array(":name" => $name));
	}

	public function findByPrivilegeId($privilege_id) {
		return DPrivilegeRecord::finder()->find("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
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
		return DPrivilegeRecord::finder()->find("privilege_id IN ({$in_values})", $parameters);
	}

	public function findOneByDeleted($deleted) {
		return DPrivilegeRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByDescription($description) {
		return DPrivilegeRecord::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByName($name) {
		return DPrivilegeRecord::finder()->findOne("name = :name", array(":name" => $name));
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DPrivilegeRecord::finder()->findOne("privilege_id = :privilege_id", array(":privilege_id" => $privilege_id));
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByDescription($description) {
	}

	public function filterByName($name) {
	}

	public function filterByPrivilegeId($privilege_id) {
	}

	public function filterByPrivilegeIds(array $ids) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DPrivilegeRecord extends DPrivilegeBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

class DSupporterBaseRecord extends FActiveRecord {

	public $TABLE = "supporters";

	// properties
	public $deleted;
	public $description;
	public $logo_id;
	public $position;
	public $supporter_id;
	public $type;
	public $url;
	public $year;

	public $TYPES = array(
		"deleted" => "integer",
		"description" => "text",
		"logo_id" => "integer",
		"position" => "integer",
		"supporter_id" => "integer",
		"type" => "text",
		"url" => "text",
		"year" => "text",
	);
	// foreign key objects
	private $_logo = null;

	// relationships objects
	private $_events = null;

	// relationship methods
	public function getEvents() {
		if($this->_events === null) {
			$this->_events = DEventRecord::finder()->findBySupporterId($this->supporter_id);
		}
		return $this->_events;
		}


	// finders and filters
	public function findByDeleted($deleted) {
		return DSupporterRecord::finder()->find("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findByDescription($description) {
		return DSupporterRecord::finder()->find("description = :description", array(":description" => $description));
	}

	public function findByLogoId($logo_id) {
		return DSupporterRecord::finder()->find("logo_id = :logo_id", array(":logo_id" => $logo_id));
	}

	public function findByLogoIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DSupporterRecord::finder()->find("logo_id IN ({$in_values})", $parameters);
	}

	public function findByPosition($position) {
		return DSupporterRecord::finder()->find("position = :position", array(":position" => $position));
	}

	public function findBySupporterId($supporter_id) {
		return DSupporterRecord::finder()->find("supporter_id = :supporter_id", array(":supporter_id" => $supporter_id));
	}

	public function findBySupporterIds(array $ids) {
		$i = 0;
		$parameters = array();
		$in_values = "";
		foreach ($ids as $id) {
			$in_values .= ":id{$i}, ";
			$parameters[":id{$i}"] = $id;
			$i++;
		}
		$in_values = substr($in_values, 0, strlen($in_values) - 2);
		return DSupporterRecord::finder()->find("supporter_id IN ({$in_values})", $parameters);
	}

	public function findByType($type) {
		return DSupporterRecord::finder()->find("type = :type", array(":type" => $type));
	}

	public function findByUrl($url) {
		return DSupporterRecord::finder()->find("url = :url", array(":url" => $url));
	}

	public function findByYear($year) {
		return DSupporterRecord::finder()->find("year = :year", array(":year" => $year));
	}

	public function findOneByDeleted($deleted) {
		return DSupporterRecord::finder()->findOne("deleted = :deleted", array(":deleted" => $deleted));
	}

	public function findOneByDescription($description) {
		return DSupporterRecord::finder()->findOne("description = :description", array(":description" => $description));
	}

	public function findOneByLogoId($logo_id) {
		return DSupporterRecord::finder()->findOne("logo_id = :logo_id", array(":logo_id" => $logo_id));
	}

	public function findOneByPosition($position) {
		return DSupporterRecord::finder()->findOne("position = :position", array(":position" => $position));
	}

	public function findOneBySupporterId($supporter_id) {
		return DSupporterRecord::finder()->findOne("supporter_id = :supporter_id", array(":supporter_id" => $supporter_id));
	}

	public function findOneByType($type) {
		return DSupporterRecord::finder()->findOne("type = :type", array(":type" => $type));
	}

	public function findOneByUrl($url) {
		return DSupporterRecord::finder()->findOne("url = :url", array(":url" => $url));
	}

	public function findOneByYear($year) {
		return DSupporterRecord::finder()->findOne("year = :year", array(":year" => $year));
	}

	public function filterByDeleted($deleted) {
	}

	public function filterByDescription($description) {
	}

	public function filterByLogoId($logo_id) {
	}

	public function filterByLogoIds(array $ids) {
	}

	public function filterByPosition($position) {
	}

	public function filterBySupporterId($supporter_id) {
	}

	public function filterBySupporterIds(array $ids) {
	}

	public function filterByType($type) {
	}

	public function filterByUrl($url) {
	}

	public function filterByYear($year) {
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DSupporterRecord extends DSupporterBaseRecord {

	public static function finder() {
		return new self ();
	}

	public function save() {
		return parent::save();
	}

}

