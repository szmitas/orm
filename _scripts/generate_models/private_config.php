<?php
$config = require_once __DIR__ . '/../../Config/database.php';
$config['model_file_path'] = '../maciej2.php';
$config['public_schema'] = 'public';
return $config;