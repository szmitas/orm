<?php

if (file_exists($file = __DIR__ . '/vendor/autoload.php')) {
    $loader = require $file;
    print_r($loader);
    $loader->add('Repel', array());
//    $loader->add('Propel\Tests', array(
//        __DIR__ . '/tests',
//        __DIR__ . '/tests/Fixtures/bookstore/build/classes',
//        __DIR__ . '/tests/Fixtures/schemas/build/classes',
//        __DIR__ . '/tests/Fixtures/quoting/build/classes'
//    ));
    $loader->register();
}
    