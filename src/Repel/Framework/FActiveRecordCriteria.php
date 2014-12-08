<?php
namespace Repel\Framework;
class FActiveRecordCriteria extends FComponent {

    public $condition;
    public $parameters;
    public $ordersby;
    public $limit;
    public $offset;

    public function __construct($condition = null, $parameters = null) {
        $this->condition = $condition;
        if ($parameters === null) {
            $this->parameters = array();
        } else {
            $this->parameters = $parameters;
        }
    }

}
