<?php

class php_Generator extends Generator {

    public function generate($table) {
        $foreign_keys = array();

        $table_name = $this->singular($table->name);
        $table_name[0] = strtoupper($table_name[0]);

        $result = 'class D' . $table_name . 'BaseRecord extends FActiveRecord {';
        $result.="\n";
        $result.="\n";
        $result.= '    public $TABLE = "' . $table->name . '";';
        $result.="\n";
        $result.="\n";
        foreach ($table->columns as $column) {
            $result.='    public $' . $column->name . ';';
            $result.="\n";
            if ($column->foreign_key !== null) {
                $foreign_keys[$column->name] = $column->foreign_key;
            }
        }

        $result.="\n";
        $result.="    public \$TYPES = array(\n";
        foreach ($table->columns as $column) {
            $result.='        "' . $column->name . '"=>"' . $column->type . '",';
            $result.="\n";
        }

        $result.="    );\n";
        $result.="\n";

        if (count($foreign_keys)) {
            $result .= "    // FOREIGN KEYS OBJECTS\n";
            foreach ($foreign_keys as $name => $fk) {
                $object_name = mb_convert_case(Generator::singular(substr($name, 0, strlen($name) - 3), false), MB_CASE_LOWER, 'UTF-8');
                $result .= "    private \$_{$object_name} = null;\n";
            }
        }
        $result.="\n";

        $in_many_to_many = false;
        if (count($table->relationships)) {
            $result .= "    // RELATIONSHIPS OBJECTS\n";
            foreach ($table->relationships as $relationship) {

                $result .= "    private \$_{$relationship->table} = null;\n";
                if ($relationship->type === 'one-to-many') {
//                    $object_name = mb_convert_case(Generator::singular($relationship->table, false), MB_CASE_LOWER, 'UTF-8');
//                    $result .= "    private \$_{$object_name} = null;\n";
                } else if ($relationship->type === 'many-to-many') {
                    $in_many_to_many = true;
                }
            }

            if ($in_many_to_many) {
                $result .= "    private \$_relationship = null;\n";
            }
        }
        $result.="\n";

        if (count($foreign_keys)) {
            $result .= "    // FOREIGN KEYS METHODS";
            foreach ($foreign_keys as $name => $fk) {
                $object_name = Generator::singular($fk->referenced_table);
                $active_record_name = mb_convert_case(Generator::singular($fk->referenced_table, false), MB_CASE_LOWER, 'UTF-8');

                $result .= "\n";
                $result .= "    public function get{$object_name}() {\n";
                $result .= "        if(\$this->_{$active_record_name} === null) {\n";
                $result .= "            \$this->_{$active_record_name} = D{$object_name}Record::finder()->findByPK(\$this->{$name});\n";
                $result .= "        }\n";
                $result .= "        return \$this->_{$active_record_name};\n";
                $result .= "    }\n";
            }
        }

        if (count($table->relationships)) {
            $result .= "    // RELATIONSHIPS METHODS\n";
            foreach ($table->relationships as $relationship) {
                $function_name = Generator::firstLettersToUpper($relationship->table);
                $object_name = $relationship->table;
                if ($relationship->type === 'one-to-many') {
                    $active_record_name = Generator::singular($relationship->table);
                    $foreign_key_name = Generator::firstLettersToUpper($relationship->foreign_key->referenced_column);

                    $result .= "    public function get{$function_name}() {\n";
                    $result .= "        if(\$this->_{$object_name} === null) {\n";
                    $result .= "            \$this->_{$object_name} = D{$active_record_name}Record::finder()->findBy{$foreign_key_name}(\$this->{$relationship->foreign_key->referenced_column});\n";
                    $result .= "        }\n";
                    $result .= "        return \$this->_{$object_name};\n";
                    $result .= "    }\n\n";
                } else if ($relationship->type === 'many-to-many') {
                    $active_record_name = Generator::singular($relationship->table);
                    $foreign_key_name = mb_convert_case(Generator::singular($object_name, false), MB_CASE_LOWER, 'UTF-8') . "_id";
                    $m2m_table_name = Generator::singular($relationship->source);
                    $primary_key_name = mb_convert_case(Generator::singular($table_name, false), MB_CASE_LOWER, 'UTF-8') . "_id";
                    $primary_key_name_camel = Generator::singular($primary_key_name);

                    $result .= "    public function get{$function_name}() {\n";
                    $result .= "        if(\$this->_{$object_name} === null) {\n";
                    $result .= "            \${$relationship->source} = D{$m2m_table_name}Record::finder()->findBy{$primary_key_name_camel}(\$this->{$primary_key_name});\n";
                    $result .= "            \${$relationship->table} = array();\n";
                    $result .= "            foreach(\${$relationship->source} as \${$relationship->source[0]}) {\n";
                    $result .= "                \${$relationship->table[0]} = D{$active_record_name}Record::finder()->findByPK(\${$relationship->source[0]}->{$foreign_key_name});\n";
                    $result .= "                \${$relationship->table[0]}->relationship = \${$relationship->source[0]};\n";
                    $result .= "                \${$relationship->table}[] = \${$relationship->table[0]};\n";
                    $result .= "            }\n";
                    $result .= "            \$this->_{$relationship->table} = \${$relationship->table};\n";
                    $result .= "        }\n";
                    $result .= "        return \$this->_{$object_name};\n";
                    $result .= "    }\n\n";
                }
            }

            if ($in_many_to_many) {
                $result .= "    public function getRelationship() {\n";
                $result .= "        return \$this->_relationship;\n";
                $result .= "    }\n";
            }
        }
        $result.="\n";
        $result .= "    // others\n";
        if ($table->type === 'table') {
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

}
