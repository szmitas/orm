<?php

return array(
    'primary' => array(
        'driver' => 'pgsql:dbname=test;host=localhost',
        'type' => 'pgsql',
        'database' => 'test',
//        'database' => 'szmitas_lbn',
        'host' => 'localhost',
        'username' => 'postgres',
        'password' => 'trebiras',
//        'username' => 'root',
//        'password' => 'root',
        'charset' => 'utf8',
        'collate' => 'utf8_polish_ci',
        'schema' => '../_sql/schema.sql'
    )
);
