<?php

namespace Repel\Framework;

class RExecutor extends FPDO {

    protected $PDO;
    private $_record;

    public function __construct($record) {
        $this->_record = $record;

        $repel_db_config = require_once __DIR__ . "/../Config/database.php";

        $connection = FDbConnection::instance($repel_db_config['driver'], $repel_db_config['username'], $repel_db_config['password']);
        $this->PDO = $connection->PDOInstance;
    }

    public function find(RActiveRecordCriteria $criteria) {
        $table_name = $this->_record->TABLE;

        $statement = "SELECT * FROM {$table_name}";

        if ($criteria->Condition !== null) {
            $statement .= " WHERE " . $criteria->Condition;
        }

        if ($criteria->OrdersBy !== null) {
            $statement .= " ORDER BY";
            foreach ($criteria->OrdersBy as $key => $value) {
                if (in_array(strtoupper($value), array("ASC", "DESC"))) {
                    $statement .= " " . $key . " " . strtoupper($value) . ",";
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
        }

        $st = $this->PDO->prepare($statement);
        $primary_key = FString::camelize_name($this->_record->TABLE) . "_id";

        foreach ($params as $key => &$value) {
            $st->bindParam($key, $value, \PDO::PARAM_STR);
        }

        if (!$st->execute()) {
            throw new Exception("Error during query execution: " . implode(":", $st->errorInfo()));
        } else {
            if ($simple) {
                return $st->fetchAll();
            } else {
                if (substr($statement, 0, 6) === "SELECT") {
                    if ($multiple) {
                        return $this->resultToObjectsArray($st->fetchAll(PDO::FETCH_CLASS));
                    } else {
                        return $this->resultToObject($st->fetch());
                    }
                } else if (substr($statement, 0, 6) === "INSERT") {
                    return $this->PDO->lastInsertId();
                } else if (substr($statement, 0, 6) === "UPDATE") {
                    return $st->rowCount();
                }
            }
        }
    }

    protected function resultToObjectsArray($results) {
        if (count($results) > 0) {
            $class_name = get_class($this->_record);
            $results_records = array();
            foreach ($results as $result) {
                $class_obj = new $class_name;

                foreach ($result as $key => $value) {
                    $class_obj->$key = $value;
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
            $class_name = get_class($this->_record);
            $class_obj = new $class_name;

            $keys = array_keys($result);

            foreach ($keys as $key) {
                $class_obj->$key = $result[$key];
            }

            $class_obj->_record = true;

            return $class_obj;
        } else {
            return null;
        }
    }

}
