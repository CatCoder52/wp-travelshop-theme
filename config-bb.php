<?php
/**
 * Beaver Builder Config File Example:
 */

define('BB_MODULE_TS_DIR', __DIR__.'/pagebuilders/beaverbuilder/');
define('BB_MODULE_TS_URL', SITE_URL.'/wp-content/themes/travelshop/pagebuilders/beaverbuilder/');

// disable modules
add_filter( 'fl_builder_register_module', function ( $enabled, $instance ) {
    $disable = array( 'search', 'menu');
    if ( in_array( $instance->slug, $disable ) ) {
        return false;
    }
    return $enabled;
}, 10, 2 );

// do not load disabled modules
add_filter( 'is_module_disable_enabled', '__return_true' );

// add theme colors to the beaverbuilder color palette
add_filter( 'fl_builder_color_presets', function( $colors ) {
    $colors = array();

    $colors[] = '8E181B';
    $colors[] = 'D11C23';
    $colors[] = '1A4688';
    $colors[] = 'D6E1EE';
    $colors[] = 'fdfffc';
    $colors[] = 'f1d302';

    return $colors;
});

// render layout.css/js in inline
//add_filter( 'fl_builder_render_assets_inline', '__return_true' );

// do not remember the last tab in a module.. ux is much better then
add_filter( 'fl_remember_settings_tabs_enabled', '__return_false' );

// if we need, we build our own
// If you'd like to disable Schema markup within Beaver Builder,
add_filter( 'fl_builder_disable_schema', '__return_true' );
