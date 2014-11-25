<?php

class php_Generator extends Generator {

    private $table_name = "";
    private $foreign_keys = array();
    private $cross_reference = false;

    public function generate($table) {
        $table_name = $this->singular($table->name);
        $table_name[0] = strtoupper($table_name[0]);
        $this->table_name = $table_name;

        $result = "class D{$table_name}BaseRecord extends FActiveRecord {\n\n";
        $result.= "\tpublic \$TABLE = \"{$table->name}\";\n\n";

        $result .= $this->generateObjectProperties($table->columns);
        $result.="\n";

        $result .= $this->generateColumnTypesArray($table->columns);
        $result.="\n";

        if (count($this->foreign_keys)) {
            $result .= $this->generateForeignKeyObjects();
        }
        $result.="\n";

        if (count($table->relationships)) {
            $result .= $this->generateRelationshipObjects($table->relationships);

            if ($this->cross_reference) {
                $result .= "\t// relationship object\n";
                $result .= "\tprivate \$_relationship = null;\n";
            }
        }
        $result.="\n";

        if (count($this->foreign_keys)) {
            $result .= $this->generateForeignKeyMethods();
        }

        if (count($table->relationships)) {
            $result .= $this->generateRelationshipMethods($table->relationships);

            if ($this->cross_reference) {
                $result .= "\tpublic function getRelationship() {\n";
                $result .= "\t\treturn \$this->_relationship;\n";
                $result .= "\t}\n";
            }
        }
        $result .= "\n";
        $result .= "\t// finders and filters\n";

        foreach ($table->columns as $column) {
            $result .= $this->generateFindByFunction($column);
        }

        foreach ($table->columns as $column) {
            $result .= $this->generateFilterByFunction($column);
        }

        $result .= "\t// others\n";
        foreach ($table->columns as $column) {
            if ($column->name === "deleted") {
                $result .= $this->generateDeleteFunction($table->type);
                break;
            }
        }
        $result.="}\n";

        // @todo ogarnąć
        $result .= "\n\nclass D{$table_name}Record extends D{$table_name}BaseRecord {";
        $result .= "\n\n\tpublic static function finder() {";
        $result .= "\n\t\treturn new self ();";
        $result .= "\n\t}";
        $result .= "\n\n\tpublic function save() {";
        $result .= "\n\t\treturn parent::save();";
        $result .= "\n\t}";
        $result .= "\n\n}\n\n";

        return $result;
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

    public function generateForeignKeyObjects() {
        $result = "\t// foreign key objects\n";
        foreach ($this->foreign_keys as $name => $fk) {
            $object_name = mb_convert_case(Generator::singular(substr($name, 0, strlen($name) - 3), false), MB_CASE_LOWER, 'UTF-8');
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
        $result = "\t// foreign key methods";
        foreach ($this->foreign_keys as $name => $fk) {
            $object_name = Generator::singular($fk->referenced_table);
            $class_name = mb_convert_case(Generator::singular($fk->referenced_table, false), MB_CASE_LOWER, 'UTF-8');

            $result .= "\tpublic function get{$object_name}() {\n";
            $result .= "\t\tif(\$this->_{$class_name} === null) {\n";
            $result .= "\t\t\t\$this->_{$class_name} = D{$object_name}Record::finder()->findByPK(\$this->{$name});\n";
            $result .= "\t\t}\n";
            $result .= "\t\treturn \$this->_{$class_name};\n";
            $result .= "\t}\n";
        }
    }

    public function generateRelationshipMethods($relationships) {
        $result = "\t// relationship methods\n";
        foreach ($relationships as $relationship) {
            $function_name = Generator::firstLettersToUpper($relationship->table);
            $object_name = $relationship->table;
            $active_record_name = Generator::singular($relationship->table);
            if ($relationship->type === 'one-to-many') {
                $foreign_key_name = Generator::firstLettersToUpper($relationship->foreign_key->referenced_column);

                $result .= "\tpublic function get{$function_name}() {\n";
                $result .= "\t\tif(\$this->_{$object_name} === null) {\n";
                $result .= "\t\t\t\$this->_{$object_name} = D{$active_record_name}Record::finder()->findBy{$foreign_key_name}(\$this->{$relationship->foreign_key->referenced_column});\n";
                $result .= "\t\t}\n";
                $result .= "\t\treturn \$this->_{$object_name};\n";
                $result .= "\t\t}\n\n";
            } else if ($relationship->type === 'many-to-many') {
                $foreign_key_name = mb_convert_case(Generator::singular($object_name, false), MB_CASE_LOWER, 'UTF-8') . "_id";
                $m2m_table_name = Generator::singular($relationship->source);
                $primary_key_name = mb_convert_case(Generator::singular($this->table_name, false), MB_CASE_LOWER, 'UTF-8') . "_id";
                $primary_key_name_camel = Generator::singular($primary_key_name);

                $result .= "\tpublic function get{$function_name}() {\n";
                $result .= "\t\tif(\$this->_{$object_name} === null) {\n";
                $result .= "\t\t\t\${$relationship->source} = D{$m2m_table_name}Record::finder()->findBy{$primary_key_name_camel}(\$this->{$primary_key_name});\n";
                $result .= "\t\t\t\${$relationship->table}_pks = array();\n";
                $result .= "\t\t\tforeach(\${$relationship->source} as \${$relationship->source[0]}) {\n";
                $result .= "\t\t\t\t\${$relationship->table}_pks[] = \${$relationship->source[0]}->{$foreign_key_name};\n";
                $result .= "\t\t\t}\n";
                $result .= "\t\t\$this->_{$relationship->table} = D{$active_record_name}Record::finder()->findByPKs(implode(',',\${$relationship->table}_pks));\n";
                $result .= "\t\t}\n";
                $result .= "\t\treturn \$this->_{$object_name};\n";
                $result .= "\t}\n\n";
            }
        }
        return $result;
    }

    public function generateFindByFunction($column) {
        $function_name = Generator::firstLettersToUpper($column->name);
        $active_record_name = Generator::singular($this->table_name);

        $result = "\tpublic function findBy{$function_name}(\${$column->name}) {\n";
        $result .= "\t\treturn D{$active_record_name}Record::finder()->find(\"{$column->name} = :{$column->name}\", array(\":{$column->name}\" => \${$column->name}));\n";
        $result .= "\t}\n\n";

        if (substr($column->name, strlen($column->name) - 3) === "_id") {
            $result .= "\tpublic function findBy{$function_name}s(array \$ids) {\n";
            $result .= "\t}\n\n";
        }
        return $result;
    }

    public function generateFilterByFunction($column) {
        $function_name = Generator::firstLettersToUpper($column->name);
        $result = "\tpublic function filterBy{$function_name}(\${$column->name}) {\n";
        $result .= "\t}\n\n";

        if (substr($column->name, strlen($column->name) - 3) === "_id") {
            $result .= "\tpublic function filterBy{$function_name}s(array \$ids) {\n";
            $result .= "\t}\n\n";
        }
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
            $result .= "'\tpublic function delete() {\n";
            $result .= "\t\tthrow new Exception('Cannot delete a view record.');\n";
            $result .= "\t}\n";
        }

        return $result;
    }

}
