<?php

return array(
    "primary" => array(
        'driver' => 'pgsql:dbname=repel;host=localhost',
        'type' => 'pgsql',
        'database' => 'repel',
        'host' => 'localhost',
//    'username' => 'postgres',
//    'password' => 'trebiras',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'collate' => 'utf8_polish_ci',
        'schema' => '../_sql/schema.sql'
    )
);
