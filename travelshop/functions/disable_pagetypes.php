<?php
add_action('template_redirect', function () {
    global $wp_query;
    if ( is_author() || is_category()) {
        $wp_query->set_404();
        status_header(404);
    }
});

