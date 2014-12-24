<?php

namespace Repel\Adapter\Generator;

use Repel\Adapter\Generator\BaseGenerator;
use Repel\Includes\CLI;

const DOT_FILL = 36;
const HEADER_FILL = 38;

class RepelGenerator extends BaseGenerator {

    private $table_name = "";
    private $foreign_keys = array();
    protected $adapter = null;
    private $cross_reference = false;

    public function __construct($model_path = null) {
        if ($model_path) {
            if ($model_path[strlen($model_path) - 1] !== '/') {
                $model_path .= '/';
            }
            $this->model_path = $model_path;
        } else {
            $this->model_path = __DIR__ . '/data/';
        }
        $this->base_path = $this->model_path . 'Base/';
    }

    public function setAdapter($adapter) {
        if (get_class($adapter) === 'Repel\Adapter\Adapter') {
            $this->adapter = $adapter;
        } else {
            throw new \Exception('[RepelGenerator] wrong adapter instance given.');
        }
    }

    public static function getTableName($name) {
        return 'D' . self::singular($name);
    }

    public static function getTableBaseName($name) {
        return 'R' . self::singular($name) . 'Base';
    }

    public static function getQueryName($name) {
        return 'D' . self::singular($name) . 'Query';
    }

    public static function getQueryBaseName($name) {
        return 'R' . self::singular($name) . 'QueryBase';
    }

    public function generate() {


        if (!is_dir($this->model_path)) {
            throw new \Exception("[RepelGenerator] Given model path does not exist, or is not a directory! ({$this->model_path})");
        }
        if (!is_dir($this->base_path)) {
            mkdir($this->base_path);
        } else {
            // Check if proper directory 
            $dh = opendir($this->base_path);
            $ignore = array('.', '..');
            $warning = false;
            while (false !== ($filename = readdir($dh))) {
                if (in_array($filename, $ignore)) {
                    continue;
                }
                if (preg_match('/^R.*Base.php$/', $filename)) {
                    unlink($this->base_path . $filename);
                } else {
                    $warning = true;
                }
            }
        }

//        file_put_contents($this->base_path . $filename . '.php', $this->generateBaseActiveRecord($table));

        if ($warning) {
            echo CLI::warning("Warning! Irrelevant files found in base_path!");
        }
        foreach ($this->adapter->getTables() as $table) {
            echo CLI::dotFill($table->name . ' (' . CLI::color($table->type, dark_gray) . ')', DOT_FILL + 11);

            $this->clear();

            $table_filename = self::getTableName($table->name);
            $query_filename = self::getQueryName($table->name);
            $table_base_filename = self::getTableBaseName($table->name);
            $query_base_filename = self::getQueryBaseName($table->name);

            if (!file_exists($this->model_path . $table_filename . '.php')) {
                file_put_contents($this->model_path . $table_filename . '.php', $this->generateTable($table));
            }
            if (!file_exists($this->model_path . $query_filename . '.php')) {
                file_put_contents($this->model_path . $query_filename . '.php', $this->generateTableQuery($table));
            }

            file_put_contents($this->base_path . $table_base_filename . '.php', $this->generateTableBase($table));
            file_put_contents($this->base_path . $query_base_filename . '.php', $this->generateTableQueryBase($table));

            echo CLI::color("done", green) . "\n";
        }
    }

    public function clear() {
        $this->foreign_keys = array();
        $this->table_name = "";
        $this->cross_reference = false;
    }

//    public function generateBaseActiveRecord() {
//        $result = '';
//        $result .= "<?php\n";
//        $result .= "class _BaseActiveRecord {};\n\n";
//        return $result;
//    }

    public function generateTable($table) {
        $result = "<?php" . "\n";
        $result .= "namespace data;";
        $result .= "\n";
        $result .= "use data\Base;";

        $result .= "\n\nclass " . self::getTableName($table->name) . " extends Base\\" . self::getTableBaseName($table->name) . " {";
        $result .= "\n\n}\n\n";
        return $result;
    }

    public function generateTableQuery($table) {
        $result = "<?php" . "\n";
        $result .= "namespace data;";
        $result .= "\n";
        $result .= "use data\Base;";
        $result .= "\n\nclass " . self::getQueryName($table->name) . " extends Base\\" . self::getQueryBaseName($table->name) . " {";
        $result .= "\n\n}\n\n";
        return $result;
    }

    public function generateTableBase($table) {
        $table_name = BaseGenerator::singular($table->name);
        $this->table_name = $table_name;
        $result = "<?php" . "\n\n";
        $result .= "namespace data\Base;\n";
        $result .= "\n";
        $result .= "use Repel\Framework\RActiveRecord;\n\n";
        $result .= "class " . self::getTableBaseName($table->name) . " extends RActiveRecord {\n\n";
        $result.= "\tpublic \$TABLE = \"{$table->name}\";\n\n";

        $result .= $this->generateColumnTypesArray($table->columns);
        $result.="\n\n";

        $result .= $this->generateAutoIncrementArray($table->columns);
        $result.="\n\n";

        $result .= $this->generateDefaultArray($table->columns);
        $result.="\n\n";

        $result .= $this->generateObjectProperties($table->columns);
        $result.="\n";

        if (count($this->foreign_keys)) {
            $result .= $this->generateForeignKeyObjects();
            $result.="\n";
        }

        if (count($table->relationships)) {
            $result .= $this->generateRelationshipObjects($table->relationships);

            if ($this->cross_reference) {
                $result .= "\t// relationship object\n";
                $result .= "\tprivate \$_relationship = null;\n";
            }
            $result.="\n";
        }

        if (count($this->foreign_keys)) {
            $result .= $this->generateForeignKeyMethods();
        }

        if (count($table->relationships)) {
            $result .= $this->generateRelationshipMethods($table->relationships);

            if ($this->cross_reference) {
                $result .= "\tpublic function setRelationship(\$relationship) {\n";
                $result .= "\t\treturn \$this->_relationship = \$relationship;\n";
                $result .= "\t}\n";
                $result .= "\n";
                $result .= "\tpublic function getRelationship() {\n";
                $result .= "\t\treturn \$this->_relationship;\n";
                $result .= "\t}\n";
            }
        }

        $result.="}\n\n";


        return $result;
    }

    public function generateTableQueryBase($table) {
        $query = "<?php" . "\n\n";
        $query .= "namespace data\Base;\n";
        $query .= "\n";
        $query .= "use Repel\Framework\RActiveQuery;\n\n";
        $table_name = BaseGenerator::singular($table->name);
        $this->table_name = $table_name;

        $query .= "class " . self::getQueryBaseName($table->name) . " extends RActiveQuery {\n\n";

        foreach ($table->columns as $column) {
            $query .= $this->generateFindByFunction($column);
        }

        foreach ($table->columns as $column) {
            $query .= $this->generateFindOneByFunction($column);
        }

        foreach ($table->columns as $column) {
            $query .= $this->generateFilterByFunction($column);
        }

        $query .= "\t// others\n";
        foreach ($table->columns as $column) {
            if ($column->name === "deleted") {
                $query .= $this->generateDeleteFunction($table->type);
                break;
            }
        }
        $query.= "}\n";
        return $query;
    }

    public function generateObjectProperties($columns) {
        $result = "\t// properties\n";
        foreach ($columns as $column) {
            $result.="\tpublic \${$column->name};\n";
            if ($column->foreign_key !== null) {
                $this->foreign_keys[$column->name] = $column->foreign_key;
            }
        }
        return $result;
    }

    public function generateColumnTypesArray($columns) {
        $result = "\tpublic \$TYPES = array(\n";
        foreach ($columns as $column) {
            $result .= "\t\t\"{$column->name}\" => \"{$column->type}\",\n";
        }
        $result .= "\t);";
        return $result;
    }

    public function generateAutoIncrementArray($columns) {
        $result = "\tpublic \$AUTO_INCREMENT = array(\n";
        foreach ($columns as $column) {
            if (substr($column->default, 0, 7) === "nextval") {
                $result .= "\t\t\"{$column->name}\",\n";
            }
        }
        $result .= "\t);";
        return $result;
    }

    public function generateDefaultArray($columns) {
        $result = "\tpublic \$DEFAULT = array(\n";
        foreach ($columns as $column) {
            if ($column->default !== null) {
                $result .= "\t\t\"{$column->name}\",\n";
            }
        }
        $result .= "\t);";
        return $result;
    }

    public function generateForeignKeyObjects() {
        $result = "\t// foreign key objects\n";
        foreach ($this->foreign_keys as $name => $fk) {
            $object_name = mb_convert_case(BaseGenerator::singular(substr($name, 0, strlen($name) - 3), false), MB_CASE_LOWER, 'UTF-8');
            $result .= "\tprivate \$_{$object_name} = null;\n";
        }
        return $result;
    }

    public function generateRelationshipObjects($relationships) {
        $result = "\t// relationships objects\n";
        foreach ($relationships as $relationship) {
            $result .= "\tprivate \$_{$relationship->table} = null;\n";
            if ($relationship->type === 'one-to-many') {
                // nothing special
            } else if ($relationship->type === 'many-to-many') {
                $this->cross_reference = true;
            }
        }
        return $result;
    }

    public function generateForeignKeyMethods() {
        $result = "\t// foreign key methods\n";
        foreach ($this->foreign_keys as $name => $fk) {
            $class_name = BaseGenerator::singular($fk->referenced_table);
            if (substr($name, strlen($name) - 3) === "_id") {
                $key = substr($name, 0, strlen($name) - 3);
            } else {
                $key = $name;
            }
            $function_name = BaseGenerator::singular($key, true);
            $object_name = mb_convert_case(BaseGenerator::singular($key, false), MB_CASE_LOWER, 'UTF-8');

            $result .= "\tpublic function get{$function_name}() {\n";
            $result .= "\tif(\$this->_{$object_name} === null) {\n";
            $result .= "\t\t\$this->_{$object_name} = D{$class_name}::finder()->findByPK(\$this->{$name});\n";
            $result .= "\t}\n";
            $result .= "\treturn \$this->_{$object_name};\n";
            $result .= "\t}\n";
        }
        return $result;
    }

    public function generateRelationshipMethods($relationships) {
        $result = "\t// relationship methods\n";
        foreach ($relationships as $relationship) {
            $function_name = BaseGenerator::firstLettersToUpper($relationship->table);
            $active_record_name = BaseGenerator::singular($relationship->table);
            $object_name = $relationship->table;
            if ($relationship->type === 'one-to-many') {
                $foreign_key_name = BaseGenerator::firstLettersToUpper($relationship->foreign_key->referenced_column);

                $result .= "\tpublic function get{$function_name}() {\n";
                $result .= "\t\tif(\$this->_{$object_name} === null) {\n";
                $result .= "\t\t\t\$this->_{$object_name} = D{$active_record_name}::finder()->findBy{$foreign_key_name}(\$this->{$relationship->foreign_key->referenced_column});\n";
                $result .= "\t\t}\n";
                $result .= "\t\treturn \$this->_{$object_name};\n";
                $result .= "\t\t}\n\n";
            } else if ($relationship->type === 'many-to-many') {
                $foreign_key_name = mb_convert_case(BaseGenerator::singular($object_name), MB_CASE_LOWER, 'UTF-8') . "_id";
                $m2m_table_name = BaseGenerator::singular($relationship->source);
                $primary_key_name = mb_convert_case(BaseGenerator::singular($this->table_name, false), MB_CASE_LOWER, 'UTF-8') . "_id";
                $primary_key_name_camel = BaseGenerator::singular($primary_key_name);

                $result .= "\tpublic function get{$function_name}() {\n";
                $result .= "\t\tif(\$this->_{$object_name} === null) {\n";
                $result .= "\t\t\t\${$relationship->source} = D{$m2m_table_name}::finder()->findBy{$primary_key_name_camel}(\$this->{$primary_key_name});\n";
                $result .= "\t\t\t\${$relationship->table}_pks = array();\n";
                $result .= "\t\t\tforeach(\${$relationship->source} as \${$relationship->source[0]}) {\n";
                $result .= "\t\t\t\t\${$relationship->table}_pks[] = \${$relationship->source[0]}->{$foreign_key_name};\n";
                $result .= "\t\t\t}\n";
                $result .= "\t\t\t\$this->_{$relationship->table} = D{$active_record_name}::finder()->findByPKs(\${$relationship->table}_pks);\n";
                $result .= "\t\t\tforeach(\$this->_{$relationship->table} as \${$relationship->table[0]}) {\n";
                $result .= "\t\t\t\tforeach(\${$relationship->source} as \${$relationship->source[0]}) {\n";
                $result .= "\t\t\t\t\tif(\${$relationship->table[0]}->{$foreign_key_name} === \${$relationship->source[0]}->{$foreign_key_name}) {\n";
                $result .= "\t\t\t\t\t\t\${$relationship->table[0]}->setRelationship(\${$relationship->source[0]});\n";
                $result .= "\t\t\t\t\t\tunset(\${$relationship->source[0]});\n";
                $result .= "\t\t\t\t\t\tbreak;\n";
                $result .= "\t\t\t\t\t}\n";
                $result .= "\t\t\t\t}\n";
                $result .= "\t\t\t}\n";
                $result .= "\t\t}\n";
                $result .= "\t\treturn \$this->_{$object_name};\n";
                $result .= "\t}\n\n";
            }
        }
        return $result;
    }

    public function generateFindByFunction($column) {
        $function_name = BaseGenerator::firstLettersToUpper($column->name);

        $result = "\tpublic function findBy{$function_name}(\${$column->name}) {\n";
        $result .= "\t\treturn self::findByColumn(\"{$column->name}\", \${$column->name});\n";
        $result .= "\t}\n\n";

        return $result;
    }

    public function generateFindOneByFunction($column) {
        $function_name = BaseGenerator::firstLettersToUpper($column->name);

        $result = "\tpublic function findOneBy{$function_name}(\${$column->name}) {\n";
        $result .= "\t\treturn self::findOneByColumn(\"{$column->name}\", \${$column->name});\n";
        $result .= "\t}\n\n";
        return $result;
    }

    public function generateFilterByFunction($column) {
        $function_name = BaseGenerator::firstLettersToUpper($column->name);

        $result = "\tpublic function filterBy{$function_name}(\${$column->name}) {\n";
        $result .= "\t\treturn self::filterByColumn(\"{$column->name}\", \${$column->name});\n";
        $result .= "\t}\n\n";

        return $result;
    }

    public function generateDeleteFunction($type) {
        $result = "";
        if ($type === 'table') {
            $result .= "\tpublic function delete() {\n";
            $result .= "\t\t\$this->deleted = time();\n";
            $result .= "\t\t\$this->save();\n";
            $result .= "\t}\n";
        } else {
            $result .= "\n";
            $result .= "\tpublic function delete() {\n";
            $result .= "\t\tthrow new Exception('Cannot delete a view record.');\n";
            $result .= "\t}\n";
        }

        return $result;
    }

}
