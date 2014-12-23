<?php
$config = require_once __DIR__ . '/../src/Repel/Config/database.php';
$config['model_file_path'] = '../maciej2.php';
$config['model_directory_path'] = '../app/data';
$config['public_schema'] = 'public';
return $config;