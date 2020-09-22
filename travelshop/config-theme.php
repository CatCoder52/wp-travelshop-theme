<?php

/**
 * the web-path to the wordpress installation, do not set wordpress function like site_url() here.
 * because of the pm-ajax-endpoint.php which is running without a WordPress Bootstrap
 */
define('SITE_URL', 'http://wordpress.local');

/**
 * we' have to renormalize the generic pressmind entities,
 * so it would be a easier handling in this shop context
 */
define('TS_TOUR_PRODUCTS', 607);
define('TS_HOTEL_PRODUCTS', null);
define('TS_DAYTRIPS_PRODUCTS', null);
define('TS_DESTINATIONS', null);

/**
 * Default visibility level
 * 30 = public
 * 10 = nobody
 * In some development cases it's required to add a other visibility than public (30)
 */
define('TS_VISIBILTY', [30]);

/**
 * define the default pressmind fields for each object type for the fulltext search
 * @todo create this by installer
 */
define('DEFAULT_SEARCH_FIELDS', [TS_TOUR_PRODUCTS => ['headline_default' => 'LIKE']]);


/**
 * see config-routing.php to set individual templates for each route
 * if null, the current theme directory is used for route templates
 */
define('TS_TEMPLATE_DIR', null);


/**
 * TTL of the Object Caching
 */
define('TS_OBJECT_CACHE_TTL', 60);

/**
 * Setup Redis,
 */

if(!defined('PM_REDIS_HOST')){
    define('PM_REDIS_HOST', '127.0.0.1');
}

if(!defined('PM_REDIS_PORT')){
    define('PM_REDIS_PORT', '6379');
}

