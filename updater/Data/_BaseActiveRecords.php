<?php

class _BaseActiveRecords {}

class D_AdminBaseRecord extends FActiveRecord {
	public $TABLE = "admins";

	public $admin_id;
	public $login;
	public $email;
	public $deleted = 0;

	public $TYPES = array(
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

class D_MediaBaseRecord extends FActiveRecord {
	public $TABLE = "media";

	public $media_id;
	public $type;
	public $path;
	public $description;
	public $description_alt;
	public $deleted = 0;

	public $TYPES = array(
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

class D_PostBaseRecord extends FActiveRecord {
	public $TABLE = "posts";

	public $post_id;
	public $admin_id;
	public $thumbnail_id;
	public $title;
	public $content;
	public $create_date;
	public $modify_date;
	public $status;
	public $deleted = 0;

	public $TYPES = array(
		"post_id" => "int",
		"admin_id" => "int",
		"thumbnail_id" => "int",
		"title" => "string",
		"content" => "string",
		"create_date" => "string",
		"modify_date" => "string",
		"status" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_PrivilegeBaseRecord extends FActiveRecord {
	public $TABLE = "privileges";

	public $privilege_id;
	public $name;
	public $description;
	public $deleted = 0;

	public $TYPES = array(
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

class D_AdminPrivilegeBaseRecord extends FActiveRecord {
	public $TABLE = "admins_privileges";

	public $admin_privilege_id;
	public $admin_id;
	public $privilege_id;
	public $create_date;
	public $deleted = 0;

	public $TYPES = array(
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

class D_ConfigBaseRecord extends FActiveRecord {
	public $TABLE = "config";

	public $config_id;
	public $key;
	public $value;
	public $date;
	public $deleted = 0;

	public $TYPES = array(
		"config_id" => "int",
		"key" => "string",
		"value" => "string",
		"date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ConfigHistoryBaseRecord extends FActiveRecord {
	public $TABLE = "config_history";

	public $config_history_id;
	public $key;
	public $value;
	public $date;

	public $TYPES = array(
		"config_history_id" => "int",
		"key" => "string",
		"value" => "string",
		"date" => "string",
	);

}

class D_ParticipantBaseRecord extends FActiveRecord {
	public $TABLE = "participants";

	public $participant_id;
	public $application_number = 0;
	public $starting_number = 0;
	public $register_date;
	public $year;
	public $deleted = 0;

	public $TYPES = array(
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

class D_ClubBaseRecord extends FActiveRecord {
	public $TABLE = "clubs";

	public $club_id;
	public $name;
	public $deleted = 0;

	public $TYPES = array(
		"club_id" => "int",
		"name" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ParticipantDataBaseRecord extends FActiveRecord {
	public $TABLE = "participant_datas";

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

	public $TYPES = array(
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

class D_EventBaseRecord extends FActiveRecord {
	public $TABLE = "events";

	public $event_id;
	public $performer_id;
	public $target_id;
	public $additional_target_id;
	public $type;
	public $params;
	public $date;
	public $ip;
	public $deleted = 0;

	public $TYPES = array(
		"event_id" => "int",
		"performer_id" => "int",
		"target_id" => "int",
		"additional_target_id" => "int",
		"type" => "string",
		"params" => "string",
		"date" => "string",
		"ip" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_ClassificationBaseRecord extends FActiveRecord {
	public $TABLE = "classifications";

	public $classification_id;
	public $name;
	public $description;
	public $year;
	public $create_date;
	public $deleted = 0;

	public $TYPES = array(
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

class D_ParticipantClassificationBaseRecord extends FActiveRecord {
	public $TABLE = "participants_classifications";

	public $participant_classification_id;
	public $participant_id;
	public $classification_id;
	public $date;
	public $deleted = 0;

	public $TYPES = array(
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

class D_AgeCategorieBaseRecord extends FActiveRecord {
	public $TABLE = "age_categories";

	public $age_category_id;
	public $name;
	public $sex;
	public $year;
	public $create_date;
	public $deleted = 0;

	public $TYPES = array(
		"age_category_id" => "int",
		"name" => "string",
		"sex" => "string",
		"year" => "string",
		"create_date" => "string",
		"deleted" => "int",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

class D_PostListViewBaseRecord extends FActiveRecord {
	public $TABLE = "posts_list_view";

	public $post_id;
	public $admin_id;
	public $thumbnail_id;
	public $title;
	public $content;
	public $create_date;
	public $modify_date;
	public $status;
	public $deleted;
	public $login;

	public $TYPES = array(
		"post_id" => "string",
		"admin_id" => "string",
		"thumbnail_id" => "string",
		"title" => "string",
		"content" => "string",
		"create_date" => "string",
		"modify_date" => "string",
		"status" => "string",
		"deleted" => "string",
		"login" => "string",
	);

	public function delete() {
		$this->deleted = time();
		$this->save();
	}
}

