<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = (array)$settings;
unset($args['class']); // resolve naming conflict (we remove the beaver builder custom class)
$args['class'] = $args['color_scheme'];

load_template(get_template_directory() . '/template-parts/layout-blocks/search-bar.php', false,  $args);
