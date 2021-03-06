<?php

namespace Repel\Adapter;

use Repel\Adapter\Fetcher;
use Repel\Includes\CLI;
use Repel\Adapter\Generator;
use Repel\Adapter\Classes\Table;
use Repel\Adapter\Classes\Relationship;
use Repel\Adapter\Classes\ForeignKey;
use Repel\Adapter\Classes\Column;

const DOT_FILL = 36;
const HEADER_FILL = 38;

class Adapter {

    protected $db;
    public $config;
    protected $schema = 'public';
    protected $tables = array();
    protected $fetchers = array();
    protected $generators = array();

    public function __construct($config) {
        echo CLI::h1('Repel adapter', HEADER_FILL);
        $this->config = $config;
    }


    public function addFetcher($fetcher) {
        $fetcher->setAdapter($this);
        
        $this->fetchers[] = $fetcher;
        echo 'Add fetcher: ';
        echo CLI::color(get_class($fetcher), dark_gray) . "\n";
        return $this;
    }
    
    public function addGenerator($generator){
        $generator->setAdapter($this);
        
        $this->generators[] = $generator;
        echo 'Add generator: ';
//        echo CLI::color( 'Add generator: ', white);
        echo CLI::color(get_class($generator), dark_gray) . "\n";
        return $this;
    }
    
    public function getTables(){
        return $this->tables;
    }

    /**
     * Fetch structure from database.
     * 
     * Can add custom fetcher by passing a fetcher instance as an argument.
     * @param Fetcher $custom_fetcher
     */
    public function fetch() {
        echo CLI::h2('Fetch', HEADER_FILL);
//        echo CLI::dotFill('fetching structure', DOT_FILL);

        foreach ($this->fetchers as $fetcher) {
            $fetcher->fetch();
        }
        $this->setRelationships();
        $this->addManyToMany();
        
        echo CLI::h2('-----', HEADER_FILL);
//        echo CLI::color("done", green) . "\n";
        return $this;
    }

    public function setManyToMany($tables_names) {
        $this->many_to_many = $tables_names;
    }

    protected function addManyToMany() {
        // @TODO to be a constructor class
        $relationship_config = $this->many_to_many;
        foreach ($relationship_config as $table_name) {
            $table = $this->getTable($table_name);
            if (!$table) {
                throw new \Exception('(ManyToMany) Defined table does not exist: ' . $table_name);
            }
            foreach ($table->columns as $column) {
                if ($column->foreign_key) {
                    $referenced_table = $this->getTable($column->foreign_key->referenced_table);
                    $referenced_table->removeRelationship($table_name);
                    $relationship = new Relationship();
                    $relationship->source = $table_name;

                    $many_refered_table = '';
                    foreach ($table->columns as $column) {
                        if ($column->foreign_key) {
                            if ($column->foreign_key->referenced_table !== $referenced_table->name) {
                                $many_refered_table = $column->foreign_key->referenced_table;
                            }
                        }
                    }

                    $relationship->table = $many_refered_table;
                    $relationship->type = 'many-to-many';
                    $referenced_table->addRelationship($relationship);
                }
            }
        }
    }

    protected function setRelationships() {
        foreach ($this->tables as $table) {
            foreach ($this->tables as $relationship_table) {
                if ($table->name !== $relationship_table->name) {
                    $reference = $relationship_table->getReferenceTo($table->name);
                    if ($reference) {
                        $relationship = new Relationship();
                        $relationship->table = $relationship_table->name;
                        $relationship->type = 'one-to-many';
                        $relationship->foreign_key = $reference['foreign_key'];
                        $table->relationships[] = $relationship;
                    }
                }
            }
        }
    }

    public function addColumn($table_name, Column $column) {
        $this->getTable($table_name)->columns[] = $column;
    }

    public function addTable($table_name, $table_type) {
        $new_table = new Table();
        $new_table->name = $table_name;
        if ($table_type === 'BASE TABLE') {
            $new_table->type = 'table';
        } elseif ($table_type === 'VIEW') {
            $new_table->type = 'view';
        } else {
            throw new Exception('(addTable) Wrong table type: ' . print_r($row, true));
        }
        $this->tables[] = $new_table;
        return $this->tables[count($this->tables) - 1];
    }

    public function getTable($table_name) {
        foreach ($this->tables as $ktable => $table) {
            if ($table->name === $table_name) {
                return $this->tables[$ktable];
            }
        }
        return false;
    }

    public function tableExists($table_name) {
        if ($this->getTable($table_name)) {
            return true;
        }
        return false;
    }

//    public function generate($table) {
//
//        $table_name = Generator\BaseGenerator::singular($table->name);
//        $table_name[0] = strtoupper($table_name[0]);
//
//        echo CLI::dotFill($table_name . ' (' . CLI::color($table->type, dark_gray) . ')', DOT_FILL + 11);
//
//        $generator = new Generator\phpGenerator();
//        $result = $generator->generate($table);
//
//        echo CLI::color("saved", green) . "\n";
//
//        return $result;
//    }

    public function generate() {
        echo CLI::h2('Generate', HEADER_FILL);

        foreach ($this->generators as $generator){
            $generator->generate();
        }
        echo CLI::h2('-----', HEADER_FILL);
    }

}
