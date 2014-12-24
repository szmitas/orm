<?php

namespace Repel\Adapter\Generator;

class BaseGenerator {

    public static function singular($word, $delete_underscores = true) {
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
            if (!$delete_underscores) {
                $word = self::str_replace_limit("ies", "y", $word);
            } else {
                $word = self::str_replace_limit("ies_", "y", $word);
                $word[$index + 1] = strtoupper($word[$index + 1]);
            }
        }

        while (substr_count($word, "s_")) {
            $index = strpos($word, "s_");
            if (!$delete_underscores) {
                $word = self::str_replace_limit("s", "", $word);
            } else {
                $word = self::str_replace_limit("s_", "", $word);
                $word[$index] = strtoupper($word[$index]);
            }
        }

        if ($delete_underscores) {
            while (substr_count($word, "_")) {
                $index = strpos($word, "_");
                $word = self::str_replace_limit("_", "", $word);
                $word[$index] = strtoupper($word[$index]);
            }
        }
        return $word;
    }

    public static function firstLettersToUpper($word) {
        return str_replace("_", "", mb_convert_case($word, MB_CASE_TITLE, 'UTF-8'));
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

    public function generateTable($table) {
        return $table;
    }

    public static function tableToPK($name) {
        // delete -ies
        if (substr($name, strlen($name) - 3) == "ies") {
            $name = substr($name, 0, strlen($name) - 3);
            $name .= "y";
        }
        // delete -s
        if ($name[strlen($name) - 1] == "s") {
            $name = substr($name, 0, strlen($name) - 1);
        }

        while (substr_count($name, "ies_")) {
            $index = strpos($name, "ies_");
            $name = FString::replace_limit("ies_", "y_", $name);
        }

        while (substr_count($name, "s_")) {
            $index = strpos($name, "s_");
            $name = FString::replace_limit("s_", "_", $name);
        }

        return mb_convert_case($name . "_id", MB_CASE_LOWER, 'UTF-8');
    }

}
