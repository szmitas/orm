#!/usr/bin/php
<?php
require_once '../Includes/CLI.php';
        const DOT_FILL = 30;
        CONST HEADER_FILL = 32;

$config = require_once __DIR__ .'/../Config/database.php';

class DatabaseManager {

    public $db;
    public $config;

    public function __construct($config) {
        $this->config = $config;
        $this->connect();
    }

    public function connect() {
        $this->db = new PDO($this->config ['driver'], $this->config ['username'], $this->config ['password']);
    }

    public function createSchema() {
        $sql = "SELECT count(schema_name) as count FROM information_schema.schemata WHERE schema_name = 'public';";
        foreach ($this->db->query($sql) as $row) {
            $count = $row ['count'];
        }

        if ($count) {
            $result = $this->db->exec('ALTER SCHEMA public RENAME TO ' . 'zzz_old_' . time());
            if ($result === false) {
                $errorInfo = $this->db->errorInfo();
                throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
            }
        }
        $sql = "CREATE SCHEMA public";
        $result = $this->db->exec($sql);
        if ($result === false) {
            $errorInfo = $this->db->errorInfo();
            throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
        }
    }

    public function initialize() {
        if (!file_exists($this->config ['schema'])) {
            throw new Exception("Schema file('" . $this->config ['schema'] . "') is missing.");
        }
        $schema = file_get_contents( $this->config ['schema']);
        $result = $this->db->exec($schema);
        if ($result === false) {
            $errorInfo = $this->db->errorInfo();
            throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
        }
    }

    public function removeBackups() {
        $sql = "SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE 'zzz_old_%';";
        $backups = array();
        foreach ($this->db->query($sql) as $row) {
            preg_match("/zzz_old_(.*)/", $row ['schema_name'], $matches);
            $timestamp = $matches [1];
            $backups [$timestamp] = $row ['schema_name'];
            krsort($backups, SORT_NUMERIC);
        }
        if (count($backups) > 3) {
            $i = 1;
            foreach ($backups as $backup) {
                if ($i > 2 && $i !== count($backups) - 1) {
                    $result = $this->db->exec('DROP SCHEMA ' . $backup . ' CASCADE');
                    if ($result === false) {
                        $errorInfo = $this->db->errorInfo();
                        throw new Exception('SQL ERROR: ' . "\n" . $errorInfo [2]);
                    }
                }
                $i ++;
            }
        }
    }

}

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
