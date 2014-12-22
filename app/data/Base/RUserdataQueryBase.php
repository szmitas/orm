<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RUserdataQueryBase extends RActiveQuery {

	public $TYPES = array(
		"address" => "text",
		"city" => "text",
		"date_created" => "timestamp with time zone",
		"first_name" => "text",
		"last_name" => "text",
		"user_data_id" => "integer",
		"user_id" => "integer",
		"zip" => "text",
	);
	public function findByAddress($address) {
		return self::findByColumn("address", $address);
	}

	public function findByCity($city) {
		return self::findByColumn("city", $city);
	}

	public function findByDateCreated($date_created) {
		return self::findByColumn("date_created", $date_created);
	}

	public function findByFirstName($first_name) {
		return self::findByColumn("first_name", $first_name);
	}

	public function findByLastName($last_name) {
		return self::findByColumn("last_name", $last_name);
	}

	public function findByUserDataId($user_data_id) {
		return self::findByColumn("user_data_id", $user_data_id);
	}

	public function findByUserId($user_id) {
		return self::findByColumn("user_id", $user_id);
	}

	public function findByZip($zip) {
		return self::findByColumn("zip", $zip);
	}

	public function findOneByAddress($address) {
		return self::findOneBy("address", $address);
	}

	public function findOneByCity($city) {
		return self::findOneBy("city", $city);
	}

	public function findOneByDateCreated($date_created) {
		return self::findOneBy("date_created", $date_created);
	}

	public function findOneByFirstName($first_name) {
		return self::findOneBy("first_name", $first_name);
	}

	public function findOneByLastName($last_name) {
		return self::findOneBy("last_name", $last_name);
	}

	public function findOneByUserDataId($user_data_id) {
		return self::findOneBy("user_data_id", $user_data_id);
	}

	public function findOneByUserId($user_id) {
		return self::findOneBy("user_id", $user_id);
	}

	public function findOneByZip($zip) {
		return self::findOneBy("zip", $zip);
	}

	public function filterByAddress($address) {
		return self::filterByColumn("address", $address);
	}

	public function filterByCity($city) {
		return self::filterByColumn("city", $city);
	}

	public function filterByDateCreated($date_created) {
		return self::filterByColumn("date_created", $date_created);
	}

	public function filterByFirstName($first_name) {
		return self::filterByColumn("first_name", $first_name);
	}

	public function filterByLastName($last_name) {
		return self::filterByColumn("last_name", $last_name);
	}

	public function filterByUserDataId($user_data_id) {
		return self::filterByColumn("user_data_id", $user_data_id);
	}

	public function filterByUserId($user_id) {
		return self::filterByColumn("user_id", $user_id);
	}

	public function filterByZip($zip) {
		return self::filterByColumn("zip", $zip);
	}

	// others
}
