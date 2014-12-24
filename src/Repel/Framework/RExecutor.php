<?php

namespace Repel\Framework;

use Repel\Adapter\Generator;

class RExecutor {

    private static $singleton;
    private $_record;
    protected $PDO;

    public function __construct(RActiveRecord $record) {
        $this->record = $record;

        $repel_db_config = require __DIR__ . "/../Config/database.php";

        $connection = FDbConnection::instance($repel_db_config["primary"]['driver'], $repel_db_config["primary"]['username'], $repel_db_config["primary"]['password']);
        $this->PDO = $connection->PDOInstance;

        return $this;
    }

    public static function instance(RActiveRecord $record) {
        if (!(self::$singleton instanceof self) || self::$singleton->_record !== $record) {
            self::$singleton = new self($record);
        }
        return self::$singleton;
    }

    public function find(RActiveRecordCriteria $criteria, $multiple) {
        $table_name = $this->record->TABLE;

        $columns = "";
        foreach ($this->record->TYPES as $column => $type) {
            $columns .= "{$table_name}.{$column}, ";
        }
        $columns = substr($columns, 0, strlen($columns) - 2);

        $statement = "SELECT {$columns} FROM {$table_name}";

        if (strlen($criteria->Condition) > 0) {
            $statement .= " WHERE " . $criteria->Condition;
        }

        if ($criteria->OrdersBy !== null) {
            $statement .= " ORDER BY";
            foreach ($criteria->OrdersBy as $key => $value) {
                if (in_array(strtoupper($value), array("ASC", "DESC"))) {
                    $statement .= " {$table_name}." . $key . " " . strtoupper($value) . ",";
                } else {
                    throw new Exception("Wrong statement in ORDER BY clause: " . $value);
                }
            }
            $statement = substr($statement, 0, strlen($statement) - 1); // remove last ,
        }

        if ($criteria->Limit !== null && $criteria->Offset === null) {
            $statement .= " LIMIT :results_limit";
            $criteria->Parameters[":results_limit"] = (int) $criteria->Limit;
        } else if ($criteria->Limit !== null && $criteria->Offset !== null) {
            $statement .= " LIMIT :results_offset,:results_limit";
            $criteria->Parameters[":results_limit"] = (int) $criteria->Limit;
            $criteria->Parameters[":results_offset"] = (int) $criteria->Offset;
        }
        if (count($criteria->Parameters) > 0) {
            $params = $criteria->Parameters;
        } else {
            $params = array();
        }

        $result = $this->execute($statement, $params);

        if ($multiple) {
            return $this->resultToObjectsArray($result->fetchAll(\PDO::FETCH_CLASS));
        } else {
            return $this->resultToObject($result->fetch());
        }
    }

    public function insert() {
        $parameters = array();
        $statement = "INSERT INTO " . $this->record->TABLE . "( ";

        $values = "( ";
        foreach ($this->record->TYPES as $property => $type) {
            $statement .= "{$property}, ";
            $values .= ":" . $property . ", ";
            $parameters[":" . $property] = $this->record->$property;
        }
        $statement = substr($statement, 0, strlen($statement) - 2);
        $values = substr($values, 0, strlen($values) - 2);

        $statement .= " ) VALUES " . $values . " )";

        $this->execute($statement, $parameters);
        return $this->PDO->lastInsertId();
    }

    public function delete() {
        $primary_key = Generator\BaseGenerator::tableToPK($this->record->TABLE);

        //delete from admins where admin_id=1
        $parameters = array();
        $statement = "DELETE FROM {$this->record->TABLE} ";
        $statement .= " WHERE {$this->record->TABLE}.{$primary_key} = :{$primary_key}";
        $parameters[":{$primary_key}"] = $this->record->$primary_key;

        $result = $this->execute($statement, $parameters);
        return $result->rowCount();
    }

    public function update() {
        $primary_key = Generator\BaseGenerator::tableToPK($this->record->TABLE);

        $parameters = array();
        $statement = "UPDATE {$this->record->TABLE} SET ";

        foreach ($this->record->TYPES as $property => $type) {
            $statement .= "{$property} = :{$property}, ";
            $parameters[":{$property}"] = $this->record->$property;
        }

        $statement = substr($statement, 0, strlen($statement) - 2);
        $statement .= " WHERE {$this->record->TABLE}.{$primary_key} = :{$primary_key}";
        $parameters[":{$primary_key}"] = $this->record->$primary_key;

        $result = $this->execute($statement, $parameters);
        return $result->rowCount();
    }

    public function count(RActiveRecordCriteria $criteria) {
        $table_name = $this->record->TABLE;

        $statement = "SELECT COUNT(*) as count FROM {$table_name}";

        if (strlen($criteria->Condition) > 0) {
            $statement .= " WHERE " . $criteria->Condition;
        }

        if ($criteria->OrdersBy !== null) {
            $statement .= " ORDER BY";
            foreach ($criteria->OrdersBy as $key => $value) {
                if (in_array(strtoupper($value), array("ASC", "DESC"))) {
                    $statement .= " {$table_name}." . $key . " " . strtoupper($value) . ",";
                } else {
                    throw new Exception("Wrong statement in ORDER BY clause: " . $value);
                }
            }
            $statement = substr($statement, 0, strlen($statement) - 1); // remove last ,
        }

        if ((int) $criteria->Limit > 0 && (int) $criteria->Offset === 0) {
            $statement .= " LIMIT :results_limit";
            $criteria->Parameters[":results_limit"] = (int) $criteria->Limit;
        } else if ($criteria->Limit !== null && $criteria->Offset !== null) {
            $statement .= " LIMIT :results_offset,:results_limit";
            $criteria->Parameters[":results_limit"] = (int) $criteria->Limit;
            $criteria->Parameters[":results_offset"] = (int) $criteria->Offset;
        }
        if (count($criteria->Parameters) > 0) {
            $params = $criteria->Parameters;
        } else {
            $params = array();
        }

        $result = $this->execute($statement, $params);
        return $result->fetch()["count"];
    }

    private function execute($statement, $parameters) {
        $st = $this->PDO->prepare($statement);

        foreach ($parameters as $key => &$value) {
            $st->bindParam($key, $value, \PDO::PARAM_STR);
        }

        if ($st->execute()) {
            return $st;
        } else {
            throw new \Exception("Error during query execution: " . implode(":", $st->errorInfo()));
        }
    }

    protected function resultToObjectsArray($results) {
        if (count($results) > 0) {
            $class_name = get_class($this->record);
            $results_records = array();
            foreach ($results as $result) {
                $class_obj = new $class_name;

                foreach ($class_obj->TYPES as $key => $type) {
                    $class_obj->$key = $result->$key;
                }

                $class_obj->_record = true;

                $results_records[] = $class_obj;
            }
            return $results_records;
        } else {
            return array();
        }
    }

    protected function resultToObject($result) {
        if ($result) {
            $class_name = get_class($this->record);
            $class_obj = new $class_name;

            foreach ($class_obj->TYPES as $key => $type) {
                $class_obj->$key = $result[$key];
            }

            $class_obj->_record = true;

            return $class_obj;
        } else {
            return null;
        }
    }

}
