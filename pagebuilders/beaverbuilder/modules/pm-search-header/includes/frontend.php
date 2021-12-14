<?php
use \Pressmind\Travelshop\Search;

/**
 * @var object $settings defined by beaver builder module
 */

$args = (array)$settings;
unset($args['class']); // resolve naming conflict (we remove the beaver builder custom class)
$args = array_merge($args, Search::getResult(['pm-ot' => TS_TOUR_PRODUCTS],2, 12, true, false));

load_template_transient(get_template_directory() . '/template-parts/layout-blocks/search-header.php', false,  (array)$args);
