<?php

namespace Repel\Framework;

use Repel\Adapter\Generator;

class RActiveQuery {

    protected $PDO;
    protected $_record;
    protected $_recordClass;
    protected $_table;
    private $_where;

    public function __construct($record) {
        if (!isset($record)) {
            throw new Exception('Trying to construct a query, without its parent record');
        }
        $this->_recordClass = $record;
        $this->_record = new $record();
        $this->_table = $this->_record->TABLE;
        $this->_where = array();
    }

    public function findByPK($key) {
        return $this->findOneByColumn(Generator\BaseGenerator::tableToPK($this->_record->TABLE), $key);
    }

    public function findByPKs($keys) {
        return $this->findByColumn(Generator\BaseGenerator::tableToPK($this->_record->TABLE), $keys);
    }

    public function findOne($criteria = null, $parameters = array()) {
        if ($criteria !== null) {
            if (!$criteria instanceof RActiveRecordCriteria) {
                $criteria = new RActiveRecordCriteria($criteria, $parameters);
            }
        } else {
            $criteria = new RActiveRecordCriteria($this->_where);
            $this->_where = array();
        }

        $criteria->Limit = 1;

        return RExecutor::instance($this->_record)->find($criteria, false);
    }

    public function find($criteria = null, $parameters = array()) {
        if ($criteria !== null) {
            if (!$criteria instanceof RActiveRecordCriteria) {
                $criteria = new RActiveRecordCriteria($criteria, $parameters);
            }
        } else {
            $criteria = new RActiveRecordCriteria($this->_where);
            $this->_where = array();
        }

        return RExecutor::instance($this->_record)->find($criteria, true);
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

            $criteria->Condition = "{$this->_table}.{$column} IN ( " . substr($in_values, 0, strlen($in_values) - 2) . " )";
        } else {
            $criteria->Condition = "{$this->_table}.{$column} = :{$column}";
            $criteria->Parameters[":{$column}"] = $value;
        }

        return RExecutor::instance($this->_record)->find($criteria, true);
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

            $criteria->Condition = "{$this->_table}.{$column} IN ( " . substr($in_values, 0, strlen($in_values) - 2) . " )";
        } else {
            $criteria->Condition = "{$this->_table}.{$column} = :{$column}";
            $criteria->Parameters[":{$column}"] = $value;
        }

        return RExecutor::instance($this->_record)->find($criteria, false);
    }

    public function filterByColumn($column, $value, $operator = "=") {
        $count = count($this->_where);
        $this->_where[] = array(
            "condition" => "{$this->_table}.{$column} {$operator} :{$column}{$count}",
            "parameters" => array(":{$column}{$count}", $value)
        );
        return $this;
    }

    public function count($criteria = null, $parameters = array()) {
        if ($criteria !== null && $parameters !== null) {
            if (!$criteria instanceof RActiveRecordCriteria) {
                $criteria = new RActiveRecordCriteria($criteria, $parameters);
            }
        } else {
            $criteria = new RActiveRecordCriteria($this->_where);
            $this->_where = array();
        }

        return RExecutor::instance($this->_record)->count($criteria);
    }

    public function findBySql($statement, $criteria = null) {
        // todo
    }

}
