<?php

namespace Pressmind\Travelshop;

class Template
{
    /**
     * @param string $file
     * @param array $args
     */
    public static function render($file, $args){
        ob_start();
        require $file;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}