<?php

namespace Repel\Framework;

class RActiveQuery {

    protected $PDO;
    protected $_record;
    protected $_recordClass;

    public function __construct($record) {
        if (!isset($record)) {
            throw new Exception('Trying to construct a query, without its parent record');
        }
        $this->_recordClass = $record;
        $this->_record = new $record();
    }

    public function findByPK($key) {
        $primary_key = FString::camelize_name($this->_record->TABLE) . "_id";

        $criteria = new RActiveRecordCriteria();
        $criteria->Condition = $primary_key . " = :" . $primary_key;
        $criteria->Parameters[$primary_key] = $key;

        return $this->findOne($criteria);
    }

    public function findByPKs($keys) {
        if (count($keys)) {
            $primary_key = FString::camelize_name($this->_record->TABLE) . "_id";

            $criteria = new RActiveRecordCriteria();

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
//        if ($criteria !== null) {
//            return $this->execute($statement, $criteria);
//        }
    }

    public function findOne($criteria = null, $parameters = array()) {
        if (!$criteria instanceof RActiveRecordCriteria) {
            $criteria = new RActiveRecordCriteria($criteria, $parameters);
        }

        $criteria->Limit = 1;

        return $this->execute($criteria);
    }

    public function findByColumn($column, $value) {
        $criteria = new RActiveRecordCriteria();
        $criteria->Condition = "{$column} = :{$column}";
        $criteria->Parameters[":{$column}"] = $value;

        return $this->execute($criteria);
    }

    public function findOneByColumn($column, $value) {
        $criteria = new RActiveRecordCriteria();
        $criteria->Condition = "{$column} = :{$column}";
        $criteria->Parameters[":{$column}"] = $value;
        $criteria->Limit = 1;

        return $this->execute($criteria);
    }

    public function find($criteria = null, $parameters = array()) {
//        if (!isset($this->_record->TABLE)) {
//            throw new Exception('Unknown table name.');
//        }
//        $statement = "SELECT * FROM " . $this->_record->TABLE;
//
//        if (!$criteria instanceof RActiveRecordCriteria) {
//            $criteria = new RActiveRecordCriteria($criteria, $parameters);
//        }
//        return $this->execute($statement, $criteria, $parameters, true);
    }

    public function count($criteria = null, $parameters = array()) {
//        $statement = "SELECT COUNT(*) FROM " . $this->_record->TABLE;
//
//        if (!$criteria instanceof RActiveRecordCriteria) {
//            $criteria = new RActiveRecordCriteria($criteria, $parameters);
//        }
//        $result = $this->execute($statement, $criteria, $parameters, false, true);
//
//        return $result[0]["COUNT(*)"];
    }

    public function execute(RActiveRecordCriteria $criteria) {
        $executor = new RExecutor($this->_record);
        return $executor->find($criteria);
    }

}
