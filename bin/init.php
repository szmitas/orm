#!/usr/bin/env php
<?php
require '../autoloader.php';

use Repel\Includes\CLI;
use Repel\Adapter\Adapter;

//require_once 'model_classes.php';
//require_once 'generators/php_Generator.php';
//require_once 'fetchers/PostgreSQL_Fetcher.php';

const DOT_FILL = 36;
const HEADER_FILL = 38;

$config = require_once 'private_config.php';

try {
    echo CLI::h1('generate models from db', HEADER_FILL);

    echo CLI::dotFill('connecting', DOT_FILL);
    // Create Instance and connect
    $dumper = new Adapter($config);
    echo CLI::color("done", green) . "\n";

    echo CLI::dotFill('fetching structure', DOT_FILL);
    // Fetch structure
    $dumper->fetch();
    echo CLI::color("done", green) . "\n";

    echo CLI::h1('saving models', HEADER_FILL);
    // Generate models and save to files
    $dumper->save();

    echo "\n";
    echo CLI::color("SUCCESS", 'white', 'green') . "\n";
    echo "\n";
} catch (Exception $ex) {
    echo CLI::color("failed", red) . "\n";
    echo "\n";
    echo CLI::color($ex->getMessage(), 'white', 'red') . "\n";
    echo "\n";
    die();
}

