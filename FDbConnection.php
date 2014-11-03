<?php

class FDbConnection {

	private static $singleton;
	private static $db_name;
	public $PDOInstance;

	private function __construct( $host, $db_name, $db_user, $db_password, $db_charset, $db_collate ) {
		$this->db_name = $db_name;
		if ( $_SERVER['HTTP_HOST'] != 'localhost' ) {
			$this->PDOInstance = new FPDO( "mysql:host=" . $host . ";dbname=szmitas_" . $db_name, $db_user, $db_password );
		} else {
			$this->PDOInstance = new FPDO( "mysql:host=" . $host . ";dbname=" . $db_name, $db_user, $db_password );
		}
		$this->PDOInstance->query( "SET NAMES " . $db_charset . " COLLATE " . $db_collate );
		$this->PDOInstance->query( "SET time_zone = 'Europe/Warsaw'" );
		//$this->PDOInstance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}

	public static function instance( $host, $db_name, $db_user, $db_password, $db_charset, $db_collate ) {
		if ( !(self::$singleton instanceof self) || self::$singleton->db_name !== $db_name ) {
			self::$singleton = new self( $host, $db_name, $db_user, $db_password, $db_charset, $db_collate );
		}
		return self::$singleton;
	}

	public static function get() {
		return self::instance()->PDOInstance;
	}

}
