<?php
function replace_wp_headers($headers) {
    $headers['Accept-CH'] = 'DPR, Width, Viewport-Width, Downlink, ECT, Device-Memory, Save-Data';
    $headers['Accept-CH-Lifetime'] = '86400';
    return $headers;
}
add_filter('wp_headers', 'replace_wp_headers');