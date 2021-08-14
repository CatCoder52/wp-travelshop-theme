<?php
add_action( 'init',  function() {
    add_rewrite_rule( 'service-worker\.min\.js', 'wp-content/themes/travelshop/assets/js/service-worker.min.js', 'top' );
    add_rewrite_rule( 'placeholder\.svg(.*)', 'wp-content/themes/travelshop/placeholder.svg.php$1', 'top' );
});
// flush rewrite rules after changing this lines, usage wp-cli  $ wp rewrite flush --hard --allow-root