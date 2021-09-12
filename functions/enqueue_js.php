<?php
if (!is_admin()) {
    add_filter('script_loader_tag', function ($tag, $handle) {
        if (strpos($handle, 'async') !== false) {
            return str_replace('\'>', '\' async>', $tag);
        } else if (strpos($handle, 'defer') !== false) {
            return str_replace('\'>', '\' defer>', $tag);
        } else {
            return $tag;
        }
    }, 10, 2);
}

add_action('wp_enqueue_scripts', function () {

    $js_files = array();
    //$js_files[] = array('src' => '/assets/js/jquery-3.5.1.min.js', 'defer' => true,'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/jquery-3.5.1.min.js'));
    $js_files[] = array('handle' => 'prettydropdowns', 'src' => '/assets/js/jquery.prettydropdowns.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'popper', 'src' => '/assets/js/popper-1.14.7.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'bootstrap', 'src' => '/assets/js/bootstrap.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'moment', 'src' => '/assets/js/moment.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'pulltorefresh', 'src' => '/assets/js/pulltorefresh.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'daterangepicker', 'src' => '/assets/js/daterangepicker.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'autocomplete', 'src' => '/assets/js/autocomplete.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'rangeslider', 'src' => '/assets/js/ion.rangeSlider.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'tiny-slider', 'src' => '/assets/js/tiny-slider.min.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'bodyScrollLock', 'src' => '/assets/js/bodyScrollLock.js', 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'travelshop-ui', 'src' => '/assets/js/ui.min.js?v=' . filemtime(get_template_directory() . '/assets/js/ui.min.js'), 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'travelshop-search', 'src' => '/assets/js/search.min.js?v=' . filemtime(get_template_directory() . '/assets/js/search.min.js'), 'defer' => true, 'version' => null);
    $js_files[] = array('handle' => 'travelshop-ajax', 'src' => '/assets/js/ajax.min.js?v=' . filemtime(get_template_directory() . '/assets/js/ajax.min.js'), 'defer' => true, 'version' => null);

    foreach ($js_files as $f) {

        if ($f['defer']) {
            $f['handle'] .= '-defer';
        }

        wp_enqueue_script($f['handle'], get_stylesheet_directory_uri() . $f['src'], array('jquery'), false, true);
    }


});