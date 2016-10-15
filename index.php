<?php

use Repel\Config;
use Repel\Framework;

try {
    require_once 'autoloader.php';
} catch (Exception $e) {
    echo $e;
}

$company = new data\DCompany();
var_dump($company);
