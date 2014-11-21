<?php

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

interface Fetcher {

    public function fetch();
}



class Generator {

    public function singular($word) {
        // first letter to upper
        $word [0] = strtoupper($word [0]);

        // delete -ies
        if (substr($word, strlen($word) - 3) == "ies") {
            $word = substr($word, 0, strlen($word) - 3);
            $word .= "y";
        }
        // delete -s
        if ($word[strlen($word) - 1] == "s") {
            $word = substr($word, 0, strlen($word) - 1);
        }

        while (substr_count($word, "ies_")) {
            $index = strpos($word, "ies_");
            $word = self::str_replace_limit("ies_", "y", $word);
            $word[$index + 1] = strtoupper($word[$index + 1]);
        }

        while (substr_count($word, "s_")) {
            $index = strpos($word, "s_");
            $word = self::str_replace_limit("s_", "", $word);
            $word[$index] = strtoupper($word[$index]);
        }

        while (substr_count($word, "_")) {
            $index = strpos($word, "_");
            $word = self::str_replace_limit("_", "", $word);
            $word[$index] = strtoupper($word[$index]);
        }
        return $word;
    }

    public static function str_replace_limit($search, $replace, $string, $limit = 1) {
        if (is_bool($pos = (strpos($string, $search)))) {
            return $string;
        }

        $search_len = strlen($search);

        for ($i = 0; $i < $limit; $i++) {
            $string = substr_replace($string, $replace, $pos, $search_len);

            if (is_bool($pos = (strpos($string, $search)))) {
                break;
            }
        }
        return $string;
    }

    public function generate($table) {
        return $table;
    }

}

