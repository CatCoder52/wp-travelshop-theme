<?php

/**
 * How does this routing work:
 * 1. a route delivers a custom template from the theme directory (like WP's single.php)
 * 2. a route can trigger a custom hook, this is useful to setup customs headers, or deliver the requested site
 * from the content from pressmind's web-core sdk, sample above
 */

use Pressmind\Config;
use Pressmind\ORM\Object\MediaObject;
use Pressmind\Travelshop\Route;
use Pressmind\Travelshop\WPFunctions;

/**
 * Routing
 * Generating the routes dynamically based on the pressmind web-core pretty_url config, see config.json
 * In real world you should check if all routes are required by your project
 *
 *  @var $config (previosly defined in vendor/pressmind/lib/bootstrap.php)
 */
$routes = array();
foreach ($config['data']['media_types_pretty_url'] as $id_object_type => $pretty_url) {

    // Build a route for each media object type > detailpage <
    // e.g. www.xxx.de/reise/reisename/
    $route_prefix = trim($pretty_url['prefix'], '/');
    $routename = 'ts_default_' . $route_prefix . '_route';
    $routes[$routename] = new Route('^' . $route_prefix . '/(.+?)', 'ts_detail_hook', 'pm-detail');

    // Build a route for each media object type > searchpage <
    // e.g. www.xxx.de/reise/reisename/
    $route_prefix = trim($pretty_url['prefix'], '/') . '-suche';
    $routename = 'ts_default_' . $route_prefix . '_route';
    $data['id_object_type'] = $id_object_type;
    $data['base_url'] = $route_prefix;
    $data['title'] = $config['data']['media_types'][$id_object_type] . ' - Suche';
    $data['meta_description'] = '';
    $routes[$routename] = new Route('^' . $route_prefix . '/?', 'ts_search_hook', 'pm-search', $data);

}

/**
 * Each route can have its own hook,
 * This hook will be fire before html output. (useful for sending http status codes or set meta data...
 */
function ts_detail_hook()
{
    global $wp, $wp_query;

    try {

        // get the media object id by url, language is not supported at this moment
        $r = Pressmind\ORM\Object\MediaObject::getByPrettyUrl('/' . $wp->request . '/', null, 'de', null);

        if (empty($r[0]->id) === true) {
            WPFunctions::throw404();
        }

        /**
         * based on the url strategy it's possible to retrieve more than one media object for url
         * at this moment we support only one (the fst found) media object by url
         */
        $id_media_object = $r[0]->id;

        $mediaObject = null;
        $key = 'pm-ts-oc-' . $id_media_object;
        if (empty($_GET['no_cache'])) {
            $mediaObject = wp_cache_get($key, 'media-object');
        }
        if (empty($mediaObject) === true) {
            $mediaObject = new Pressmind\ORM\Object\MediaObject($id_media_object);
            if (empty($_GET['no_cache'])) {
                wp_cache_set($key, $mediaObject, 'media-object', 60);
            }
        }

        if (empty($_GET['preview']) === false && $mediaObject->visibility != 30) {
            WPFunctions::throw404();
        }

        // Add custom headers
        header('id-pressmind: ' . $id_media_object);

        // Add meta data
        // set the page title
        $the_title = $mediaObject->name;
        add_filter('pre_get_document_title', function ($title_parts) use ($the_title) {
            return $the_title;
        });

        // set meta description
        $meta_desc = '<meta name="description" content="' . $mediaObject->name . '">' . "\r\n";
        add_action('wp_head', function () use ($meta_desc) {
            echo $meta_desc;
        });

        // set canonical url
        $canonical = '<link rel="canonical" href="' . site_url() . $mediaObject->getPrettyUrl() . '">' . "\r\n";
        add_action('wp_head', function () use ($canonical) {
            echo $canonical;
        });

        // set the id of the current media object as wp parameter
        $wp_query->set('id_media_object', $id_media_object);
        return;

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}

add_action('ts_detail_hook', 'ts_detail_hook');


function ts_search_hook($data)
{
    global $wp, $wp_query, $post;

    // reset post!
    $post = null;

    // Add meta data
    // set the page title
    if (empty($data['title']) === false) {
        $the_title = $data['title'];
        add_filter('pre_get_document_title', function ($title_parts) use ($the_title) {
            return $the_title;
        });
    }

    // set meta description
    if (empty($data['meta_description']) === false) {
        $meta_desc = '<meta name="description" content="' . $data['meta_description'] . '">' . "\r\n";
        add_action('wp_head', function () use ($meta_desc) {
            echo $meta_desc;
        });
    }

    // set canonical url
    $canonical = '<link rel="canonical" href="' . site_url() . '/' . $wp->request . '/">' . "\r\n";
    add_action('wp_head', function () use ($canonical) {
        echo $canonical;
    });

    // set the id of the current media object as wp parameter
    $wp_query->set('id_object_type', $data['id_object_type']);
    return;


}

add_action('ts_search_hook', 'ts_search_hook');
