<?php
add_action( 'init', function () {
    wp_deregister_script('heartbeat');
}, 1 );
