<?php

class FDbConnection {

    private static $singleton;
    private static $db_name;
    public $PDOInstance;

    // Jak dla mnie wystarczy podac argumenty jak do PDO, driver, user i password,
    // ale nie wnikam
    private function __construct($db_type, $host, $db_name, $db_user, $db_password, $db_charset, $db_collate) {
        $this->db_name = $db_name;
        $this->PDOInstance = new FPDO($db_type . ":host=" . $host . ";dbname=" . $db_name, $db_user, $db_password);
        $this->PDOInstance->query("SET NAMES " . $db_charset . " COLLATE " . $db_collate);
        $this->PDOInstance->query("SET time_zone = 'Europe/Warsaw'");
        //$this->PDOInstance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    public static function instance($db_type, $host, $db_name, $db_user, $db_password, $db_charset, $db_collate) {
        if (!(self::$singleton instanceof self) || self::$singleton->db_name !== $db_name) {
            self::$singleton = new self($db_type, $host, $db_name, $db_user, $db_password, $db_charset, $db_collate);
        }
        return self::$singleton;
    }

    public static function get() {
        return self::instance()->PDOInstance;
    }

}
