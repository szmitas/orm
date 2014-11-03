<?php

class _BaseActiveRecords {};

class D_AdminRecord extends FActiveRecord {
	const TABLE = "admins";

	public $admin_id;
	public $login;
	public $email;
	public $deleted = 0;

	const TYPES = array(
		"admin_id" => "int",
		"login" => "string",
		"email" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_MediaRecord extends FActiveRecord {
	const TABLE = "media";

	public $media_id;
	public $type;
	public $path;
	public $description;
	public $description_alt;
	public $deleted = 0;

	const TYPES = array(
		"media_id" => "int",
		"type" => "string",
		"path" => "string",
		"description" => "string",
		"description_alt" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_PostRecord extends FActiveRecord {
	const TABLE = "posts";

	public $post_id;
	public $admin_id;
	public $thumbnail_id;
	public $title;
	public $content;
	public $create_date;
	public $modify_date;
	public $deleted = 0;

	const TYPES = array(
		"post_id" => "int",
		"admin_id" => "int",
		"thumbnail_id" => "int",
		"title" => "string",
		"content" => "string",
		"create_date" => "string",
		"modify_date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_PrivilegeRecord extends FActiveRecord {
	const TABLE = "privileges";

	public $privilege_id;
	public $name;
	public $description;
	public $deleted = 0;

	const TYPES = array(
		"privilege_id" => "int",
		"name" => "string",
		"description" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_AdminPrivilegeRecord extends FActiveRecord {
	const TABLE = "admins_privileges";

	public $admin_privilege_id;
	public $admin_id;
	public $privilege_id;
	public $create_date;
	public $deleted = 0;

	const TYPES = array(
		"admin_privilege_id" => "int",
		"admin_id" => "int",
		"privilege_id" => "int",
		"create_date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ConfigRecord extends FActiveRecord {
	const TABLE = "config";

	public $key;
	public $value;
	public $date;

	const TYPES = array(
		"key" => "string",
		"value" => "string",
		"date" => "string",
	);

}

class D_ConfigHistoryRecord extends FActiveRecord {
	const TABLE = "config_history";

	public $config_history_id;
	public $key;
	public $value;
	public $date;

	const TYPES = array(
		"config_history_id" => "int",
		"key" => "string",
		"value" => "string",
		"date" => "string",
	);

}

class D_ParticipantRecord extends FActiveRecord {
	const TABLE = "participants";

	public $participant_id;
	public $application_number = 0;
	public $starting_number = 0;
	public $register_date;
	public $year;
	public $deleted = 0;

	const TYPES = array(
		"participant_id" => "int",
		"application_number" => "int",
		"starting_number" => "int",
		"register_date" => "string",
		"year" => "int",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ClubRecord extends FActiveRecord {
	const TABLE = "clubs";

	public $club_id;
	public $name;
	public $deleted = 0;

	const TYPES = array(
		"club_id" => "int",
		"name" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ParticipantDataRecord extends FActiveRecord {
	const TABLE = "participant_datas";

	public $participant_data_id;
	public $participant_id;
	public $club_id = 0;
	public $first_name;
	public $last_name;
	public $birth_date;
	public $sex;
	public $city;
	public $email;
	public $phone;
	public $create_date;
	public $deleted = 0;

	const TYPES = array(
		"participant_data_id" => "int",
		"participant_id" => "int",
		"club_id" => "int",
		"first_name" => "string",
		"last_name" => "string",
		"birth_date" => "string",
		"sex" => "string",
		"city" => "string",
		"email" => "string",
		"phone" => "string",
		"create_date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_EventRecord extends FActiveRecord {
	const TABLE = "events";

	public $event_id;
	public $performer_admin_id;
	public $performer_participant_id;
	public $admin_id;
	public $participant_id;
	public $club_id;
	public $action;
	public $params;
	public $date;
	public $deleted = 0;

	const TYPES = array(
		"event_id" => "int",
		"performer_admin_id" => "int",
		"performer_participant_id" => "int",
		"admin_id" => "int",
		"participant_id" => "int",
		"club_id" => "int",
		"action" => "string",
		"params" => "string",
		"date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ClassificationRecord extends FActiveRecord {
	const TABLE = "classifications";

	public $classification_id;
	public $name;
	public $description;
	public $year;
	public $create_date;
	public $deleted = 0;

	const TYPES = array(
		"classification_id" => "int",
		"name" => "string",
		"description" => "string",
		"year" => "string",
		"create_date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ParticipantClassificationRecord extends FActiveRecord {
	const TABLE = "participants_classifications";

	public $participant_classification_id;
	public $participant_id;
	public $classification_id;
	public $date;
	public $deleted = 0;

	const TYPES = array(
		"participant_classification_id" => "int",
		"participant_id" => "int",
		"classification_id" => "int",
		"date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_AgeCategorieRecord extends FActiveRecord {
	const TABLE = "age_categories";

	public $age_category_id;
	public $name;
	public $sex;
	public $year;
	public $create_date;
	public $deleted = 0;

	const TYPES = array(
		"age_category_id" => "int",
		"name" => "string",
		"sex" => "string",
		"year" => "string",
		"create_date" => "string",
		"deleted" => "string",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

