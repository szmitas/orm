<?php

namespace Repel\Adapter\Fetcher;

use Repel\Adapter\Fetcher\FetcherInterface;
use Repel\Adapter\Classes;

class phpManyToManyFetcher implements FetcherInterface {

    protected $config = null;
    protected $adapter = null;
    protected $connection_name;

    /**
     * 
     * @param type $db PDO handle to database connection
     * @param type $schema Fetch target
     */
    public function __construct($file_path = null) {
        if ($file_path) {
            $this->file_path = $file_path;
        } else {
            throw new \Exception('Fetcher phpManyToManyFetcher filepath not given.');
        }
    }

    public function setAdapter($adapter) {
        if (get_class($adapter) === 'Repel\Adapter\Adapter') {
            $this->adapter = $adapter;
        } else {
            throw new \Exception('Fetcher phpManyToManyFetcher wrong adapter instance given.');
        }
    }

    public function fetch() {
        $tables = include($this->file_path);
        $this->adapter->setManyToMany($tables);

    }

}
