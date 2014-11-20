<?php
class _BaseActiveRecords {};

class DAdminRecord extends FActiveRecord {

    const TABLE = "admins";

    public $admin_id;
    public $deleted;
    public $email;
    public $login;

    const TYPES = array(
        "admin_id"=>"integer",
        "deleted"=>"integer",
        "email"=>"text",
        "login"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DAdminPrivilegeRecord extends FActiveRecord {

    const TABLE = "admins_privileges";

    public $admin_id;
    public $admin_privilege_id;
    public $create_date;
    public $deleted;
    public $privilege_id;

    const TYPES = array(
        "admin_id"=>"integer",
        "admin_privilege_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "privilege_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DAgeCategoryRecord extends FActiveRecord {

    const TABLE = "age_categories";

    public $age_category_id;
    public $age_from;
    public $age_to;
    public $create_date;
    public $deleted;
    public $name;
    public $sex;
    public $year;

    const TYPES = array(
        "age_category_id"=>"integer",
        "age_from"=>"integer",
        "age_to"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "name"=>"text",
        "sex"=>"text",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DChildrenRunGroupRecord extends FActiveRecord {

    const TABLE = "childrens_runs_groups";

    public $active;
    public $children_run_group_id;
    public $create_date;
    public $deleted;
    public $limit;
    public $name;
    public $year;

    const TYPES = array(
        "active"=>"integer",
        "children_run_group_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "limit"=>"integer",
        "name"=>"text",
        "year"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DChildrenRunParticipantRecord extends FActiveRecord {

    const TABLE = "childrens_runs_participants";

    public $birth_date;
    public $children_run_group_id;
    public $children_run_participant_id;
    public $city;
    public $deleted;
    public $first_name;
    public $last_name;
    public $register_date;
    public $year;

    const TYPES = array(
        "birth_date"=>"text",
        "children_run_group_id"=>"integer",
        "children_run_participant_id"=>"integer",
        "city"=>"text",
        "deleted"=>"integer",
        "first_name"=>"text",
        "last_name"=>"text",
        "register_date"=>"timestamp with time zone",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DClassificationRecord extends FActiveRecord {

    const TABLE = "classifications";

    public $classification_id;
    public $create_date;
    public $deleted;
    public $description;
    public $name;
    public $year;

    const TYPES = array(
        "classification_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "description"=>"text",
        "name"=>"text",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DClubRecord extends FActiveRecord {

    const TABLE = "clubs";

    public $club_id;
    public $deleted;
    public $name;
    public $year;

    const TYPES = array(
        "club_id"=>"integer",
        "deleted"=>"integer",
        "name"=>"text",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DCommentRecord extends FActiveRecord {

    const TABLE = "comments";

    public $comment;
    public $comment_id;
    public $date;
    public $deleted;
    public $full_name;
    public $year;

    const TYPES = array(
        "comment"=>"text",
        "comment_id"=>"integer",
        "date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "full_name"=>"text",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DConfigRecord extends FActiveRecord {

    const TABLE = "config";

    public $date;
    public $deleted;
    public $key;
    public $value;

    const TYPES = array(
        "date"=>"text",
        "deleted"=>"integer",
        "key"=>"character varying",
        "value"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DConfigHistoryRecord extends FActiveRecord {

    const TABLE = "config_history";

    public $config_history_id;
    public $date;
    public $key;
    public $value;

    const TYPES = array(
        "config_history_id"=>"integer",
        "date"=>"timestamp with time zone",
        "key"=>"text",
        "value"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DEventRecord extends FActiveRecord {

    const TABLE = "events";

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

    const TYPES = array(
        "admin_id"=>"integer",
        "age_category_id"=>"integer",
        "classification_id"=>"integer",
        "club_id"=>"integer",
        "comment_id"=>"integer",
        "config_history_id"=>"integer",
        "date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "event_id"=>"integer",
        "ip"=>"text",
        "module_id"=>"integer",
        "params"=>"text",
        "participant_data_id"=>"integer",
        "participant_id"=>"integer",
        "post_id"=>"integer",
        "supporter_id"=>"integer",
        "type"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DMediaRecord extends FActiveRecord {

    const TABLE = "media";

    public $deleted;
    public $description;
    public $description_alt;
    public $media_id;
    public $path;
    public $type;
    public $upload_date;

    const TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "description_alt"=>"text",
        "media_id"=>"integer",
        "path"=>"text",
        "type"=>"text",
        "upload_date"=>"timestamp with time zone",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DModuleRecord extends FActiveRecord {

    const TABLE = "modules";

    public $active;
    public $deleted;
    public $description;
    public $key;
    public $module_id;
    public $name;

    const TYPES = array(
        "active"=>"integer",
        "deleted"=>"integer",
        "description"=>"text",
        "key"=>"text",
        "module_id"=>"integer",
        "name"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DModuleConfigRecord extends FActiveRecord {

    const TABLE = "modules_config";

    public $key;
    public $module_config_id;
    public $module_id;
    public $value;

    const TYPES = array(
        "key"=>"text",
        "module_config_id"=>"integer",
        "module_id"=>"integer",
        "value"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DModuleConfigHistoryRecord extends FActiveRecord {

    const TABLE = "modules_config_history";

    public $date;
    public $key;
    public $module_config_history_id;
    public $module_id;
    public $value;

    const TYPES = array(
        "date"=>"timestamp with time zone",
        "key"=>"text",
        "module_config_history_id"=>"integer",
        "module_id"=>"integer",
        "value"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DParticipantDataRecord extends FActiveRecord {

    const TABLE = "participant_datas";

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

    const TYPES = array(
        "birth_date"=>"text",
        "city"=>"text",
        "club_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "email"=>"text",
        "first_name"=>"text",
        "last_name"=>"text",
        "participant_data_id"=>"integer",
        "participant_id"=>"integer",
        "phone"=>"text",
        "sex"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DParticipantRecord extends FActiveRecord {

    const TABLE = "participants";

    public $application_number;
    public $deleted;
    public $participant_id;
    public $register_date;
    public $starting_number;
    public $year;

    const TYPES = array(
        "application_number"=>"integer",
        "deleted"=>"integer",
        "participant_id"=>"integer",
        "register_date"=>"timestamp with time zone",
        "starting_number"=>"integer",
        "year"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DParticipantClassificationRecord extends FActiveRecord {

    const TABLE = "participants_classifications";

    public $classification_id;
    public $date;
    public $deleted;
    public $participant_classification_id;
    public $participant_id;

    const TYPES = array(
        "classification_id"=>"integer",
        "date"=>"text",
        "deleted"=>"integer",
        "participant_classification_id"=>"integer",
        "participant_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DPostRecord extends FActiveRecord {

    const TABLE = "posts";

    public $admin_id;
    public $content;
    public $create_date;
    public $deleted;
    public $modify_date;
    public $post_id;
    public $status;
    public $thumbnail_id;
    public $title;

    const TYPES = array(
        "admin_id"=>"integer",
        "content"=>"text",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "modify_date"=>"timestamp with time zone",
        "post_id"=>"integer",
        "status"=>"text",
        "thumbnail_id"=>"integer",
        "title"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DPrivilegeRecord extends FActiveRecord {

    const TABLE = "privileges";

    public $deleted;
    public $description;
    public $name;
    public $privilege_id;

    const TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "name"=>"text",
        "privilege_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DSupporterRecord extends FActiveRecord {

    const TABLE = "supporters";

    public $deleted;
    public $description;
    public $logo_id;
    public $position;
    public $supporter_id;
    public $type;
    public $url;
    public $year;

    const TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "logo_id"=>"integer",
        "position"=>"integer",
        "supporter_id"=>"integer",
        "type"=>"text",
        "url"=>"text",
        "year"=>"text",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
