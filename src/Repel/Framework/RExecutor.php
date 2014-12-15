<?php

namespace Repel\Framework;

class RExecutor {
    
    public static function find(RActiveRecordCriteria $criteria) {
        print_r($criteria);
    }
}

