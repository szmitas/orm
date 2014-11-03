<?php

function class_autoload( $pClassName ) {
    
	$file = __DIR__ . "../framework/Base/" . $pClassName . ".php";
        
	if ( file_exists( $file ) ) {
		require_once $file;
	}
	$file = __DIR__ . "../framework/Data/" . $pClassName . ".php";
	if ( file_exists( $file ) ) {
		require_once $file;
	}
	$file = __DIR__ . "/../data/" . $pClassName . ".php";
        print_r($file);
	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( "class_autoload" );

$config = require_once 'database.php';

// sugerowałbym Dependency Injection zamiast Define
define( 'DB_NAME', $config['database_name'] );
define( 'DB_TYPE', $config['type'] );
define( 'DB_USER', $config['username'] );
define( 'DB_PASSWORD', $config['password'] );
define( 'DB_HOST', $config['host'] );
define( 'DB_CHARSET', $config['charset'] );
define( 'DB_COLLATE', $config['collate'] );


