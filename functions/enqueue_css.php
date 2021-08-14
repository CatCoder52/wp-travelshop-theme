<?php

add_action('wp_head', function(){
    wp_enqueue_style('main-style', get_template_directory_uri().'/assets/scss/app.min.css?'.filemtime(get_template_directory() . '/assets/scss/app.min.css'));
}, 0);

add_action('wp_head', function(){
    wp_add_inline_style( 'main-style', file_get_contents(realpath(__DIR__.'/../../../../wp-includes/css/dist/block-library/style.min.css')));
}, 1);
