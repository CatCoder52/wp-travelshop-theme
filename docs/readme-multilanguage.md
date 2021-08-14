# Multilanguage support

## Theme compatibility
the development of the multilanguage features has its focus on the wpml plugin. So the theme uses some of there 
constants like ICL_LANGUAGE_CODE.

## Activate
See config-theme.php 

````php

define('MULTILANGUAGE_SITE', false);

if(MULTILANGUAGE_SITE === true){
    // Support for WPML multilanguage, if no lang is set, we set a default:
    if(defined('ICL_LANGUAGE_CODE')){

        /* if the language codes are different between wmpl and pressmind, you can build a map like this
        $language_map = ['de-de' => 'de', 'en-gb' => 'en'];
        define('TS_LANGUAGE_CODE', $language_map[ICL_LANGUAGE_CODE]);
        */

        define('TS_LANGUAGE_CODE', ICL_LANGUAGE_CODE);
    }else{
        define('TS_LANGUAGE_CODE', 'de');
    }
}else{
    define('TS_LANGUAGE_CODE', null);
}

````
## Normalize pressmind sections namings

DRAFT - docu not ready at this moment :-/


