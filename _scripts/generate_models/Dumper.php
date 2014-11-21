<?php

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
/**
 * Fetch structure from database.
 * 
 * Can add custom fetcher by passing a fetcher instance as an argument.
 * @param Fetcher $custom_fetcher
 */
    public function fetch($custom_fetcher = null) {

        if ($custom_fetcher instanceof Fetcher) {
            $fetcher = $custom_fetcher;
        } else {
            // Automatic fetcher recognition
            if ($this->config['type'] === 'pgsql') {
                $fetcher = new PostgreSQL_Fetcher($this->db, $this->config['public_schema']);
            }
        }
        $rows = $fetcher->fetch();

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
        return $this->tables[count($this->tables) - 1];
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

    public function generate($table) {

        $table_name = Generator::singular($table->name);
        $table_name[0] = strtoupper($table_name[0]);

        echo CLI::dotFill($table_name . ' (' . CLI::color($table->type, dark_gray) . ')', DOT_FILL + 11);

        $generator = new php_Generator();
        $result = $generator->generate($table);

        echo CLI::color("saved", green) . "\n";

        return $result;
    }

    public function save() {
        $file = $this->config['model_file_path'];

        $file_handle = fopen($file, 'w');
        fwrite($file_handle, "<?php\n");
        fwrite($file_handle, "class _BaseActiveRecords {};\n\n");
        foreach ($this->tables as $table) {
            fwrite($file_handle, $this->generate($table));
        }
        fclose($file_handle);
    }

}
