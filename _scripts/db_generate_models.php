#!/usr/bin/env php
<?php
require_once '../Includes/CLI.php';
        const DOT_FILL = 36;
        const HEADER_FILL = 38;

$config = require_once __DIR__ . '/../Config/database.php';

class ForeignKey {

    public $referenced_table;
    public $referenced_column;

    public function __construct($referenced_table, $referenced_column) {
        $this->referenced_table = $referenced_table;
        $this->referenced_column = $referenced_column;
    }

}

class Table {

    public $name;
    public $type;

}

class Column {

    public $name;
    public $type;
    public $is_null;
    public $is_primary_key;
    public $foreign_key;

}

class Dumper {

    protected $db;
    protected $config;
    protected $schema = 'public';
    protected $tables = array();

    public function __construct($config) {
        switch ($config['type']) {
            case 'pgsql':
                $this->config = $config;
                break;
            default:
                throw new Exception("Unknown database type. ({$config['type']})");
        }
        $this->connect();
    }

    public function connect() {
        $this->db = new PDO($this->config ['driver'], $this->config ['username'], $this->config ['password']);
    }

    public function fetch() {

        if ($this->config['type'] === 'pgsql') {
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
        }



        $rows = $this->db->query($sql);

        foreach ($rows as $row) {
            if (!$this->tableExists($row)) {
                $this->tableAdd($row);
            }
            $this->addColumn($row);
        }
    }

    protected function addColumn($row) {
        if (!isset($row) || !isset($row['table_name']) || !isset($row['column_name'])) {
            throw new Exception('(addColumn) Wrong row format: ' . print_r($row, true));
        }

        $new_column = new Column();
        $new_column->name = $row['column_name'];
        $new_column->type = $row['data_type'];
        $new_column->is_primary_key = $row['constraint_type'] === 'PRIMARY KEY' ? 1 : 0;
        $new_column->is_null = $row['is_nullable'] === 'YES' ? 1 : 0;
        if ($row['constraint_type'] === 'FOREIGN KEY') {
            $new_column->foreign_key = new ForeignKey($row['referenced_table'], $row['referenced_column']);
        }
        $this->getTable($row['table_name'])->columns[] = $new_column;
    }

    protected function tableAdd($row) {
        if (!isset($row) || !isset($row['table_name']) || !isset($row['table_type'])) {
            throw new Exception('(tableAdd) Wrong row format: ' . print_r($row, true));
        }
        $table_name = $row['table_name'];
        $table_type = $row['table_type'];
        $new_table = new Table();
        $new_table->name = $table_name;
        if ($table_type === 'BASE TABLE') {
            $new_table->type = 'table';
        } elseif ($table_type === 'VIEW') {
            $new_table->type = 'view';
        } else {
            throw new Exception('(tableAdd) Wrong table type: ' . print_r($row, true));
        }

        $this->tables[] = $new_table;
        return $this->tables[count($this->tables)];
    }

    protected function getTable($table_name) {
        foreach ($this->tables as $ktable => $table) {
            if ($table->name === $table_name) {
                return $this->tables[$ktable];
            }
        }
        return false;
    }

    protected function tableExists($row) {
        if (!isset($row) || !isset($row['table_name'])) {
            throw new Exception('(tableExists) Wrong row format: ' . print_r($row, true));
        }
        $table_name = $row['table_name'];
        if ($this->getTable($table_name)) {
            return true;
        }
        return false;
    }

    public function singular($word) {
        // Twoja copy pasta mi nie banglała, nie chce misie tego robic teraz :P
        return $word;
    }

    public function parseTable($table) {

//        class D_MediaRecord extends FActiveRecord {
//	const TABLE = "media";
//
//	public $media_id;
//	public $type;
//	public $path;
//	public $description;
//	public $description_alt;
//	public $deleted = 0;
//
//	const TYPES = array(
//		"media_id" => "int",
//		"type" => "string",
//		"path" => "string",
//		"description" => "string",
//		"description_alt" => "string",
//		"deleted" => "int",
//	);
//
//	public function delete() {
//		$this->deleted = time();
//		$this->save();
//	}
//}

        $base_class = 'FActiveRecord';

        $result = '';

        $table_name = $this->singular($table->name);
        $table_name[0] = strtoupper($table_name[0]);

        echo CLI::dotFill($table_name . ' (' . CLI::color($table->type, dark_gray) . ')', DOT_FILL +11);

        $result.= 'class D' . $table_name . 'Record extends ' . $base_class . ' {';
        $result.="\n";
        $result.="\n";
        $result.= '    const TABLE = "' . $table->name . '";';
        $result.="\n";
        $result.="\n";
        foreach ($table->columns as $column) {
            $result.='    public $' . $column->name . ';';
            $result.="\n";
        }
        $result.="\n";
        $result.="    const TYPES = array(\n";
        foreach ($table->columns as $column) {
            $result.='        "' . $column->name . '"=>"' . $column->type . '",';
            $result.="\n";
        }
        $result.="    );\n";
        $result.="\n";
        if ($table->type==='table'){
        $result.="\n";
        $result.="    public function delete() {\n";
	$result.="        \$this->deleted = time();\n";
	$result.="        \$this->save();\n";
	$result.="    }\n";
        } else {
        $result.="\n";
        $result.="    public function delete() {\n";
	$result.="        throw new Exception('Cannot delete a view record.');\n";
	$result.="    }\n";    
        }
        $result.="}\n";
        echo CLI::color("saved", green);
        echo "\n";
        return $result;
    }

    public function save() {
        $file = 'maciej.php';

        $file_handle = fopen($file, 'w');
        fwrite($file_handle, "<?php\n");
        fwrite($file_handle, "class _BaseActiveRecords {};\n\n");
        foreach ($this->tables as $table) {
            fwrite($file_handle, $this->parseTable($table));
        }
        fclose($file_handle);
    }

}

try {
    echo CLI::h1('generate models from db', HEADER_FILL);
    // Connecting
    echo CLI::dotFill('connecting', DOT_FILL);
    $dumper = new Dumper($config);
    echo CLI::color("done", green);
    echo "\n";
    echo CLI::dotFill('fetching structure', DOT_FILL);
    $dumper->fetch();
    echo CLI::color("done", green);
    echo "\n";
    echo CLI::h1('saving models', HEADER_FILL);
    $dumper->save();
    echo "\n";
    echo CLI::color("SUCCESS", 'white', 'green');
    echo "\n";
    echo "\n";
} catch (Exception $ex) {
    echo CLI::color("failed", red);
    echo "\n";
    echo "\n";
    echo CLI::color($ex->getMessage(), 'white', 'red');
    echo "\n";
    echo "\n";
    die();
}

