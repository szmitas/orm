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
            $result .= "    // ONE-TO-ONE RELATIONSHIPS";
            foreach ($foreign_keys as $name => $fk) {
                $object_name = Generator::singular($fk->referenced_table);

                $result .= "\n";
                $result .= "    public function get{$object_name}() {\n";
                $result .= "        return D{$object_name}Record::finder()->findByPK(\$this->{$name});\n";
                $result .= "    }\n";
            }
        }

        if ($table->type === 'table') {
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
