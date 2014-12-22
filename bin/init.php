#!/usr/bin/env php
<?php
require '../autoloader.php';

use Repel\Includes\CLI;
use Repel\Adapter\Adapter;
use Repel\Adapter\Generator;
use Repel\Adapter\Fetcher;

$config = require_once 'private_config.php';

try {
    // Create Instance and connect
    $adapter = new Adapter($config);
    $adapter->addFetcher(new Fetcher\PostgreSQLFetcher('primary'))
            ->addFetcher(new Fetcher\PhpManyToManyFetcher(__DIR__.'/../relationships.php'))
            ->fetch()
            ->addGenerator(new Generator\RepelGenerator(__DIR__.'/../app/Data/') )
            ->generate();
    echo CLI::success();
} catch (Exception $ex) {
    echo CLI::failure($ex);
    die();
}