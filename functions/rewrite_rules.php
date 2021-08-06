<?php
add_action( 'init',  function() {
    add_rewrite_rule( 'service-worker\.min\.js', 'wp-content/themes/travelshop/assets/js/service-worker.min.js', 'top' );
});