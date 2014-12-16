<?php

namespace Repel\Framework;

use Repel\Adapter\Generator;

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
        return $this->findOneByColumn(Generator\BaseGenerator::tableToPK($this->_record->TABLE), $key);
    }

    public function findByPKs($keys) {
        return $this->findByColumn(Generator\BaseGenerator::tableToPK($this->_record->TABLE), $keys);
    }

    public function findOne($criteria = null, $parameters = array()) {
        if (!$criteria instanceof RActiveRecordCriteria) {
            $criteria = new RActiveRecordCriteria($criteria, $parameters);
        }

        $criteria->Limit = 1;

        return RExecutor::instance($this->_record)->find($criteria, true);
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

    public function findOneByColumn($column, $value) {
        $criteria = new RActiveRecordCriteria();

        if (is_array($value)) {
            $i = 0;
            $in_values = "";

            foreach ($value as $v) {
                $in_values .= ":{$column}{$i}, ";
                $criteria->Parameters[":{$column}{$i}"] = $v;
                $i++;
            }

            $criteria->Condition = "{$column} IN ( " . substr($in_values, 0, strlen($in_values) - 2) . " )";
        } else {
            $criteria->Condition = "{$column} = :{$column}";
            $criteria->Parameters[":{$column}"] = $value;
        }
        $criteria->Limit = 1;

        return RExecutor::instance($this->_record)->find($criteria, false);
    }

    public function findByColumn($column, $value) {
        $criteria = new RActiveRecordCriteria();

        if (is_array($value)) {
            $i = 0;
            $in_values = "";

            foreach ($value as $v) {
                $in_values .= ":{$column}{$i}, ";
                $criteria->Parameters[":{$column}{$i}"] = $v;
                $i++;
            }

            $criteria->Condition = "{$column} IN ( " . substr($in_values, 0, strlen($in_values) - 2) . " )";
        } else {
            $criteria->Condition = "{$column} = :{$column}";
            $criteria->Parameters[":{$column}"] = $value;
        }

        return RExecutor::instance($this->_record)->find($criteria, true);
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

    // todo
    public function findBySql($statement, $criteria = null) {
//        if ($criteria !== null) {
//            return $this->execute($statement, $criteria);
//        }
    }

}
