<?php
namespace Pressmind\Travelshop;

class RouteHelper{

    /**
     * @param $id_object_type
     * @return string | false
     */
    public static function get_url_by_object_type($id_object_type, $language = 'default'){

        if(empty(TS_SEARCH_ROUTES[$id_object_type][$language]['route']) === true){
            return false;
        }

        return TS_SEARCH_ROUTES[$id_object_type][$language]['route'];
    }
}