<?php

class FString {

    public static function replace_limit($search, $replace, $string, $limit = 1) {
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

    public static function camelize_name($name) {
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

        return $name;
    }

}
