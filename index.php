<?php

try {
    require_once __DIR__ . '/Config/config.php';
    require_once __DIR__ . '/_scripts/maciej2.php';
//	$admin_rec2 = DAdminRecord::finder()->findAll("login != :login AND email != :email", array(":login" => "admin1", ":email" => "email1"));
//	
//	print_r($admin_rec2);
//	
//	$criteria = new FActiveRecordCriteria();
//	$criteria->Condition = "login != :login AND email != :email";
//	$criteria->Parameters[":login"] = "admin1";
//	$criteria->Parameters[":email"] = "email1";
//
//	$admin_rec = DAdminRecord::finder()->findAll($criteria);
//	print_r($admin_rec);
//	$admin_rec2 = DAdminRecord::finder()->find("login != :login AND email != :email", array(":login" => "admin1", ":email" => "email1"));
//	
//	print_r($admin_rec2);
//	
//	$criteria = new FActiveRecordCriteria();
//	$criteria->Condition = "login != :login AND email != :email";
//	$criteria->Parameters[":login"] = "admin1";
//	$criteria->Parameters[":email"] = "email1";
//	$criteria->Offset = 2;
//
//	$admin_rec = DAdminRecord::finder()->find($criteria);
//	print_r($admin_rec);
//	$admin_rec2 = DAdminRecord::finder()->count("login != :login AND email != :email", array(":login" => "admin1", ":email" => "email1"));
//	
//	print_r($admin_rec2);
//	
//	$criteria = new FActiveRecordCriteria();
//	$criteria->Condition = "login != :login AND email != :email";
//	$criteria->Parameters[":login"] = "admin1";
//	$criteria->Parameters[":email"] = "email1";
//
//	$admin_rec = DAdminRecord::finder()->count($criteria);
//	print_r($admin_rec);
//	$admin_rec2 = DAdminRecord::finder()->findByPk( 2 );
//	print_r( $admin_rec2 );
//	$admin_rec2 = DAdminRecord::finder()->findAllByPks( array(2, 3, 4) );
//	print_r( $admin_rec2 );
//	$admin_rec = new DUserRecord();
//	$admin_rec->login = "test";
//	$admin_rec->password = "password";
//	$admin_rec->save();
//	print_r($admin_rec);
//	$admin_rec->delete();
//	print_r($admin_rec);
} catch (Exception $e) {
    echo $e;
}
	
