#!/usr/bin/env php
<?php
require '../autoloader.php';

use Repel\Includes\CLI;
use Repel\Adapter\Adapter;
use Repel\Adapter\Fetcher;

$config = require_once 'private_config.php';

try {
    // Create Instance and connect
    $adapter = new Adapter($config);
    $adapter->addFetcher(new Fetcher\PostgreSQLFetcher('primary'))
            ->addFetcher(new Fetcher\PhpManyToManyFetcher(__DIR__.'/../relationships.php'))
            ->addGenerator(new Generator\phpGenerator() )
            ->fetch()
            ->save();
} catch (Exception $ex) {
    echo CLI::failure($ex);
    die();
}