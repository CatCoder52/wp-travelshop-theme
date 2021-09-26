<?php

namespace Pressmind\Travelshop;

class Template
{
    /**
     * @param string $file
     * @param array $args
     */
    public static function load($file, $args){
        require $file;
    }
}