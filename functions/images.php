<?php

/**
 * Set names for custom images sizes.
 * All images sizes for the WordPress PostTypes set in config-theme.php, they will be set on ThemeActivation to
 * avoid database inserts or update on each page load
 * the spoken names are defined here.
 *
 * Tip: the pressmind image sizes are defined in the pm-config.php
 */
add_filter('image_size_names_choose', function ( $sizes ) {

    foreach(TS_WP_IMAGES as $imagetype => $prop){

        // do not overwrite wp's default names
        if(in_array($imagetype, ['post_thumbnail', 'thumbnail', 'medium', 'large'])){
            continue;
        }

        $sizes[$imagetype] = $prop['name'];
    }

   return $sizes;
});

foreach(TS_WP_IMAGES as $imagetype => $prop){
    if(in_array($imagetype, ['post_thumbnail', 'thumbnail', 'medium', 'large'])){
        continue;
    }
    add_image_size( $imagetype, $prop['w'], $prop['h'], $prop['crop']);
}