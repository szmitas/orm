<?php
class _BaseActiveRecords {};

class DAdminBaseRecord extends FActiveRecord {

    public $TABLE = "admins";

    public $admin_id;
    public $deleted;
    public $email;
    public $login;

    public $TYPES = array(
        "admin_id"=>"integer",
        "deleted"=>"integer",
        "email"=>"text",
        "login"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;
    private $_posts = null;
    private $_privileges = null;
    private $_relationship = null;

    // RELATIONSHIPS METHODS
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
            $privileges = array();
            foreach($admins_privileges as $a) {
                $p = DPrivilegeRecord::finder()->findByPK($a->privilege_id);
                $p->relationship = $a;
                $privileges[] = $p;
            }
            $this->_privileges = $privileges;
        }
        return $this->_privileges;
    }

    public function getRelationship() {
        return $this->_relationship;
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

    public $admin_id;
    public $admin_privilege_id;
    public $create_date;
    public $deleted;
    public $privilege_id;

    public $TYPES = array(
        "admin_id"=>"integer",
        "admin_privilege_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "privilege_id"=>"integer",
    );

    // FOREIGN KEYS OBJECTS
    private $_admin = null;
    private $_privilege = null;


    // FOREIGN KEYS METHODS
    public function getAdmin() {
        if($this->_admin === null) {
            $this->_admin = DAdminRecord::finder()->findByPK($this->admin_id);
        }
        return $this->_admin;
    }

    public function getPrivilege() {
        if($this->_privilege === null) {
            $this->_privilege = DPrivilegeRecord::finder()->findByPK($this->privilege_id);
        }
        return $this->_privilege;
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

    public $age_category_id;
    public $age_from;
    public $age_to;
    public $create_date;
    public $deleted;
    public $name;
    public $sex;
    public $year;

    public $TYPES = array(
        "age_category_id"=>"integer",
        "age_from"=>"integer",
        "age_to"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "name"=>"text",
        "sex"=>"text",
        "year"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByAgeCategoryId($this->age_category_id);
        }
        return $this->_events;
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

    public $active;
    public $children_run_group_id;
    public $create_date;
    public $deleted;
    public $limit;
    public $name;
    public $year;

    public $TYPES = array(
        "active"=>"integer",
        "children_run_group_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "limit"=>"integer",
        "name"=>"text",
        "year"=>"integer",
    );


    // RELATIONSHIPS OBJECTS
    private $_childrens_runs_participants = null;

    // RELATIONSHIPS METHODS
    public function getChildrensRunsParticipants() {
        if($this->_childrens_runs_participants === null) {
            $this->_childrens_runs_participants = DChildrenRunParticipantRecord::finder()->findByChildrenRunGroupId($this->children_run_group_id);
        }
        return $this->_childrens_runs_participants;
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

    // FOREIGN KEYS OBJECTS
    private $_children_run_group = null;


    // FOREIGN KEYS METHODS
    public function getChildrenRunGroup() {
        if($this->_children_run_group === null) {
            $this->_children_run_group = DChildrenRunGroupRecord::finder()->findByPK($this->children_run_group_id);
        }
        return $this->_children_run_group;
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

    public $classification_id;
    public $create_date;
    public $deleted;
    public $description;
    public $name;
    public $year;

    public $TYPES = array(
        "classification_id"=>"integer",
        "create_date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "description"=>"text",
        "name"=>"text",
        "year"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;
    private $_participants = null;
    private $_relationship = null;

    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByClassificationId($this->classification_id);
        }
        return $this->_events;
    }

    public function getParticipants() {
        if($this->_participants === null) {
            $participants_classifications = DParticipantClassificationRecord::finder()->findByClassificationId($this->classification_id);
            $participants = array();
            foreach($participants_classifications as $p) {
                $p = DParticipantRecord::finder()->findByPK($p->participant_id);
                $p->relationship = $p;
                $participants[] = $p;
            }
            $this->_participants = $participants;
        }
        return $this->_participants;
    }

    public function getRelationship() {
        return $this->_relationship;
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

    public $club_id;
    public $deleted;
    public $name;
    public $year;

    public $TYPES = array(
        "club_id"=>"integer",
        "deleted"=>"integer",
        "name"=>"text",
        "year"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;
    private $_participant_datas = null;

    // RELATIONSHIPS METHODS
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

    public $comment;
    public $comment_id;
    public $date;
    public $deleted;
    public $full_name;
    public $year;

    public $TYPES = array(
        "comment"=>"text",
        "comment_id"=>"integer",
        "date"=>"timestamp with time zone",
        "deleted"=>"integer",
        "full_name"=>"text",
        "year"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByCommentId($this->comment_id);
        }
        return $this->_events;
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

    public $date;
    public $deleted;
    public $key;
    public $value;

    public $TYPES = array(
        "date"=>"text",
        "deleted"=>"integer",
        "key"=>"character varying",
        "value"=>"text",
    );




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

    public $config_history_id;
    public $date;
    public $key;
    public $value;

    public $TYPES = array(
        "config_history_id"=>"integer",
        "date"=>"timestamp with time zone",
        "key"=>"text",
        "value"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByConfigHistoryId($this->config_history_id);
        }
        return $this->_events;
    }


    // others
    public function delete() {
        $this->deleted = time();
        $this->save();
    }
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

    // FOREIGN KEYS OBJECTS
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


    // FOREIGN KEYS METHODS
    public function getAdmin() {
        if($this->_admin === null) {
            $this->_admin = DAdminRecord::finder()->findByPK($this->admin_id);
        }
        return $this->_admin;
    }

    public function getAgeCategory() {
        if($this->_age_category === null) {
            $this->_age_category = DAgeCategoryRecord::finder()->findByPK($this->age_category_id);
        }
        return $this->_age_category;
    }

    public function getClassification() {
        if($this->_classification === null) {
            $this->_classification = DClassificationRecord::finder()->findByPK($this->classification_id);
        }
        return $this->_classification;
    }

    public function getClub() {
        if($this->_club === null) {
            $this->_club = DClubRecord::finder()->findByPK($this->club_id);
        }
        return $this->_club;
    }

    public function getComment() {
        if($this->_comment === null) {
            $this->_comment = DCommentRecord::finder()->findByPK($this->comment_id);
        }
        return $this->_comment;
    }

    public function getConfigHistory() {
        if($this->_config_history === null) {
            $this->_config_history = DConfigHistoryRecord::finder()->findByPK($this->config_history_id);
        }
        return $this->_config_history;
    }

    public function getModule() {
        if($this->_module === null) {
            $this->_module = DModuleRecord::finder()->findByPK($this->module_id);
        }
        return $this->_module;
    }

    public function getParticipantData() {
        if($this->_participant_data === null) {
            $this->_participant_data = DParticipantDataRecord::finder()->findByPK($this->participant_data_id);
        }
        return $this->_participant_data;
    }

    public function getParticipant() {
        if($this->_participant === null) {
            $this->_participant = DParticipantRecord::finder()->findByPK($this->participant_id);
        }
        return $this->_participant;
    }

    public function getPost() {
        if($this->_post === null) {
            $this->_post = DPostRecord::finder()->findByPK($this->post_id);
        }
        return $this->_post;
    }

    public function getSupporter() {
        if($this->_supporter === null) {
            $this->_supporter = DSupporterRecord::finder()->findByPK($this->supporter_id);
        }
        return $this->_supporter;
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

    public $deleted;
    public $description;
    public $description_alt;
    public $media_id;
    public $path;
    public $type;
    public $upload_date;

    public $TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "description_alt"=>"text",
        "media_id"=>"integer",
        "path"=>"text",
        "type"=>"text",
        "upload_date"=>"timestamp with time zone",
    );


    // RELATIONSHIPS OBJECTS
    private $_posts = null;
    private $_supporters = null;

    // RELATIONSHIPS METHODS
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

    public $active;
    public $deleted;
    public $description;
    public $key;
    public $module_id;
    public $name;

    public $TYPES = array(
        "active"=>"integer",
        "deleted"=>"integer",
        "description"=>"text",
        "key"=>"text",
        "module_id"=>"integer",
        "name"=>"text",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;
    private $_modules_config = null;
    private $_modules_config_history = null;

    // RELATIONSHIPS METHODS
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

    public $key;
    public $module_config_id;
    public $module_id;
    public $value;

    public $TYPES = array(
        "key"=>"text",
        "module_config_id"=>"integer",
        "module_id"=>"integer",
        "value"=>"text",
    );

    // FOREIGN KEYS OBJECTS
    private $_module = null;


    // FOREIGN KEYS METHODS
    public function getModule() {
        if($this->_module === null) {
            $this->_module = DModuleRecord::finder()->findByPK($this->module_id);
        }
        return $this->_module;
    }

    // others
    public function delete() {
        $this->deleted = time();
        $this->save();
    }
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

    public $date;
    public $key;
    public $module_config_history_id;
    public $module_id;
    public $value;

    public $TYPES = array(
        "date"=>"timestamp with time zone",
        "key"=>"text",
        "module_config_history_id"=>"integer",
        "module_id"=>"integer",
        "value"=>"text",
    );

    // FOREIGN KEYS OBJECTS
    private $_module = null;


    // FOREIGN KEYS METHODS
    public function getModule() {
        if($this->_module === null) {
            $this->_module = DModuleRecord::finder()->findByPK($this->module_id);
        }
        return $this->_module;
    }

    // others
    public function delete() {
        $this->deleted = time();
        $this->save();
    }
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

    // FOREIGN KEYS OBJECTS
    private $_club = null;
    private $_participant = null;

    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // FOREIGN KEYS METHODS
    public function getClub() {
        if($this->_club === null) {
            $this->_club = DClubRecord::finder()->findByPK($this->club_id);
        }
        return $this->_club;
    }

    public function getParticipant() {
        if($this->_participant === null) {
            $this->_participant = DParticipantRecord::finder()->findByPK($this->participant_id);
        }
        return $this->_participant;
    }
    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByParticipantDataId($this->participant_data_id);
        }
        return $this->_events;
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

    public $application_number;
    public $deleted;
    public $participant_id;
    public $register_date;
    public $starting_number;
    public $year;

    public $TYPES = array(
        "application_number"=>"integer",
        "deleted"=>"integer",
        "participant_id"=>"integer",
        "register_date"=>"timestamp with time zone",
        "starting_number"=>"integer",
        "year"=>"integer",
    );


    // RELATIONSHIPS OBJECTS
    private $_events = null;
    private $_participant_datas = null;
    private $_participants = null;
    private $_relationship = null;

    // RELATIONSHIPS METHODS
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

    public function getParticipants() {
        if($this->_participants === null) {
            $participants_classifications = DParticipantClassificationRecord::finder()->findByParticipantId($this->participant_id);
            $participants = array();
            foreach($participants_classifications as $p) {
                $p = DParticipantRecord::finder()->findByPK($p->participant_id);
                $p->relationship = $p;
                $participants[] = $p;
            }
            $this->_participants = $participants;
        }
        return $this->_participants;
    }

    public function getRelationship() {
        return $this->_relationship;
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

    public $classification_id;
    public $date;
    public $deleted;
    public $participant_classification_id;
    public $participant_id;

    public $TYPES = array(
        "classification_id"=>"integer",
        "date"=>"text",
        "deleted"=>"integer",
        "participant_classification_id"=>"integer",
        "participant_id"=>"integer",
    );

    // FOREIGN KEYS OBJECTS
    private $_classification = null;
    private $_participant = null;


    // FOREIGN KEYS METHODS
    public function getClassification() {
        if($this->_classification === null) {
            $this->_classification = DClassificationRecord::finder()->findByPK($this->classification_id);
        }
        return $this->_classification;
    }

    public function getParticipant() {
        if($this->_participant === null) {
            $this->_participant = DParticipantRecord::finder()->findByPK($this->participant_id);
        }
        return $this->_participant;
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

    // FOREIGN KEYS OBJECTS
    private $_admin = null;
    private $_thumbnail = null;

    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // FOREIGN KEYS METHODS
    public function getAdmin() {
        if($this->_admin === null) {
            $this->_admin = DAdminRecord::finder()->findByPK($this->admin_id);
        }
        return $this->_admin;
    }

    public function getMedia() {
        if($this->_media === null) {
            $this->_media = DMediaRecord::finder()->findByPK($this->thumbnail_id);
        }
        return $this->_media;
    }
    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findByPostId($this->post_id);
        }
        return $this->_events;
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

    public $deleted;
    public $description;
    public $name;
    public $privilege_id;

    public $TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "name"=>"text",
        "privilege_id"=>"integer",
    );


    // RELATIONSHIPS OBJECTS
    private $_privileges = null;
    private $_relationship = null;

    // RELATIONSHIPS METHODS
    public function getPrivileges() {
        if($this->_privileges === null) {
            $admins_privileges = DAdminPrivilegeRecord::finder()->findByPrivilegeId($this->privilege_id);
            $privileges = array();
            foreach($admins_privileges as $a) {
                $p = DPrivilegeRecord::finder()->findByPK($a->privilege_id);
                $p->relationship = $a;
                $privileges[] = $p;
            }
            $this->_privileges = $privileges;
        }
        return $this->_privileges;
    }

    public function getRelationship() {
        return $this->_relationship;
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

    public $deleted;
    public $description;
    public $logo_id;
    public $position;
    public $supporter_id;
    public $type;
    public $url;
    public $year;

    public $TYPES = array(
        "deleted"=>"integer",
        "description"=>"text",
        "logo_id"=>"integer",
        "position"=>"integer",
        "supporter_id"=>"integer",
        "type"=>"text",
        "url"=>"text",
        "year"=>"text",
    );

    // FOREIGN KEYS OBJECTS
    private $_logo = null;

    // RELATIONSHIPS OBJECTS
    private $_events = null;

    // FOREIGN KEYS METHODS
    public function getMedia() {
        if($this->_media === null) {
            $this->_media = DMediaRecord::finder()->findByPK($this->logo_id);
        }
        return $this->_media;
    }
    // RELATIONSHIPS METHODS
    public function getEvents() {
        if($this->_events === null) {
            $this->_events = DEventRecord::finder()->findBySupporterId($this->supporter_id);
        }
        return $this->_events;
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

