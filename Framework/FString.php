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

}
