<?php

class FActiveRecord extends FPDO {

    private $PDO;
    private $_record = false;

    public function __construct() {
        global $repel_db_config;

        $connection = FDbConnection::instance($repel_db_config['driver'], $repel_db_config['username'], $repel_db_config['password']);
        $this->PDO = $connection->PDOInstance;
    }

    public function save() {
        $primary_key = $this->camelize_name($this->TABLE) . "_id";

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
            $this->$primary_key = $this->execute($statement, $criteria);
            if ($this->$primary_key > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->execute($statement, $criteria)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function findByPK($key) {
        $primary_key = $this->camelize_name($this->TABLE) . "_id";

        $criteria = new FActiveRecordCriteria();
        $criteria->Condition = $primary_key . " = :" . $primary_key;
        $criteria->Parameters[$primary_key] = $key;

        return $this->findOne($criteria);
    }

    public function findByPKs($keys) {
        if (count($keys)) {
            $primary_key = $this->camelize_name($this->TABLE) . "_id";

            $criteria = new FActiveRecordCriteria();

            $i = 0;
            $in_values = "";

            foreach ($keys as $key) {
                $in_values .= ":" . $primary_key . $i . ", ";
                $criteria->Parameters[":" . $primary_key . $i] = $key;
                $i++;
            }

            $criteria->Condition = $primary_key . " IN ( " . substr($in_values, 0, strlen($in_values) - 2) . " )";

            return $this->find($criteria);
        } else {
            return array();
        }
    }

    public function findBySql($statement, $criteria = null) {
        if ($criteria !== null) {
            return $this->execute($statement, $criteria);
        }
    }

    public function findOne($criteria = null, $parameters = array()) {
        $statement = "SELECT * FROM " . $this->TABLE;

        if (!$criteria instanceof FActiveRecordCriteria) {
            $criteria = new FActiveRecordCriteria($criteria, $parameters);
        }

        $criteria->Limit = 1;

        return $this->execute($statement, $criteria, $parameters);
    }

    public function find($criteria = null, $parameters = array()) {
        $statement = "SELECT * FROM " . $this->TABLE;

        if (!$criteria instanceof FActiveRecordCriteria) {
            $criteria = new FActiveRecordCriteria($criteria, $parameters);
        }
        return $this->execute($statement, $criteria, $parameters, true);
    }

    public function count($criteria = null, $parameters = array()) {
        $statement = "SELECT COUNT(*) FROM " . $this->TABLE;

        if (!$criteria instanceof FActiveRecordCriteria) {
            $criteria = new FActiveRecordCriteria($criteria, $parameters);
        }
        $result = $this->execute($statement, $criteria, $parameters, false, true);
        return $result[0]["COUNT(*)"];
    }

    private function execute($statement, $criteria = null, $params = array(), $multiple = false, $simple = false) {
        if ($criteria !== null) {
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
        }
        $st = $this->PDO->prepare($statement);
        $primary_key = $this->camelize_name($this->TABLE) . "_id";

        foreach ($params as $key => &$value) {
            if (array_key_exists(str_replace(":", "", $key), $this->TYPES)) {
                $type = $this->TYPES[str_replace(":", "", $key)];
            } else {
                if (in_array($key, array(":results_limit", ":results_offset")) || strpos($primary_key, $key) == 0) {
                    $type = "int";
                } else {
                    $type = "string";
                }
            }
            $st->bindParam($key, $value, $type === "string" ? PDO::PARAM_STR : PDO::PARAM_INT );
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

    private function resultToObjectsArray($results) {
        if (count($results) > 0) {
            $class_name = get_called_class();
            $results_records = array();
            foreach ($results as $result) {
                $class_obj = new $class_name();

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

    private function resultToObject($result) {
        if ($result) {
            $class_name = get_called_class();
            $class_obj = new $class_name();

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

    private function camelize_name($name) {
        // delete -ies
        if (substr($name, strlen($name) - 3) == "ies") {
            $name = substr($name, 0, strlen($name) - 3);
            $name .= "y";
        }
        // delete -s
        if ($name[strlen($name) - 1] == "s") {
            $name = substr($name, 0, strlen($name) - 1);
        }

        while (substr_count($name, "ies_")) {
            $index = strpos($name, "ies_");
            $name = FString::replace_limit("ies_", "y_", $name);
        }

        while (substr_count($name, "s_")) {
            $index = strpos($name, "s_");
            $name = FString::replace_limit("s_", "_", $name);
        }

        return $name;
    }

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
