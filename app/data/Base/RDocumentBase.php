<?php

namespace data\Base;

use Repel\Framework\RActiveRecord;

class RDocumentBase extends RActiveRecord {

	public $TABLE = "documents";

	// properties
	public $content;
	public $date;
	public $document_id;
	public $full_number;
	public $user_data_id;

	public $TYPES = array(
		"content" => "text",
		"date" => "timestamp with time zone",
		"document_id" => "integer",
		"full_number" => "text",
		"user_data_id" => "integer",
	);
	// foreign key objects
	private $_company = null;
	private $_admin = null;
	private $_privilege = null;
	private $_user_data = null;


}

