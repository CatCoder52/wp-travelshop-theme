<?php

namespace Custom;

class InstallHelper
{

    /**
     * Search a defined constant in a php file and replace it's value
     * @param $constant
     * @param $value
     * @param $str
     * @return string
     */
    public static function setConstant($constant, $value, $str){

        if(preg_match('/^\[(\w|\s.+\n*)+\]|([0-9]+)$/', $value) == 0){
            $value = "'".$value."'";
        }

        $regex = '/(define\(\''.$constant.'\',)(\s*|.*|\n*)(\);)/';

        return preg_replace($regex, '$1 '.$value.');', $str);
    }


    /**
     * Write config-theme.php file (we have to set some pressmind related values in this file)
     * Called in cli/install.php
     * @param $theme_config
     * @return false|int
     */
    public static function writeConfig($theme_config){
        $config_file = file_get_contents('../config-theme.default.php');
        foreach($theme_config as $constant => $value){
            $value = str_replace(
                ["'TS_TOUR_PRODUCTS'", "'TS_HOTEL_PRODUCTS'", "'TS_HOLIDAYHOMES_PRODUCTS'", "'TS_DAYTRIPS_PRODUCTS'", "'TS_DESTINATIONS'"],
                ["TS_TOUR_PRODUCTS", "TS_HOTEL_PRODUCTS", "TS_HOLIDAYHOMES_PRODUCTS", "TS_DAYTRIPS_PRODUCTS", "TS_DESTINATIONS"], $value);

            $config_file = self::setConstant($constant, $value, $config_file);

        }
        if(file_put_contents('../config-theme.php', $config_file) === false){
            throw new \ErrorException('Error: can not write to ../config-theme.php ');
        }
    }

}