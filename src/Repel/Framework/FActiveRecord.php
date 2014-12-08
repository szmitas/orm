<?php
namespace Repel\Framework;
class FActiveRecord extends FPDO {

    private $PDO;
    private $_record = false;

    public function __construct() {
        global $repel_db_config;

        $connection = FDbConnection::instance($repel_db_config['driver'], $repel_db_config['username'], $repel_db_config['password']);
        $this->PDO = $connection->PDOInstance;
    }
    
    static public function finder() {
		$className = get_called_class ();
		$queryClass = $className . 'Query';
		return new $queryClass ( $className );
	}

    public function save() {
        $primary_key = FString::camelize_name($this->TABLE) . "_id";

        $criteria = new FActiveRecordCriteria();

        if ($this->_record) {
            $statement = "UPDATE " . $this->TABLE . " SET ";
            foreach ($this->TYPES as $property => $type) {
                $statement .= "`" . $property . "` = :" . $property . ", ";
                $criteria->Parameters[":" . $property] = $this->$property;
            }

            $statement = substr($statement, 0, strlen($statement) - 2);
            $statement .= " WHERE " . $primary_key . " = :" . $primary_key;
            $criteria->Parameters[":" . $primary_key] = $this->$primary_key;
        } else {
            $statement = "INSERT INTO " . $this->TABLE . "( ";

            $values = "( ";
            foreach ($this->TYPES as $property => $type) {
                $statement .= "`" . $property . "`, ";
                $values .= ":" . $property . ", ";
                $criteria->Parameters[":" . $property] = $this->$property;
            }
            $statement = substr($statement, 0, strlen($statement) - 2);
            $values = substr($values, 0, strlen($values) - 2);

            $statement .= " ) VALUES " . $values . " )";
        }

        if ($this->$primary_key === null) {
            $this->$primary_key = $this->PDO->execute($statement, $criteria);
            if ($this->$primary_key > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->PDO->execute($statement, $criteria)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // To Tu nie powinno być
    public function beginTransaction() {
        return $this->PDO->beginTransaction();
    }

    public function commit() {
        return $this->PDO->commit();
    }

    public function rollback() {
        return $this->PDO->rollback();
    }

}
