<?php

namespace data\Base;

use Repel\Framework\RActiveQuery;

class RDocumentQueryBase extends RActiveQuery {

	public $TYPES = array(
		"content" => "text",
		"date" => "timestamp with time zone",
		"document_id" => "integer",
		"full_number" => "text",
		"user_data_id" => "integer",
	);
	public function findByContent($content) {
		return self::findByColumn("content", $content);
	}

	public function findByDate($date) {
		return self::findByColumn("date", $date);
	}

	public function findByDocumentId($document_id) {
		return self::findByColumn("document_id", $document_id);
	}

	public function findByFullNumber($full_number) {
		return self::findByColumn("full_number", $full_number);
	}

	public function findByUserDataId($user_data_id) {
		return self::findByColumn("user_data_id", $user_data_id);
	}

	public function findOneByContent($content) {
		return self::findOneBy("content", $content);
	}

	public function findOneByDate($date) {
		return self::findOneBy("date", $date);
	}

	public function findOneByDocumentId($document_id) {
		return self::findOneBy("document_id", $document_id);
	}

	public function findOneByFullNumber($full_number) {
		return self::findOneBy("full_number", $full_number);
	}

	public function findOneByUserDataId($user_data_id) {
		return self::findOneBy("user_data_id", $user_data_id);
	}

	public function filterByContent($content) {
		return self::filterByColumn("content", $content);
	}

	public function filterByDate($date) {
		return self::filterByColumn("date", $date);
	}

	public function filterByDocumentId($document_id) {
		return self::filterByColumn("document_id", $document_id);
	}

	public function filterByFullNumber($full_number) {
		return self::filterByColumn("full_number", $full_number);
	}

	public function filterByUserDataId($user_data_id) {
		return self::filterByColumn("user_data_id", $user_data_id);
	}

	// others
}
