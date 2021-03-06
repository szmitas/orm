<?php

namespace Repel\Framework;

class RTransaction extends \PDO {

    protected static $savepointTransactions = array("pgsql", "mysql");
    // The current transaction level.
    protected $transLevel = 0;
    private static $singleton;
    protected $PDO;

    public function __construct() {
        $repel_db_config = require __DIR__ . "/../Config/database.php";

        $connection = FDbConnection::instance($repel_db_config["primary"]['driver'], $repel_db_config["primary"]['username'], $repel_db_config["primary"]['password']);
        $this->PDO = $connection->PDOInstance;
    }

    public static function instance(RActiveRecord $record) {
        if (!(self::$singleton instanceof self) || self::$singleton->_record !== $record) {
            self::$singleton = new self($record);
        }
        return self::$singleton;
    }

    protected function nestable() {
        return in_array($this->PDO->getAttribute(\PDO::ATTR_DRIVER_NAME), self::$savepointTransactions);
    }

    public function beginTransaction() {
        if (!$this->nestable() || $this->transLevel == 0) {
            $this->PDO->beginTransaction();
        } else {
            $this->PDO->exec("SAVEPOINT LEVEL{$this->transLevel}");
        }

        $this->transLevel++;
    }

    public function commit() {
        $this->transLevel--;

        if (!$this->nestable() || $this->transLevel == 0) {
            $this->PDO->commit();
        } else {
            $this->PDO->exec("RELEASE SAVEPOINT LEVEL{$this->transLevel}");
        }
    }

    public function rollBack() {
        $this->transLevel--;

        if (!$this->nestable() || $this->transLevel == 0) {
            $this->PDO->rollBack();
        } else {
            $this->PDO->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->transLevel}");
        }
    }

}
