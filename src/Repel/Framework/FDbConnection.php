<?php

namespace Repel\Framework;

class FDbConnection {

    private static $singleton;
    private $_driver;
    public $PDOInstance;

    private function __construct($driver, $user, $password) {
        $this->_driver = $driver;
        $this->PDOInstance = new \PDO($driver, $user, $password);
//        $this->PDOInstance->query("SET NAMES " . $db_charset . " COLLATE " . $db_collate);
        $this->PDOInstance->query("SET TIME ZONE 'Europe/Warsaw'");
        //$this->PDOInstance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    public static function instance($driver, $user, $password) {
        if (!(self::$singleton instanceof self) || self::$singleton->_driver !== $driver) {
            self::$singleton = new self($driver, $user, $password);
        }
        return self::$singleton;
    }

    public static function get() {
        return self::instance()->PDOInstance;
    }

}
