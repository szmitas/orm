#!/usr/bin/env php
<?php
require '../autoloader.php';
use Repel\Includes\CLI;
use Repel\Framework\DatabaseManager;

const DOT_FILL = 30;
const HEADER_FILL = 32;

$config = require_once __DIR__ . '/../src/Repel/Config/database.php';

try {
    echo CLI::h1('create default database', HEADER_FILL);
    // Connecting
    echo CLI::dotFill('connecting', DOT_FILL);
    $manager = new DatabaseManager($config);
    echo CLI::color("done", green);
    echo "\n";
    $result = $manager->db->exec('BEGIN;');
    if ($result === false) {
        $errorInfo = $this->db->errorInfo();
        throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
    }
    // Creating schema
    $count = 0;
    echo CLI::dotFill('creating schema', DOT_FILL);
    $manager->createSchema();
    echo CLI::color("done", green);
    echo "\n";
    // Initializing structure
    echo CLI::dotFill('initializing', DOT_FILL);
    $manager->initialize();
    echo CLI::color("done", green);
    echo "\n";
    // Removing old schemas
    echo CLI::dotFill('removing backups', DOT_FILL);
    $manager->removeBackups();
    echo CLI::color("done", green);
    echo "\n";
    $result = $manager->db->exec('COMMIT;');
    if ($result === false) {
        $errorInfo = $this->db->errorInfo();
        throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
    }
    echo CLI::color("SUCCESS", 'white', 'green');
    echo "\n";
} catch (Exception $e) {
    $result = $manager->db->exec('ROLLBACK;');
    echo CLI::color("failed", red);
    echo "\n";
    echo "\n";
    echo CLI::color($e->getMessage(), 'white', 'red');
    echo "\n";
    echo "\n";
    die();
}
?>
