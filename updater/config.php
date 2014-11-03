<?php

function class_autoload( $pClassName ) {
	$file = __DIR__ . "/framework/Base/" . $pClassName . ".php";
	if ( file_exists( $file ) ) {
		require_once $file;
	}
	$file = __DIR__ . "/framework/Data/" . $pClassName . ".php";
	if ( file_exists( $file ) ) {
		require_once $file;
	}
	$file = __DIR__ . "/Data/" . $pClassName . ".php";
	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( "class_autoload" );

/*if ( $_SERVER['HTTP_HOST'] != 'localhost' ) {
	define( 'DB_NAME', 'szmitas_' . $_SESSION[S_DB_NAME] 'x' );
	define( 'DB_USER', 'szmitas_fp' );
	define( 'DB_PASSWORD', '7ryhQvQh' );
} else {*/
	define( 'DB_NAME', 'mydb' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'root' );
//}
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', 'utf8_polish_ci' );
# </database_config>
