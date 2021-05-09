<?php

/**
 * How does this routing work:
 * 1. a route delivers a custom template from the theme directory (like WP's single.php)
 * 2. a route can trigger a custom hook, this is useful to setup customs headers, or deliver the requested site
 * from the content from pressmind's web-core sdk, sample above
 */

use Pressmind\Registry;
use Pressmind\Travelshop\Route;
use Pressmind\Travelshop\WPFunctions;

/**
 * Routing
 * Generating the routes dynamically based on the pressmind web-core pretty_url config, see pm-config.php
 * In real world you should check if all routes are required by your project
 */
$config = Registry::getInstance()->get('config');
$routes = array();


$languages = [$config['data']['languages']['default']];
if (MULTILANGUAGE_SITE) {
    $languages = $config['data']['languages']['allowed'];
}

foreach ($languages as $language) {

    foreach ($config['data']['media_types_pretty_url'] as $id_object_type => $pretty_url) {

        //Build only routes for primary media object types
        if (!empty($config['data']['primary_media_type_ids']) && !in_array($id_object_type, $config['data']['primary_media_type_ids'])) {
            continue;
        }

        $language_prefix = '';
        if (MULTILANGUAGE_SITE) {
            $language_prefix = 'de/';
        }

        // Build a route for each media object type > detailpage <
        // e.g. www.xxx.de/reise/reisename/
        $route_prefix = $language_prefix . trim($pretty_url['prefix'], '/');
        $routename = 'ts_default_' . $route_prefix . '_route';

        $data = [];
        $data['id_object_type'] = $id_object_type;
        $data['type'] = 'detail';
        $data['language'] = $language;
        $data['base_url'] = $route_prefix;

        $routes[$routename] = new Route('^' . $route_prefix . '/(.+?)', 'ts_detail_hook', 'pm-detail', $data);


        // Build a route for each media object type > searchpage <
        // e.g. www.xxx.de/reise/reisename/
        $route_prefix = $language_prefix . trim($pretty_url['prefix'], '/') . '-suche';

        $routename = 'ts_default_' . $route_prefix . '_route';
        $data = [];
        $data['id_object_type'] = $id_object_type;
        $data['type'] = 'search';
        $data['language'] = $language;
        $data['base_url'] = $route_prefix;
        $data['title'] = $config['data']['media_types'][$id_object_type] . ' - Suche | ' . get_bloginfo('name');
        $data['meta_description'] = '';
        $routes[$routename] = new Route('^' . $route_prefix . '/?', 'ts_search_hook', 'pm-search', $data);

    }
}

/**
 * Each route can have its own hook,
 * This hook will be fire before html output. (useful for sending http status codes or set meta data...
 */
function ts_detail_hook($data)
{
    global $wp, $wp_query;

    try {

        if (MULTILANGUAGE_SITE) {
            $route = preg_replace('(^' . $data['language'] . '\/)', '', $wp->request);
        } else {
            $route = $wp->request;
        }

        // get the media object id by url, language is not supported at this moment
        $r = Pressmind\ORM\Object\MediaObject::getByPrettyUrl('/' . $route . '/', $data['id_object_type'], $data['language'], null);

        if (empty($r[0]->id) === true) {
            WPFunctions::throw404();
        }

        /**
         * based on the url strategy it's possible to retrieve more than one media object for url
         * at this moment we support only one (the fst found) media object by url
         */
        $id_media_object = $r[0]->id;

        $id_media_objects = [];
        foreach ($r as $i) {
            $id_media_objects[] = $i->id;
        }

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

        // Add custom headers, for better debugging
        header('id-pressmind: ' . implode(',', $id_media_objects));

        // Add meta data
        // set the page title
        $the_title = $mediaObject->name . ' | ' . get_bloginfo('name');
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

    // TODO
    $data['language'] = 'de';

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
