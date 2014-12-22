<?php

namespace Repel\Framework;

class RActiveRecord {

    public $_record = false;

    public function __construct() {
        
    }

    static public function finder() {
        $className = get_called_class();
        $queryClass = $className . 'Query';
        return new $queryClass($className);
    }

    public function save() {
 
        if ($this->_record) {
            return RExecutor::instance($this)->update();
        } else {
            return RExecutor::instance($this)->insert();
        }
    }
    
    public function delete() {
        if ($this->_record) {
            return RExecutor::instance($this)->delete();
        }
    }

}
