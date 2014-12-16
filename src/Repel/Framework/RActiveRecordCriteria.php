<?php

namespace Repel\Framework;

class RActiveRecordCriteria extends FComponent {

    public $condition;
    public $parameters;
    public $ordersby;
    public $limit;
    public $offset;

    public function __construct($condition = null, $parameters = null) {
        if (is_array($condition)) {
            $temp_condition = array();
            $temp_parameters = array();
            foreach ($condition as $c) {
                $temp_condition[] = $c["condition"];
                $temp_parameters[$c["parameters"][0]] = $c["parameters"][1];
            }

            $this->condition = implode(" AND ", $temp_condition);
            $this->parameters = $temp_parameters;
        } else {
            $this->condition = $condition;
            if ($parameters === null) {
                $this->parameters = array();
            } else {
                $this->parameters = $parameters;
            }
        }
    }

}
