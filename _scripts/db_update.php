<?php

//path to *.sql file
$schema_file = dirname(__DIR__) . "../_sql/schema.sql";
$data_directory = "../data/";

$schema = file_get_contents($schema_file);

echo "Schema load... done.\n";

preg_match_all("/CREATE[ ]+TABLE [\w\r\n `.()=,]*;/", $schema, $tables, PREG_PATTERN_ORDER);
$tables = $tables [0];

echo count($tables) . " tables found.\n";

foreach ($tables as $table) {
    $class = array();

    // get table name
    $table_name = substr($table, strpos($table, ' `') + 2, strpos($table, '(') - strpos($table, ' `') - 4);
    $class["table_name"] = $table_name;

    //echo "Preparing " . $table_name . " table.\n";
    // first letter to upper
    $table_name [0] = strtoupper($table_name [0]);

    // delete -ies
    if (substr($table_name, strlen($table_name) - 3) == "ies") {
        $table_name = substr($table_name, 0, strlen($table_name) - 3);
        $table_name .= "y";
    }
    // delete -s
    if ($table_name[strlen($table_name) - 1] == "s") {
        $table_name = substr($table_name, 0, strlen($table_name) - 1);
    }

    while (substr_count($table_name, "ies_")) {
        $index = strpos($table_name, "ies_");
        $table_name = str_replace_limit("ies_", "y", $table_name);
        $table_name[$index + 1] = strtoupper($table_name[$index + 1]);
    }

    while (substr_count($table_name, "s_")) {
        $index = strpos($table_name, "s_");
        $table_name = str_replace_limit("s_", "", $table_name);
        $table_name[$index] = strtoupper($table_name[$index]);
    }

    while (substr_count($table_name, "_")) {
        $index = strpos($table_name, "_");
        $table_name = str_replace_limit("_", "", $table_name);
        $table_name[$index] = strtoupper($table_name[$index]);
    }

    //echo $table_name . "\n";

    $class["name"] = "D_" . $table_name . "BaseRecord";

    if (substr($table_name, strlen($table_name) - 4) !== "View") {
        preg_match_all('/`[\w]+`\s(([\w]+\(\d\)|[\w]+)+\s+)+,/', $table, $columns, PREG_PATTERN_ORDER);
    } else {
        preg_match_all('/`[\w]+` [\w]+[,)]/', $table, $columns, PREG_PATTERN_ORDER);
    }
    $columns = $columns [0];

    //get properites (columns)
    $properties = array();
    //get functions i.e. deleted
    $functions = array();
    //get types i.e. int
    $types = array();
    foreach ($columns as $column) {
        $property_name = substr($column, 1, strpos($column, '`', 1) - 1);
        $property = "public $" . $property_name;

        if (preg_match("/DEFAULT (\")*(\w)+(\")*/", $column, $match)) {
            $match = substr($match[0], 8);
            $property .= " = " . $match;
        }
        $property .= ";";

        $properties[] = $property;

        if (preg_match("/` (\w)+/", $column)) {
            $type = substr($column, strpos($column, "` ") + 2);
            $type = substr($type, 0, strpos($type, " "));
        }

        switch ($type) {
            case "INT":
                $types[$property_name] = "int";
                break;
            case "TEXT":
                $types[$property_name] = "string";
                break;
            case "TIMESTAMP":
                $types[$property_name] = "string";
                break;
            default:
                $types[$property_name] = "string";
                break;
        }

        if ($property_name == "deleted") {
            $functions[] = "public function delete() {\n"
                    . "\t\t\$this->deleted = time();\n"
                    . "\t\treturn \$this->save();\n"
                    . "\t}";
        }
    }
    $class["properties"] = $properties;
    $class["types"] = $types;
    $class["functions"] = $functions;

    $classes [] = $class;
}

$classes_string = "<?php\n\nclass _BaseActiveRecords {}\n\n";

foreach ($classes as $class) {
    echo $class['table_name'] . "...";
    $classes_string .= "class " . $class['name'] . " extends FActiveRecord {\n";
    $classes_string .= "\tpublic \$TABLE = \"" . $class['table_name'] . "\";\n\n";
    foreach ($class['properties'] as $property) {
        $classes_string .= "\t" . $property . "\n";
    }
    $classes_string .= "\n\tpublic \$TYPES = array(\n";
    foreach ($class['types'] as $property => $type) {
        $classes_string .= "\t\t\"" . $property . "\" => \"" . $type . "\",\n";
    }
    $classes_string .= "\t);\n\n";
    foreach ($class['functions'] as $function) {
        $classes_string .= "\t" . $function . "\n";
    }
    $classes_string .= "}\n\n";

    if (!file_exists($data_directory . str_replace("Base", "", str_replace("_", "", $class['name'])) . ".php")) {
        $record_string = "<?php\n\nrequire_once \"_BaseActiveRecords.php\";";
        $record_string .= "\n\nclass " . str_replace("Base", "", str_replace("_", "", $class['name'])) . " extends " . $class['name'] . " {";
        $record_string .= "\n\n\tpublic static function finder() {";
        $record_string .= "\n\t\treturn new self ();";
        $record_string .= "\n\t}";
        $record_string .= "\n\n\tpublic function save() {";
        $record_string .= "\n\t\treturn parent::save();";
        $record_string .= "\n\t}";
        $record_string .= "\n\n}";

        file_put_contents($data_directory . str_replace("Base", "", str_replace("_", "", $class['name'])) . ".php", $record_string);

        echo " done.\n";
    } else {
        echo " skipped.\n";
    }
}
echo "_BaseActiveRecords... ";
file_put_contents($data_directory . "_BaseActiveRecords.php", $classes_string);
echo " done.\n";

function str_replace_limit($search, $replace, $string, $limit = 1) {
    if (is_bool($pos = (strpos($string, $search))))
        return $string;

    $search_len = strlen($search);

    for ($i = 0; $i < $limit; $i++) {
        $string = substr_replace($string, $replace, $pos, $search_len);

        if (is_bool($pos = (strpos($string, $search))))
            break;
    }
    return $string;
}
