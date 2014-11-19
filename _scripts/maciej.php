<?php
class _BaseActiveRecords {};

class DMaciejRecord extends FActiveRecord {

    const TABLE = "maciej";

    public $login;
    public $password;
    public $user_id;

    const TYPES = array(
        "login"=>"text",
        "password"=>"text",
        "user_id"=>"integer",
    );


    public function delete() {
        throw new Exception('Cannot delete a view record.');
    }
}
class DPrivilegesRecord extends FActiveRecord {

    const TABLE = "privileges";

    public $name;
    public $privilege_id;

    const TYPES = array(
        "name"=>"text",
        "privilege_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DUsersRecord extends FActiveRecord {

    const TABLE = "users";

    public $login;
    public $password;
    public $user_id;

    const TYPES = array(
        "login"=>"text",
        "password"=>"text",
        "user_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
class DUsers_privilegesRecord extends FActiveRecord {

    const TABLE = "users_privileges";

    public $description;
    public $privilege_id;
    public $user_id;

    const TYPES = array(
        "description"=>"text",
        "privilege_id"=>"integer",
        "user_id"=>"integer",
    );


    public function delete() {
        $this->deleted = time();
        $this->save();
    }
}
