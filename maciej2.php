<?php

use Repel\Framework\RActiveRecord;
use Repel\Framework\RActiveQuery;

class _BaseActiveRecords {};

class DAdminBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByAdminId($this->admin_id);
		}
		return $this->_events;
		}

	public function getPosts() {
		if($this->_posts === null) {
			$this->_posts = DPost::finder()->findByAdminId($this->admin_id);
		}
		return $this->_posts;
		}

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
		"deleted" => "integer",
		"email" => "text",
		"login" => "text",
	);
	public function findByAdminId($admin_id) {
		return DAdmin::finder()->findBy("admin_id", $admin_id);
	}

	public function findByDeleted($deleted) {
		return DAdmin::finder()->findBy("deleted", $deleted);
	}

	public function findByEmail($email) {
		return DAdmin::finder()->findBy("email", $email);
	}

	public function findByLogin($login) {
		return DAdmin::finder()->findBy("login", $login);
	}

	public function findOneByAdminId($admin_id) {
		return DAdmin::finder()->findOneBy("admin_id", $admin_id);
	}

	public function findOneByDeleted($deleted) {
		return DAdmin::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByEmail($email) {
		return DAdmin::finder()->findOneBy("email", $email);
	}

	public function findOneByLogin($login) {
		return DAdmin::finder()->findOneBy("login", $login);
	}

	public function filterByAdminId($admin_id) {
		return DAdmin::finder()->filterBy("admin_id", $admin_id);
	}

	public function filterByDeleted($deleted) {
		return DAdmin::finder()->filterBy("deleted", $deleted);
	}

	public function filterByEmail($email) {
		return DAdmin::finder()->filterBy("email", $email);
	}

	public function filterByLogin($login) {
		return DAdmin::finder()->filterBy("login", $login);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdmin extends DAdminBase {

	public function save() {
		return parent::save();
	}

}



class DAdminQuery extends DAdminBaseQuery {

}

class DAdminPrivilegeBase extends RActiveRecord {

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


}

class DAdminPrivilegeBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"admin_id" => "integer",
		"admin_privilege_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"privilege_id" => "integer",
	);
	public function findByAdminId($admin_id) {
		return DAdminPrivilege::finder()->findBy("admin_id", $admin_id);
	}

	public function findByAdminPrivilegeId($admin_privilege_id) {
		return DAdminPrivilege::finder()->findBy("admin_privilege_id", $admin_privilege_id);
	}

	public function findByCreateDate($create_date) {
		return DAdminPrivilege::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DAdminPrivilege::finder()->findBy("deleted", $deleted);
	}

	public function findByPrivilegeId($privilege_id) {
		return DAdminPrivilege::finder()->findBy("privilege_id", $privilege_id);
	}

	public function findOneByAdminId($admin_id) {
		return DAdminPrivilege::finder()->findOneBy("admin_id", $admin_id);
	}

	public function findOneByAdminPrivilegeId($admin_privilege_id) {
		return DAdminPrivilege::finder()->findOneBy("admin_privilege_id", $admin_privilege_id);
	}

	public function findOneByCreateDate($create_date) {
		return DAdminPrivilege::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DAdminPrivilege::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DAdminPrivilege::finder()->findOneBy("privilege_id", $privilege_id);
	}

	public function filterByAdminId($admin_id) {
		return DAdminPrivilege::finder()->filterBy("admin_id", $admin_id);
	}

	public function filterByAdminPrivilegeId($admin_privilege_id) {
		return DAdminPrivilege::finder()->filterBy("admin_privilege_id", $admin_privilege_id);
	}

	public function filterByCreateDate($create_date) {
		return DAdminPrivilege::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DAdminPrivilege::finder()->filterBy("deleted", $deleted);
	}

	public function filterByPrivilegeId($privilege_id) {
		return DAdminPrivilege::finder()->filterBy("privilege_id", $privilege_id);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAdminPrivilege extends DAdminPrivilegeBase {

	public function save() {
		return parent::save();
	}

}



class DAdminPrivilegeQuery extends DAdminPrivilegeBaseQuery {

}

class DAgeCategoryBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByAgeCategoryId($this->age_category_id);
		}
		return $this->_events;
		}

}

class DAgeCategoryBaseQuery extends RActiveQuery {

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
	public function findByAgeCategoryId($age_category_id) {
		return DAgeCategory::finder()->findBy("age_category_id", $age_category_id);
	}

	public function findByAgeFrom($age_from) {
		return DAgeCategory::finder()->findBy("age_from", $age_from);
	}

	public function findByAgeTo($age_to) {
		return DAgeCategory::finder()->findBy("age_to", $age_to);
	}

	public function findByCreateDate($create_date) {
		return DAgeCategory::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DAgeCategory::finder()->findBy("deleted", $deleted);
	}

	public function findByName($name) {
		return DAgeCategory::finder()->findBy("name", $name);
	}

	public function findBySex($sex) {
		return DAgeCategory::finder()->findBy("sex", $sex);
	}

	public function findByYear($year) {
		return DAgeCategory::finder()->findBy("year", $year);
	}

	public function findOneByAgeCategoryId($age_category_id) {
		return DAgeCategory::finder()->findOneBy("age_category_id", $age_category_id);
	}

	public function findOneByAgeFrom($age_from) {
		return DAgeCategory::finder()->findOneBy("age_from", $age_from);
	}

	public function findOneByAgeTo($age_to) {
		return DAgeCategory::finder()->findOneBy("age_to", $age_to);
	}

	public function findOneByCreateDate($create_date) {
		return DAgeCategory::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DAgeCategory::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByName($name) {
		return DAgeCategory::finder()->findOneBy("name", $name);
	}

	public function findOneBySex($sex) {
		return DAgeCategory::finder()->findOneBy("sex", $sex);
	}

	public function findOneByYear($year) {
		return DAgeCategory::finder()->findOneBy("year", $year);
	}

	public function filterByAgeCategoryId($age_category_id) {
		return DAgeCategory::finder()->filterBy("age_category_id", $age_category_id);
	}

	public function filterByAgeFrom($age_from) {
		return DAgeCategory::finder()->filterBy("age_from", $age_from);
	}

	public function filterByAgeTo($age_to) {
		return DAgeCategory::finder()->filterBy("age_to", $age_to);
	}

	public function filterByCreateDate($create_date) {
		return DAgeCategory::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DAgeCategory::finder()->filterBy("deleted", $deleted);
	}

	public function filterByName($name) {
		return DAgeCategory::finder()->filterBy("name", $name);
	}

	public function filterBySex($sex) {
		return DAgeCategory::finder()->filterBy("sex", $sex);
	}

	public function filterByYear($year) {
		return DAgeCategory::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DAgeCategory extends DAgeCategoryBase {

	public function save() {
		return parent::save();
	}

}



class DAgeCategoryQuery extends DAgeCategoryBaseQuery {

}

class DChildrenRunGroupBase extends RActiveRecord {

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
			$this->_childrens_runs_participants = DChildrenRunParticipant::finder()->findByChildrenRunGroupId($this->children_run_group_id);
		}
		return $this->_childrens_runs_participants;
		}

}

class DChildrenRunGroupBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"active" => "integer",
		"children_run_group_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"limit" => "integer",
		"name" => "text",
		"year" => "integer",
	);
	public function findByActive($active) {
		return DChildrenRunGroup::finder()->findBy("active", $active);
	}

	public function findByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunGroup::finder()->findBy("children_run_group_id", $children_run_group_id);
	}

	public function findByCreateDate($create_date) {
		return DChildrenRunGroup::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DChildrenRunGroup::finder()->findBy("deleted", $deleted);
	}

	public function findByLimit($limit) {
		return DChildrenRunGroup::finder()->findBy("limit", $limit);
	}

	public function findByName($name) {
		return DChildrenRunGroup::finder()->findBy("name", $name);
	}

	public function findByYear($year) {
		return DChildrenRunGroup::finder()->findBy("year", $year);
	}

	public function findOneByActive($active) {
		return DChildrenRunGroup::finder()->findOneBy("active", $active);
	}

	public function findOneByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunGroup::finder()->findOneBy("children_run_group_id", $children_run_group_id);
	}

	public function findOneByCreateDate($create_date) {
		return DChildrenRunGroup::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DChildrenRunGroup::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByLimit($limit) {
		return DChildrenRunGroup::finder()->findOneBy("limit", $limit);
	}

	public function findOneByName($name) {
		return DChildrenRunGroup::finder()->findOneBy("name", $name);
	}

	public function findOneByYear($year) {
		return DChildrenRunGroup::finder()->findOneBy("year", $year);
	}

	public function filterByActive($active) {
		return DChildrenRunGroup::finder()->filterBy("active", $active);
	}

	public function filterByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunGroup::finder()->filterBy("children_run_group_id", $children_run_group_id);
	}

	public function filterByCreateDate($create_date) {
		return DChildrenRunGroup::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DChildrenRunGroup::finder()->filterBy("deleted", $deleted);
	}

	public function filterByLimit($limit) {
		return DChildrenRunGroup::finder()->filterBy("limit", $limit);
	}

	public function filterByName($name) {
		return DChildrenRunGroup::finder()->filterBy("name", $name);
	}

	public function filterByYear($year) {
		return DChildrenRunGroup::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DChildrenRunGroup extends DChildrenRunGroupBase {

	public function save() {
		return parent::save();
	}

}



class DChildrenRunGroupQuery extends DChildrenRunGroupBaseQuery {

}

class DChildrenRunParticipantBase extends RActiveRecord {

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


}

class DChildrenRunParticipantBaseQuery extends RActiveQuery {

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
	public function findByBirthDate($birth_date) {
		return DChildrenRunParticipant::finder()->findBy("birth_date", $birth_date);
	}

	public function findByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunParticipant::finder()->findBy("children_run_group_id", $children_run_group_id);
	}

	public function findByChildrenRunParticipantId($children_run_participant_id) {
		return DChildrenRunParticipant::finder()->findBy("children_run_participant_id", $children_run_participant_id);
	}

	public function findByCity($city) {
		return DChildrenRunParticipant::finder()->findBy("city", $city);
	}

	public function findByDeleted($deleted) {
		return DChildrenRunParticipant::finder()->findBy("deleted", $deleted);
	}

	public function findByFirstName($first_name) {
		return DChildrenRunParticipant::finder()->findBy("first_name", $first_name);
	}

	public function findByLastName($last_name) {
		return DChildrenRunParticipant::finder()->findBy("last_name", $last_name);
	}

	public function findByRegisterDate($register_date) {
		return DChildrenRunParticipant::finder()->findBy("register_date", $register_date);
	}

	public function findByYear($year) {
		return DChildrenRunParticipant::finder()->findBy("year", $year);
	}

	public function findOneByBirthDate($birth_date) {
		return DChildrenRunParticipant::finder()->findOneBy("birth_date", $birth_date);
	}

	public function findOneByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunParticipant::finder()->findOneBy("children_run_group_id", $children_run_group_id);
	}

	public function findOneByChildrenRunParticipantId($children_run_participant_id) {
		return DChildrenRunParticipant::finder()->findOneBy("children_run_participant_id", $children_run_participant_id);
	}

	public function findOneByCity($city) {
		return DChildrenRunParticipant::finder()->findOneBy("city", $city);
	}

	public function findOneByDeleted($deleted) {
		return DChildrenRunParticipant::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByFirstName($first_name) {
		return DChildrenRunParticipant::finder()->findOneBy("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return DChildrenRunParticipant::finder()->findOneBy("last_name", $last_name);
	}

	public function findOneByRegisterDate($register_date) {
		return DChildrenRunParticipant::finder()->findOneBy("register_date", $register_date);
	}

	public function findOneByYear($year) {
		return DChildrenRunParticipant::finder()->findOneBy("year", $year);
	}

	public function filterByBirthDate($birth_date) {
		return DChildrenRunParticipant::finder()->filterBy("birth_date", $birth_date);
	}

	public function filterByChildrenRunGroupId($children_run_group_id) {
		return DChildrenRunParticipant::finder()->filterBy("children_run_group_id", $children_run_group_id);
	}

	public function filterByChildrenRunParticipantId($children_run_participant_id) {
		return DChildrenRunParticipant::finder()->filterBy("children_run_participant_id", $children_run_participant_id);
	}

	public function filterByCity($city) {
		return DChildrenRunParticipant::finder()->filterBy("city", $city);
	}

	public function filterByDeleted($deleted) {
		return DChildrenRunParticipant::finder()->filterBy("deleted", $deleted);
	}

	public function filterByFirstName($first_name) {
		return DChildrenRunParticipant::finder()->filterBy("first_name", $first_name);
	}

	public function filterByLastName($last_name) {
		return DChildrenRunParticipant::finder()->filterBy("last_name", $last_name);
	}

	public function filterByRegisterDate($register_date) {
		return DChildrenRunParticipant::finder()->filterBy("register_date", $register_date);
	}

	public function filterByYear($year) {
		return DChildrenRunParticipant::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DChildrenRunParticipant extends DChildrenRunParticipantBase {

	public function save() {
		return parent::save();
	}

}



class DChildrenRunParticipantQuery extends DChildrenRunParticipantBaseQuery {

}

class DClassificationBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByClassificationId($this->classification_id);
		}
		return $this->_events;
		}

	public function getParticipants() {
		if($this->_participants === null) {
			$participants_classifications = DParticipantClassification::finder()->findByClassificationId($this->classification_id);
			$participants_pks = array();
			foreach($participants_classifications as $p) {
				$participants_pks[] = $p->participant_id;
			}
			$this->_participants = DParticipant::finder()->findByPKs($participants_pks);
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
}

class DClassificationBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"classification_id" => "integer",
		"create_date" => "timestamp with time zone",
		"deleted" => "integer",
		"description" => "text",
		"name" => "text",
		"year" => "text",
	);
	public function findByClassificationId($classification_id) {
		return DClassification::finder()->findBy("classification_id", $classification_id);
	}

	public function findByCreateDate($create_date) {
		return DClassification::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DClassification::finder()->findBy("deleted", $deleted);
	}

	public function findByDescription($description) {
		return DClassification::finder()->findBy("description", $description);
	}

	public function findByName($name) {
		return DClassification::finder()->findBy("name", $name);
	}

	public function findByYear($year) {
		return DClassification::finder()->findBy("year", $year);
	}

	public function findOneByClassificationId($classification_id) {
		return DClassification::finder()->findOneBy("classification_id", $classification_id);
	}

	public function findOneByCreateDate($create_date) {
		return DClassification::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DClassification::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByDescription($description) {
		return DClassification::finder()->findOneBy("description", $description);
	}

	public function findOneByName($name) {
		return DClassification::finder()->findOneBy("name", $name);
	}

	public function findOneByYear($year) {
		return DClassification::finder()->findOneBy("year", $year);
	}

	public function filterByClassificationId($classification_id) {
		return DClassification::finder()->filterBy("classification_id", $classification_id);
	}

	public function filterByCreateDate($create_date) {
		return DClassification::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DClassification::finder()->filterBy("deleted", $deleted);
	}

	public function filterByDescription($description) {
		return DClassification::finder()->filterBy("description", $description);
	}

	public function filterByName($name) {
		return DClassification::finder()->filterBy("name", $name);
	}

	public function filterByYear($year) {
		return DClassification::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DClassification extends DClassificationBase {

	public function save() {
		return parent::save();
	}

}



class DClassificationQuery extends DClassificationBaseQuery {

}

class DClubBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByClubId($this->club_id);
		}
		return $this->_events;
		}

	public function getParticipantDatas() {
		if($this->_participant_datas === null) {
			$this->_participant_datas = DParticipantData::finder()->findByClubId($this->club_id);
		}
		return $this->_participant_datas;
		}

}

class DClubBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"club_id" => "integer",
		"deleted" => "integer",
		"name" => "text",
		"year" => "text",
	);
	public function findByClubId($club_id) {
		return DClub::finder()->findBy("club_id", $club_id);
	}

	public function findByDeleted($deleted) {
		return DClub::finder()->findBy("deleted", $deleted);
	}

	public function findByName($name) {
		return DClub::finder()->findBy("name", $name);
	}

	public function findByYear($year) {
		return DClub::finder()->findBy("year", $year);
	}

	public function findOneByClubId($club_id) {
		return DClub::finder()->findOneBy("club_id", $club_id);
	}

	public function findOneByDeleted($deleted) {
		return DClub::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByName($name) {
		return DClub::finder()->findOneBy("name", $name);
	}

	public function findOneByYear($year) {
		return DClub::finder()->findOneBy("year", $year);
	}

	public function filterByClubId($club_id) {
		return DClub::finder()->filterBy("club_id", $club_id);
	}

	public function filterByDeleted($deleted) {
		return DClub::finder()->filterBy("deleted", $deleted);
	}

	public function filterByName($name) {
		return DClub::finder()->filterBy("name", $name);
	}

	public function filterByYear($year) {
		return DClub::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DClub extends DClubBase {

	public function save() {
		return parent::save();
	}

}



class DClubQuery extends DClubBaseQuery {

}

class DCommentBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByCommentId($this->comment_id);
		}
		return $this->_events;
		}

}

class DCommentBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"comment" => "text",
		"comment_id" => "integer",
		"date" => "timestamp with time zone",
		"deleted" => "integer",
		"full_name" => "text",
		"year" => "text",
	);
	public function findByComment($comment) {
		return DComment::finder()->findBy("comment", $comment);
	}

	public function findByCommentId($comment_id) {
		return DComment::finder()->findBy("comment_id", $comment_id);
	}

	public function findByDate($date) {
		return DComment::finder()->findBy("date", $date);
	}

	public function findByDeleted($deleted) {
		return DComment::finder()->findBy("deleted", $deleted);
	}

	public function findByFullName($full_name) {
		return DComment::finder()->findBy("full_name", $full_name);
	}

	public function findByYear($year) {
		return DComment::finder()->findBy("year", $year);
	}

	public function findOneByComment($comment) {
		return DComment::finder()->findOneBy("comment", $comment);
	}

	public function findOneByCommentId($comment_id) {
		return DComment::finder()->findOneBy("comment_id", $comment_id);
	}

	public function findOneByDate($date) {
		return DComment::finder()->findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return DComment::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByFullName($full_name) {
		return DComment::finder()->findOneBy("full_name", $full_name);
	}

	public function findOneByYear($year) {
		return DComment::finder()->findOneBy("year", $year);
	}

	public function filterByComment($comment) {
		return DComment::finder()->filterBy("comment", $comment);
	}

	public function filterByCommentId($comment_id) {
		return DComment::finder()->filterBy("comment_id", $comment_id);
	}

	public function filterByDate($date) {
		return DComment::finder()->filterBy("date", $date);
	}

	public function filterByDeleted($deleted) {
		return DComment::finder()->filterBy("deleted", $deleted);
	}

	public function filterByFullName($full_name) {
		return DComment::finder()->filterBy("full_name", $full_name);
	}

	public function filterByYear($year) {
		return DComment::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DComment extends DCommentBase {

	public function save() {
		return parent::save();
	}

}



class DCommentQuery extends DCommentBaseQuery {

}

class DConfigBase extends RActiveRecord {

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


}

class DConfigBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"date" => "text",
		"deleted" => "integer",
		"key" => "character varying",
		"value" => "text",
	);
	public function findByDate($date) {
		return DConfig::finder()->findBy("date", $date);
	}

	public function findByDeleted($deleted) {
		return DConfig::finder()->findBy("deleted", $deleted);
	}

	public function findByKey($key) {
		return DConfig::finder()->findBy("key", $key);
	}

	public function findByValue($value) {
		return DConfig::finder()->findBy("value", $value);
	}

	public function findOneByDate($date) {
		return DConfig::finder()->findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return DConfig::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByKey($key) {
		return DConfig::finder()->findOneBy("key", $key);
	}

	public function findOneByValue($value) {
		return DConfig::finder()->findOneBy("value", $value);
	}

	public function filterByDate($date) {
		return DConfig::finder()->filterBy("date", $date);
	}

	public function filterByDeleted($deleted) {
		return DConfig::finder()->filterBy("deleted", $deleted);
	}

	public function filterByKey($key) {
		return DConfig::finder()->filterBy("key", $key);
	}

	public function filterByValue($value) {
		return DConfig::finder()->filterBy("value", $value);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DConfig extends DConfigBase {

	public function save() {
		return parent::save();
	}

}



class DConfigQuery extends DConfigBaseQuery {

}

class DConfigHistoryBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByConfigHistoryId($this->config_history_id);
		}
		return $this->_events;
		}

}

class DConfigHistoryBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"config_history_id" => "integer",
		"date" => "timestamp with time zone",
		"key" => "text",
		"value" => "text",
	);
	public function findByConfigHistoryId($config_history_id) {
		return DConfigHistory::finder()->findBy("config_history_id", $config_history_id);
	}

	public function findByDate($date) {
		return DConfigHistory::finder()->findBy("date", $date);
	}

	public function findByKey($key) {
		return DConfigHistory::finder()->findBy("key", $key);
	}

	public function findByValue($value) {
		return DConfigHistory::finder()->findBy("value", $value);
	}

	public function findOneByConfigHistoryId($config_history_id) {
		return DConfigHistory::finder()->findOneBy("config_history_id", $config_history_id);
	}

	public function findOneByDate($date) {
		return DConfigHistory::finder()->findOneBy("date", $date);
	}

	public function findOneByKey($key) {
		return DConfigHistory::finder()->findOneBy("key", $key);
	}

	public function findOneByValue($value) {
		return DConfigHistory::finder()->findOneBy("value", $value);
	}

	public function filterByConfigHistoryId($config_history_id) {
		return DConfigHistory::finder()->filterBy("config_history_id", $config_history_id);
	}

	public function filterByDate($date) {
		return DConfigHistory::finder()->filterBy("date", $date);
	}

	public function filterByKey($key) {
		return DConfigHistory::finder()->filterBy("key", $key);
	}

	public function filterByValue($value) {
		return DConfigHistory::finder()->filterBy("value", $value);
	}

	// others
}


class DConfigHistory extends DConfigHistoryBase {

	public function save() {
		return parent::save();
	}

}



class DConfigHistoryQuery extends DConfigHistoryBaseQuery {

}

class DEventBase extends RActiveRecord {

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


}

class DEventBaseQuery extends RActiveQuery {

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
	public function findByAdminId($admin_id) {
		return DEvent::finder()->findBy("admin_id", $admin_id);
	}

	public function findByAgeCategoryId($age_category_id) {
		return DEvent::finder()->findBy("age_category_id", $age_category_id);
	}

	public function findByClassificationId($classification_id) {
		return DEvent::finder()->findBy("classification_id", $classification_id);
	}

	public function findByClubId($club_id) {
		return DEvent::finder()->findBy("club_id", $club_id);
	}

	public function findByCommentId($comment_id) {
		return DEvent::finder()->findBy("comment_id", $comment_id);
	}

	public function findByConfigHistoryId($config_history_id) {
		return DEvent::finder()->findBy("config_history_id", $config_history_id);
	}

	public function findByDate($date) {
		return DEvent::finder()->findBy("date", $date);
	}

	public function findByDeleted($deleted) {
		return DEvent::finder()->findBy("deleted", $deleted);
	}

	public function findByEventId($event_id) {
		return DEvent::finder()->findBy("event_id", $event_id);
	}

	public function findByIp($ip) {
		return DEvent::finder()->findBy("ip", $ip);
	}

	public function findByModuleId($module_id) {
		return DEvent::finder()->findBy("module_id", $module_id);
	}

	public function findByParams($params) {
		return DEvent::finder()->findBy("params", $params);
	}

	public function findByParticipantDataId($participant_data_id) {
		return DEvent::finder()->findBy("participant_data_id", $participant_data_id);
	}

	public function findByParticipantId($participant_id) {
		return DEvent::finder()->findBy("participant_id", $participant_id);
	}

	public function findByPostId($post_id) {
		return DEvent::finder()->findBy("post_id", $post_id);
	}

	public function findBySupporterId($supporter_id) {
		return DEvent::finder()->findBy("supporter_id", $supporter_id);
	}

	public function findByType($type) {
		return DEvent::finder()->findBy("type", $type);
	}

	public function findOneByAdminId($admin_id) {
		return DEvent::finder()->findOneBy("admin_id", $admin_id);
	}

	public function findOneByAgeCategoryId($age_category_id) {
		return DEvent::finder()->findOneBy("age_category_id", $age_category_id);
	}

	public function findOneByClassificationId($classification_id) {
		return DEvent::finder()->findOneBy("classification_id", $classification_id);
	}

	public function findOneByClubId($club_id) {
		return DEvent::finder()->findOneBy("club_id", $club_id);
	}

	public function findOneByCommentId($comment_id) {
		return DEvent::finder()->findOneBy("comment_id", $comment_id);
	}

	public function findOneByConfigHistoryId($config_history_id) {
		return DEvent::finder()->findOneBy("config_history_id", $config_history_id);
	}

	public function findOneByDate($date) {
		return DEvent::finder()->findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return DEvent::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByEventId($event_id) {
		return DEvent::finder()->findOneBy("event_id", $event_id);
	}

	public function findOneByIp($ip) {
		return DEvent::finder()->findOneBy("ip", $ip);
	}

	public function findOneByModuleId($module_id) {
		return DEvent::finder()->findOneBy("module_id", $module_id);
	}

	public function findOneByParams($params) {
		return DEvent::finder()->findOneBy("params", $params);
	}

	public function findOneByParticipantDataId($participant_data_id) {
		return DEvent::finder()->findOneBy("participant_data_id", $participant_data_id);
	}

	public function findOneByParticipantId($participant_id) {
		return DEvent::finder()->findOneBy("participant_id", $participant_id);
	}

	public function findOneByPostId($post_id) {
		return DEvent::finder()->findOneBy("post_id", $post_id);
	}

	public function findOneBySupporterId($supporter_id) {
		return DEvent::finder()->findOneBy("supporter_id", $supporter_id);
	}

	public function findOneByType($type) {
		return DEvent::finder()->findOneBy("type", $type);
	}

	public function filterByAdminId($admin_id) {
		return DEvent::finder()->filterBy("admin_id", $admin_id);
	}

	public function filterByAgeCategoryId($age_category_id) {
		return DEvent::finder()->filterBy("age_category_id", $age_category_id);
	}

	public function filterByClassificationId($classification_id) {
		return DEvent::finder()->filterBy("classification_id", $classification_id);
	}

	public function filterByClubId($club_id) {
		return DEvent::finder()->filterBy("club_id", $club_id);
	}

	public function filterByCommentId($comment_id) {
		return DEvent::finder()->filterBy("comment_id", $comment_id);
	}

	public function filterByConfigHistoryId($config_history_id) {
		return DEvent::finder()->filterBy("config_history_id", $config_history_id);
	}

	public function filterByDate($date) {
		return DEvent::finder()->filterBy("date", $date);
	}

	public function filterByDeleted($deleted) {
		return DEvent::finder()->filterBy("deleted", $deleted);
	}

	public function filterByEventId($event_id) {
		return DEvent::finder()->filterBy("event_id", $event_id);
	}

	public function filterByIp($ip) {
		return DEvent::finder()->filterBy("ip", $ip);
	}

	public function filterByModuleId($module_id) {
		return DEvent::finder()->filterBy("module_id", $module_id);
	}

	public function filterByParams($params) {
		return DEvent::finder()->filterBy("params", $params);
	}

	public function filterByParticipantDataId($participant_data_id) {
		return DEvent::finder()->filterBy("participant_data_id", $participant_data_id);
	}

	public function filterByParticipantId($participant_id) {
		return DEvent::finder()->filterBy("participant_id", $participant_id);
	}

	public function filterByPostId($post_id) {
		return DEvent::finder()->filterBy("post_id", $post_id);
	}

	public function filterBySupporterId($supporter_id) {
		return DEvent::finder()->filterBy("supporter_id", $supporter_id);
	}

	public function filterByType($type) {
		return DEvent::finder()->filterBy("type", $type);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DEvent extends DEventBase {

	public function save() {
		return parent::save();
	}

}



class DEventQuery extends DEventBaseQuery {

}

class DMediaBase extends RActiveRecord {

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
			$this->_posts = DPost::finder()->findByMediaId($this->media_id);
		}
		return $this->_posts;
		}

	public function getSupporters() {
		if($this->_supporters === null) {
			$this->_supporters = DSupporter::finder()->findByMediaId($this->media_id);
		}
		return $this->_supporters;
		}

}

class DMediaBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"deleted" => "integer",
		"description" => "text",
		"description_alt" => "text",
		"media_id" => "integer",
		"path" => "text",
		"type" => "text",
		"upload_date" => "timestamp with time zone",
	);
	public function findByDeleted($deleted) {
		return DMedia::finder()->findBy("deleted", $deleted);
	}

	public function findByDescription($description) {
		return DMedia::finder()->findBy("description", $description);
	}

	public function findByDescriptionAlt($description_alt) {
		return DMedia::finder()->findBy("description_alt", $description_alt);
	}

	public function findByMediaId($media_id) {
		return DMedia::finder()->findBy("media_id", $media_id);
	}

	public function findByPath($path) {
		return DMedia::finder()->findBy("path", $path);
	}

	public function findByType($type) {
		return DMedia::finder()->findBy("type", $type);
	}

	public function findByUploadDate($upload_date) {
		return DMedia::finder()->findBy("upload_date", $upload_date);
	}

	public function findOneByDeleted($deleted) {
		return DMedia::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByDescription($description) {
		return DMedia::finder()->findOneBy("description", $description);
	}

	public function findOneByDescriptionAlt($description_alt) {
		return DMedia::finder()->findOneBy("description_alt", $description_alt);
	}

	public function findOneByMediaId($media_id) {
		return DMedia::finder()->findOneBy("media_id", $media_id);
	}

	public function findOneByPath($path) {
		return DMedia::finder()->findOneBy("path", $path);
	}

	public function findOneByType($type) {
		return DMedia::finder()->findOneBy("type", $type);
	}

	public function findOneByUploadDate($upload_date) {
		return DMedia::finder()->findOneBy("upload_date", $upload_date);
	}

	public function filterByDeleted($deleted) {
		return DMedia::finder()->filterBy("deleted", $deleted);
	}

	public function filterByDescription($description) {
		return DMedia::finder()->filterBy("description", $description);
	}

	public function filterByDescriptionAlt($description_alt) {
		return DMedia::finder()->filterBy("description_alt", $description_alt);
	}

	public function filterByMediaId($media_id) {
		return DMedia::finder()->filterBy("media_id", $media_id);
	}

	public function filterByPath($path) {
		return DMedia::finder()->filterBy("path", $path);
	}

	public function filterByType($type) {
		return DMedia::finder()->filterBy("type", $type);
	}

	public function filterByUploadDate($upload_date) {
		return DMedia::finder()->filterBy("upload_date", $upload_date);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DMedia extends DMediaBase {

	public function save() {
		return parent::save();
	}

}



class DMediaQuery extends DMediaBaseQuery {

}

class DModuleBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByModuleId($this->module_id);
		}
		return $this->_events;
		}

	public function getModulesConfig() {
		if($this->_modules_config === null) {
			$this->_modules_config = DModuleConfig::finder()->findByModuleId($this->module_id);
		}
		return $this->_modules_config;
		}

	public function getModulesConfigHistory() {
		if($this->_modules_config_history === null) {
			$this->_modules_config_history = DModuleConfigHistory::finder()->findByModuleId($this->module_id);
		}
		return $this->_modules_config_history;
		}

}

class DModuleBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"active" => "integer",
		"deleted" => "integer",
		"description" => "text",
		"key" => "text",
		"module_id" => "integer",
		"name" => "text",
	);
	public function findByActive($active) {
		return DModule::finder()->findBy("active", $active);
	}

	public function findByDeleted($deleted) {
		return DModule::finder()->findBy("deleted", $deleted);
	}

	public function findByDescription($description) {
		return DModule::finder()->findBy("description", $description);
	}

	public function findByKey($key) {
		return DModule::finder()->findBy("key", $key);
	}

	public function findByModuleId($module_id) {
		return DModule::finder()->findBy("module_id", $module_id);
	}

	public function findByName($name) {
		return DModule::finder()->findBy("name", $name);
	}

	public function findOneByActive($active) {
		return DModule::finder()->findOneBy("active", $active);
	}

	public function findOneByDeleted($deleted) {
		return DModule::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByDescription($description) {
		return DModule::finder()->findOneBy("description", $description);
	}

	public function findOneByKey($key) {
		return DModule::finder()->findOneBy("key", $key);
	}

	public function findOneByModuleId($module_id) {
		return DModule::finder()->findOneBy("module_id", $module_id);
	}

	public function findOneByName($name) {
		return DModule::finder()->findOneBy("name", $name);
	}

	public function filterByActive($active) {
		return DModule::finder()->filterBy("active", $active);
	}

	public function filterByDeleted($deleted) {
		return DModule::finder()->filterBy("deleted", $deleted);
	}

	public function filterByDescription($description) {
		return DModule::finder()->filterBy("description", $description);
	}

	public function filterByKey($key) {
		return DModule::finder()->filterBy("key", $key);
	}

	public function filterByModuleId($module_id) {
		return DModule::finder()->filterBy("module_id", $module_id);
	}

	public function filterByName($name) {
		return DModule::finder()->filterBy("name", $name);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DModule extends DModuleBase {

	public function save() {
		return parent::save();
	}

}



class DModuleQuery extends DModuleBaseQuery {

}

class DModuleConfigBase extends RActiveRecord {

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


}

class DModuleConfigBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"key" => "text",
		"module_config_id" => "integer",
		"module_id" => "integer",
		"value" => "text",
	);
	public function findByKey($key) {
		return DModuleConfig::finder()->findBy("key", $key);
	}

	public function findByModuleConfigId($module_config_id) {
		return DModuleConfig::finder()->findBy("module_config_id", $module_config_id);
	}

	public function findByModuleId($module_id) {
		return DModuleConfig::finder()->findBy("module_id", $module_id);
	}

	public function findByValue($value) {
		return DModuleConfig::finder()->findBy("value", $value);
	}

	public function findOneByKey($key) {
		return DModuleConfig::finder()->findOneBy("key", $key);
	}

	public function findOneByModuleConfigId($module_config_id) {
		return DModuleConfig::finder()->findOneBy("module_config_id", $module_config_id);
	}

	public function findOneByModuleId($module_id) {
		return DModuleConfig::finder()->findOneBy("module_id", $module_id);
	}

	public function findOneByValue($value) {
		return DModuleConfig::finder()->findOneBy("value", $value);
	}

	public function filterByKey($key) {
		return DModuleConfig::finder()->filterBy("key", $key);
	}

	public function filterByModuleConfigId($module_config_id) {
		return DModuleConfig::finder()->filterBy("module_config_id", $module_config_id);
	}

	public function filterByModuleId($module_id) {
		return DModuleConfig::finder()->filterBy("module_id", $module_id);
	}

	public function filterByValue($value) {
		return DModuleConfig::finder()->filterBy("value", $value);
	}

	// others
}


class DModuleConfig extends DModuleConfigBase {

	public function save() {
		return parent::save();
	}

}



class DModuleConfigQuery extends DModuleConfigBaseQuery {

}

class DModuleConfigHistoryBase extends RActiveRecord {

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


}

class DModuleConfigHistoryBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"date" => "timestamp with time zone",
		"key" => "text",
		"module_config_history_id" => "integer",
		"module_id" => "integer",
		"value" => "text",
	);
	public function findByDate($date) {
		return DModuleConfigHistory::finder()->findBy("date", $date);
	}

	public function findByKey($key) {
		return DModuleConfigHistory::finder()->findBy("key", $key);
	}

	public function findByModuleConfigHistoryId($module_config_history_id) {
		return DModuleConfigHistory::finder()->findBy("module_config_history_id", $module_config_history_id);
	}

	public function findByModuleId($module_id) {
		return DModuleConfigHistory::finder()->findBy("module_id", $module_id);
	}

	public function findByValue($value) {
		return DModuleConfigHistory::finder()->findBy("value", $value);
	}

	public function findOneByDate($date) {
		return DModuleConfigHistory::finder()->findOneBy("date", $date);
	}

	public function findOneByKey($key) {
		return DModuleConfigHistory::finder()->findOneBy("key", $key);
	}

	public function findOneByModuleConfigHistoryId($module_config_history_id) {
		return DModuleConfigHistory::finder()->findOneBy("module_config_history_id", $module_config_history_id);
	}

	public function findOneByModuleId($module_id) {
		return DModuleConfigHistory::finder()->findOneBy("module_id", $module_id);
	}

	public function findOneByValue($value) {
		return DModuleConfigHistory::finder()->findOneBy("value", $value);
	}

	public function filterByDate($date) {
		return DModuleConfigHistory::finder()->filterBy("date", $date);
	}

	public function filterByKey($key) {
		return DModuleConfigHistory::finder()->filterBy("key", $key);
	}

	public function filterByModuleConfigHistoryId($module_config_history_id) {
		return DModuleConfigHistory::finder()->filterBy("module_config_history_id", $module_config_history_id);
	}

	public function filterByModuleId($module_id) {
		return DModuleConfigHistory::finder()->filterBy("module_id", $module_id);
	}

	public function filterByValue($value) {
		return DModuleConfigHistory::finder()->filterBy("value", $value);
	}

	// others
}


class DModuleConfigHistory extends DModuleConfigHistoryBase {

	public function save() {
		return parent::save();
	}

}



class DModuleConfigHistoryQuery extends DModuleConfigHistoryBaseQuery {

}

class DParticipantDataBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByParticipantDataId($this->participant_data_id);
		}
		return $this->_events;
		}

}

class DParticipantDataBaseQuery extends RActiveQuery {

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
	public function findByBirthDate($birth_date) {
		return DParticipantData::finder()->findBy("birth_date", $birth_date);
	}

	public function findByCity($city) {
		return DParticipantData::finder()->findBy("city", $city);
	}

	public function findByClubId($club_id) {
		return DParticipantData::finder()->findBy("club_id", $club_id);
	}

	public function findByCreateDate($create_date) {
		return DParticipantData::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DParticipantData::finder()->findBy("deleted", $deleted);
	}

	public function findByEmail($email) {
		return DParticipantData::finder()->findBy("email", $email);
	}

	public function findByFirstName($first_name) {
		return DParticipantData::finder()->findBy("first_name", $first_name);
	}

	public function findByLastName($last_name) {
		return DParticipantData::finder()->findBy("last_name", $last_name);
	}

	public function findByParticipantDataId($participant_data_id) {
		return DParticipantData::finder()->findBy("participant_data_id", $participant_data_id);
	}

	public function findByParticipantId($participant_id) {
		return DParticipantData::finder()->findBy("participant_id", $participant_id);
	}

	public function findByPhone($phone) {
		return DParticipantData::finder()->findBy("phone", $phone);
	}

	public function findBySex($sex) {
		return DParticipantData::finder()->findBy("sex", $sex);
	}

	public function findOneByBirthDate($birth_date) {
		return DParticipantData::finder()->findOneBy("birth_date", $birth_date);
	}

	public function findOneByCity($city) {
		return DParticipantData::finder()->findOneBy("city", $city);
	}

	public function findOneByClubId($club_id) {
		return DParticipantData::finder()->findOneBy("club_id", $club_id);
	}

	public function findOneByCreateDate($create_date) {
		return DParticipantData::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DParticipantData::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByEmail($email) {
		return DParticipantData::finder()->findOneBy("email", $email);
	}

	public function findOneByFirstName($first_name) {
		return DParticipantData::finder()->findOneBy("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return DParticipantData::finder()->findOneBy("last_name", $last_name);
	}

	public function findOneByParticipantDataId($participant_data_id) {
		return DParticipantData::finder()->findOneBy("participant_data_id", $participant_data_id);
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipantData::finder()->findOneBy("participant_id", $participant_id);
	}

	public function findOneByPhone($phone) {
		return DParticipantData::finder()->findOneBy("phone", $phone);
	}

	public function findOneBySex($sex) {
		return DParticipantData::finder()->findOneBy("sex", $sex);
	}

	public function filterByBirthDate($birth_date) {
		return DParticipantData::finder()->filterBy("birth_date", $birth_date);
	}

	public function filterByCity($city) {
		return DParticipantData::finder()->filterBy("city", $city);
	}

	public function filterByClubId($club_id) {
		return DParticipantData::finder()->filterBy("club_id", $club_id);
	}

	public function filterByCreateDate($create_date) {
		return DParticipantData::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DParticipantData::finder()->filterBy("deleted", $deleted);
	}

	public function filterByEmail($email) {
		return DParticipantData::finder()->filterBy("email", $email);
	}

	public function filterByFirstName($first_name) {
		return DParticipantData::finder()->filterBy("first_name", $first_name);
	}

	public function filterByLastName($last_name) {
		return DParticipantData::finder()->filterBy("last_name", $last_name);
	}

	public function filterByParticipantDataId($participant_data_id) {
		return DParticipantData::finder()->filterBy("participant_data_id", $participant_data_id);
	}

	public function filterByParticipantId($participant_id) {
		return DParticipantData::finder()->filterBy("participant_id", $participant_id);
	}

	public function filterByPhone($phone) {
		return DParticipantData::finder()->filterBy("phone", $phone);
	}

	public function filterBySex($sex) {
		return DParticipantData::finder()->filterBy("sex", $sex);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipantData extends DParticipantDataBase {

	public function save() {
		return parent::save();
	}

}



class DParticipantDataQuery extends DParticipantDataBaseQuery {

}

class DParticipantBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByParticipantId($this->participant_id);
		}
		return $this->_events;
		}

	public function getParticipantDatas() {
		if($this->_participant_datas === null) {
			$this->_participant_datas = DParticipantData::finder()->findByParticipantId($this->participant_id);
		}
		return $this->_participant_datas;
		}

	public function getClassifications() {
		if($this->_classifications === null) {
			$participants_classifications = DParticipantClassification::finder()->findByParticipantId($this->participant_id);
			$classifications_pks = array();
			foreach($participants_classifications as $p) {
				$classifications_pks[] = $p->classification_id;
			}
			$this->_classifications = DClassification::finder()->findByPKs($classifications_pks);
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
}

class DParticipantBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"application_number" => "integer",
		"deleted" => "integer",
		"participant_id" => "integer",
		"register_date" => "timestamp with time zone",
		"starting_number" => "integer",
		"year" => "integer",
	);
	public function findByApplicationNumber($application_number) {
		return DParticipant::finder()->findBy("application_number", $application_number);
	}

	public function findByDeleted($deleted) {
		return DParticipant::finder()->findBy("deleted", $deleted);
	}

	public function findByParticipantId($participant_id) {
		return DParticipant::finder()->findBy("participant_id", $participant_id);
	}

	public function findByRegisterDate($register_date) {
		return DParticipant::finder()->findBy("register_date", $register_date);
	}

	public function findByStartingNumber($starting_number) {
		return DParticipant::finder()->findBy("starting_number", $starting_number);
	}

	public function findByYear($year) {
		return DParticipant::finder()->findBy("year", $year);
	}

	public function findOneByApplicationNumber($application_number) {
		return DParticipant::finder()->findOneBy("application_number", $application_number);
	}

	public function findOneByDeleted($deleted) {
		return DParticipant::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipant::finder()->findOneBy("participant_id", $participant_id);
	}

	public function findOneByRegisterDate($register_date) {
		return DParticipant::finder()->findOneBy("register_date", $register_date);
	}

	public function findOneByStartingNumber($starting_number) {
		return DParticipant::finder()->findOneBy("starting_number", $starting_number);
	}

	public function findOneByYear($year) {
		return DParticipant::finder()->findOneBy("year", $year);
	}

	public function filterByApplicationNumber($application_number) {
		return DParticipant::finder()->filterBy("application_number", $application_number);
	}

	public function filterByDeleted($deleted) {
		return DParticipant::finder()->filterBy("deleted", $deleted);
	}

	public function filterByParticipantId($participant_id) {
		return DParticipant::finder()->filterBy("participant_id", $participant_id);
	}

	public function filterByRegisterDate($register_date) {
		return DParticipant::finder()->filterBy("register_date", $register_date);
	}

	public function filterByStartingNumber($starting_number) {
		return DParticipant::finder()->filterBy("starting_number", $starting_number);
	}

	public function filterByYear($year) {
		return DParticipant::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipant extends DParticipantBase {

	public function save() {
		return parent::save();
	}

}



class DParticipantQuery extends DParticipantBaseQuery {

}

class DParticipantClassificationBase extends RActiveRecord {

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


}

class DParticipantClassificationBaseQuery extends RActiveQuery {

	public $TYPES = array(
		"classification_id" => "integer",
		"date" => "text",
		"deleted" => "integer",
		"participant_classification_id" => "integer",
		"participant_id" => "integer",
	);
	public function findByClassificationId($classification_id) {
		return DParticipantClassification::finder()->findBy("classification_id", $classification_id);
	}

	public function findByDate($date) {
		return DParticipantClassification::finder()->findBy("date", $date);
	}

	public function findByDeleted($deleted) {
		return DParticipantClassification::finder()->findBy("deleted", $deleted);
	}

	public function findByParticipantClassificationId($participant_classification_id) {
		return DParticipantClassification::finder()->findBy("participant_classification_id", $participant_classification_id);
	}

	public function findByParticipantId($participant_id) {
		return DParticipantClassification::finder()->findBy("participant_id", $participant_id);
	}

	public function findOneByClassificationId($classification_id) {
		return DParticipantClassification::finder()->findOneBy("classification_id", $classification_id);
	}

	public function findOneByDate($date) {
		return DParticipantClassification::finder()->findOneBy("date", $date);
	}

	public function findOneByDeleted($deleted) {
		return DParticipantClassification::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByParticipantClassificationId($participant_classification_id) {
		return DParticipantClassification::finder()->findOneBy("participant_classification_id", $participant_classification_id);
	}

	public function findOneByParticipantId($participant_id) {
		return DParticipantClassification::finder()->findOneBy("participant_id", $participant_id);
	}

	public function filterByClassificationId($classification_id) {
		return DParticipantClassification::finder()->filterBy("classification_id", $classification_id);
	}

	public function filterByDate($date) {
		return DParticipantClassification::finder()->filterBy("date", $date);
	}

	public function filterByDeleted($deleted) {
		return DParticipantClassification::finder()->filterBy("deleted", $deleted);
	}

	public function filterByParticipantClassificationId($participant_classification_id) {
		return DParticipantClassification::finder()->filterBy("participant_classification_id", $participant_classification_id);
	}

	public function filterByParticipantId($participant_id) {
		return DParticipantClassification::finder()->filterBy("participant_id", $participant_id);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DParticipantClassification extends DParticipantClassificationBase {

	public function save() {
		return parent::save();
	}

}



class DParticipantClassificationQuery extends DParticipantClassificationBaseQuery {

}

class DPostBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findByPostId($this->post_id);
		}
		return $this->_events;
		}

}

class DPostBaseQuery extends RActiveQuery {

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
	public function findByAdminId($admin_id) {
		return DPost::finder()->findBy("admin_id", $admin_id);
	}

	public function findByContent($content) {
		return DPost::finder()->findBy("content", $content);
	}

	public function findByCreateDate($create_date) {
		return DPost::finder()->findBy("create_date", $create_date);
	}

	public function findByDeleted($deleted) {
		return DPost::finder()->findBy("deleted", $deleted);
	}

	public function findByModifyDate($modify_date) {
		return DPost::finder()->findBy("modify_date", $modify_date);
	}

	public function findByPostId($post_id) {
		return DPost::finder()->findBy("post_id", $post_id);
	}

	public function findByStatus($status) {
		return DPost::finder()->findBy("status", $status);
	}

	public function findByThumbnailId($thumbnail_id) {
		return DPost::finder()->findBy("thumbnail_id", $thumbnail_id);
	}

	public function findByTitle($title) {
		return DPost::finder()->findBy("title", $title);
	}

	public function findOneByAdminId($admin_id) {
		return DPost::finder()->findOneBy("admin_id", $admin_id);
	}

	public function findOneByContent($content) {
		return DPost::finder()->findOneBy("content", $content);
	}

	public function findOneByCreateDate($create_date) {
		return DPost::finder()->findOneBy("create_date", $create_date);
	}

	public function findOneByDeleted($deleted) {
		return DPost::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByModifyDate($modify_date) {
		return DPost::finder()->findOneBy("modify_date", $modify_date);
	}

	public function findOneByPostId($post_id) {
		return DPost::finder()->findOneBy("post_id", $post_id);
	}

	public function findOneByStatus($status) {
		return DPost::finder()->findOneBy("status", $status);
	}

	public function findOneByThumbnailId($thumbnail_id) {
		return DPost::finder()->findOneBy("thumbnail_id", $thumbnail_id);
	}

	public function findOneByTitle($title) {
		return DPost::finder()->findOneBy("title", $title);
	}

	public function filterByAdminId($admin_id) {
		return DPost::finder()->filterBy("admin_id", $admin_id);
	}

	public function filterByContent($content) {
		return DPost::finder()->filterBy("content", $content);
	}

	public function filterByCreateDate($create_date) {
		return DPost::finder()->filterBy("create_date", $create_date);
	}

	public function filterByDeleted($deleted) {
		return DPost::finder()->filterBy("deleted", $deleted);
	}

	public function filterByModifyDate($modify_date) {
		return DPost::finder()->filterBy("modify_date", $modify_date);
	}

	public function filterByPostId($post_id) {
		return DPost::finder()->filterBy("post_id", $post_id);
	}

	public function filterByStatus($status) {
		return DPost::finder()->filterBy("status", $status);
	}

	public function filterByThumbnailId($thumbnail_id) {
		return DPost::finder()->filterBy("thumbnail_id", $thumbnail_id);
	}

	public function filterByTitle($title) {
		return DPost::finder()->filterBy("title", $title);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DPost extends DPostBase {

	public function save() {
		return parent::save();
	}

}



class DPostQuery extends DPostBaseQuery {

}

class DPrivilegeBase extends RActiveRecord {

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
		"deleted" => "integer",
		"description" => "text",
		"name" => "text",
		"privilege_id" => "integer",
	);
	public function findByDeleted($deleted) {
		return DPrivilege::finder()->findBy("deleted", $deleted);
	}

	public function findByDescription($description) {
		return DPrivilege::finder()->findBy("description", $description);
	}

	public function findByName($name) {
		return DPrivilege::finder()->findBy("name", $name);
	}

	public function findByPrivilegeId($privilege_id) {
		return DPrivilege::finder()->findBy("privilege_id", $privilege_id);
	}

	public function findOneByDeleted($deleted) {
		return DPrivilege::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByDescription($description) {
		return DPrivilege::finder()->findOneBy("description", $description);
	}

	public function findOneByName($name) {
		return DPrivilege::finder()->findOneBy("name", $name);
	}

	public function findOneByPrivilegeId($privilege_id) {
		return DPrivilege::finder()->findOneBy("privilege_id", $privilege_id);
	}

	public function filterByDeleted($deleted) {
		return DPrivilege::finder()->filterBy("deleted", $deleted);
	}

	public function filterByDescription($description) {
		return DPrivilege::finder()->filterBy("description", $description);
	}

	public function filterByName($name) {
		return DPrivilege::finder()->filterBy("name", $name);
	}

	public function filterByPrivilegeId($privilege_id) {
		return DPrivilege::finder()->filterBy("privilege_id", $privilege_id);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DPrivilege extends DPrivilegeBase {

	public function save() {
		return parent::save();
	}

}



class DPrivilegeQuery extends DPrivilegeBaseQuery {

}

class DSupporterBase extends RActiveRecord {

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
			$this->_events = DEvent::finder()->findBySupporterId($this->supporter_id);
		}
		return $this->_events;
		}

}

class DSupporterBaseQuery extends RActiveQuery {

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
	public function findByDeleted($deleted) {
		return DSupporter::finder()->findBy("deleted", $deleted);
	}

	public function findByDescription($description) {
		return DSupporter::finder()->findBy("description", $description);
	}

	public function findByLogoId($logo_id) {
		return DSupporter::finder()->findBy("logo_id", $logo_id);
	}

	public function findByPosition($position) {
		return DSupporter::finder()->findBy("position", $position);
	}

	public function findBySupporterId($supporter_id) {
		return DSupporter::finder()->findBy("supporter_id", $supporter_id);
	}

	public function findByType($type) {
		return DSupporter::finder()->findBy("type", $type);
	}

	public function findByUrl($url) {
		return DSupporter::finder()->findBy("url", $url);
	}

	public function findByYear($year) {
		return DSupporter::finder()->findBy("year", $year);
	}

	public function findOneByDeleted($deleted) {
		return DSupporter::finder()->findOneBy("deleted", $deleted);
	}

	public function findOneByDescription($description) {
		return DSupporter::finder()->findOneBy("description", $description);
	}

	public function findOneByLogoId($logo_id) {
		return DSupporter::finder()->findOneBy("logo_id", $logo_id);
	}

	public function findOneByPosition($position) {
		return DSupporter::finder()->findOneBy("position", $position);
	}

	public function findOneBySupporterId($supporter_id) {
		return DSupporter::finder()->findOneBy("supporter_id", $supporter_id);
	}

	public function findOneByType($type) {
		return DSupporter::finder()->findOneBy("type", $type);
	}

	public function findOneByUrl($url) {
		return DSupporter::finder()->findOneBy("url", $url);
	}

	public function findOneByYear($year) {
		return DSupporter::finder()->findOneBy("year", $year);
	}

	public function filterByDeleted($deleted) {
		return DSupporter::finder()->filterBy("deleted", $deleted);
	}

	public function filterByDescription($description) {
		return DSupporter::finder()->filterBy("description", $description);
	}

	public function filterByLogoId($logo_id) {
		return DSupporter::finder()->filterBy("logo_id", $logo_id);
	}

	public function filterByPosition($position) {
		return DSupporter::finder()->filterBy("position", $position);
	}

	public function filterBySupporterId($supporter_id) {
		return DSupporter::finder()->filterBy("supporter_id", $supporter_id);
	}

	public function filterByType($type) {
		return DSupporter::finder()->filterBy("type", $type);
	}

	public function filterByUrl($url) {
		return DSupporter::finder()->filterBy("url", $url);
	}

	public function filterByYear($year) {
		return DSupporter::finder()->filterBy("year", $year);
	}

	// others
	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}


class DSupporter extends DSupporterBase {

	public function save() {
		return parent::save();
	}

}



class DSupporterQuery extends DSupporterBaseQuery {

}

