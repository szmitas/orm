<?php

function class_autoload($pClassName) {
    $file = __DIR__ . "/../Framework/" . $pClassName . ".php";
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register("class_autoload");

$repel_db_config = require_once 'database.php';

define('DB_CONFIG_PATH', __DIR__ . "/database.php");
