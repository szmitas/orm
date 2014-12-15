<?php

namespace Repel\Adapter\Fetcher;

use Repel\Adapter\Fetcher\FetcherInterface;

class PostgreSQLFetcher implements FetcherInterface {

    /**
     * 
     * @param type $db PDO handle to database connection
     * @param type $schema Fetch target
     */
    public function __construct($config, $schema = 'public') {
        $this->config = $config;
        $this->db = $config;
//        $this->db = new \PDO($this->config['driver'], $this->config['username'], $this->config['password']);
        $this->schema = $schema;
    }

    public function fetch($schema = null) {
        if ($schema) {
            $this->schema = $schema;
        }
        $sql = "select columns.table_name,tables.table_type,columns.column_name,columns.is_nullable,columns.data_type,constraints.constraint_type,constraints.referenced_table,constraints.referenced_column
FROM information_schema.tables tables JOIN information_schema.columns ON columns.table_name = tables.table_name 
AND columns.table_schema = tables.table_schema
 
left join (
   SELECT tc.constraint_name,
          tc.constraint_type,
          tc.table_name AS constraint_table_name,
          kcu.column_name AS constraint_column_name,
          ccu.table_name AS referenced_table,
          ccu.column_name AS referenced_column
          
 
     FROM information_schema.table_constraints tc
LEFT JOIN information_schema.key_column_usage kcu

       ON tc.constraint_catalog = kcu.constraint_catalog
      AND tc.constraint_schema = kcu.constraint_schema
      AND tc.constraint_name = kcu.constraint_name
      
LEFT JOIN information_schema.referential_constraints rc

       ON tc.constraint_catalog = rc.constraint_catalog
      AND tc.constraint_schema = rc.constraint_schema
      AND tc.constraint_name = rc.constraint_name
      
LEFT JOIN information_schema.constraint_column_usage ccu

       ON rc.unique_constraint_catalog = ccu.constraint_catalog
      AND rc.unique_constraint_schema = ccu.constraint_schema
      AND rc.unique_constraint_name = ccu.constraint_name


   WHERE tc.constraint_schema = '{$this->schema}') constraints ON constraints.constraint_column_name = columns.column_name AND constraints.constraint_table_name = columns.table_name
   WHERE columns.table_schema = '{$this->schema}' AND (constraints.constraint_type = 'PRIMARY KEY' OR constraints.constraint_type = 'FOREIGN KEY' OR constraints.constraint_type is null)
   
   ORDER BY columns.table_name,columns.column_name";

        return $this->db->query($sql);
    }

}
