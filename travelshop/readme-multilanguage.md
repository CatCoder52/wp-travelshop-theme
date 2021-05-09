# Multilanguage support

## Theme compatibility
the development of the multilanguage features has its focus on the wpml plugin. So the theme uses some of there 
constants like ICL_LANGUAGE_CODE.

## Activate
See config-theme.php 

````php

define('MULTILANGUAGE_SITE', true);

// Support for WPML multilanguage, if no lang is set, we set a default:
if(!defined('ICL_LANGUAGE_CODE')){
    define('ICL_LANGUAGE_CODE', 'DE');
}

````
## Normalize pressmind sections namings

DRAFT - docu not ready at this moment :-/


