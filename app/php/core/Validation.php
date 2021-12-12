<?php

namespace php\core;

class Validation {

    static public function empty_string (string $str): bool
    {
        $str = trim($str, "\x00..\x1F\t ");
        return empty($str);
    }
}