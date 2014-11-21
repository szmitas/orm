<?php
class php_Generator extends Generator {

    public function generate($table) {
        $table_name = $this->singular($table->name);
        $table_name[0] = strtoupper($table_name[0]);

        $result= 'class D' . $table_name . 'Record extends FActiveRecord {';
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
        return $result;
    }

}