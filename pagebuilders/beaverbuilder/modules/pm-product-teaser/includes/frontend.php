<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;

if ( $settings->link_top == 'true' ) {
    $args['link_top'] = true;
    echo "WAS";
} else {
    $args['link_top'] = false;
}

if ( $settings->link_teaser == 'true' ) {
    $args['link_teaser'] = true;
} else {
    $args['link_teaser'] = false;
}

if ( $settings->link_bottom == 'true' ) {
    $args['link_bottom'] = true;
} else {
    $args['link_bottom'] = false;
}

print_r($settings);

$args['link_top_text'] =  $settings->link_top_text;
$args['link_teaser_text'] =  $settings->link_teaser_text;
$args['link_bottom_text'] =  $settings->link_bottom_text;

// bind the beaver builder settings to the query string api
$args['search']['pm-ot'] = !empty($settings->{'pm-ot'}) ? $settings->{'pm-ot'} : ''; // id_object_type
$args['search']['pm-l'] = !empty($settings->page) && !empty($settings->items_per_page) ? $settings->page.','.$settings->items_per_page : '';
$args['search']['pm-o'] = (!empty($settings->order_by) && !empty($settings->order)) ? (($settings->order_by == 'rand') ? 'rand' : $settings->order_by.'-'.$settings->order): '';
$args['search']['pm-t'] = !empty($settings->{'pm-t'}) ? $settings->{'pm-t'} : ''; // fulltext term
$args['search']['pm-id'] = !empty($settings->{'pm-id'}) ? $settings->{'pm-id'} : ''; // ids
//$args['search']['pm-vr'] = !empty($settings->{'pm-vr'}) ? $settings->{'pm-vr'} : ''; // valid from, valid to range
$args['search']['pm-du'] = !empty($settings->{'pm-du'}) ? $settings->{'pm-du'} : ''; // duration range
$args['search']['pm-pr'] = !empty($settings->{'pm-pr'}) ? $settings->{'pm-pr'} : ''; // price range
$args['search']['pm-dr'] = !empty($settings->{'pm-dr'}) ? $settings->{'pm-dr'} : ''; // travel date range

foreach($settings as $k => $v){ // categories
    if(!empty($v) && preg_match('/^category_[0-9]+_([0-9]+)\-([a-z0-9\_]+)$/', $k, $matches) > 0){
        $items = explode(',',$v);
        $delimeter = ',';
        if(in_array('search-behavior-AND', $items)){
            $delimeter = '+';
        }
        if (($key = array_search('search-behavior-AND', $items)) !== false) {
            unset($items[$key]);
        }
        if (($key = array_search('search-behavior-OR', $items)) !== false) {
            unset($items[$key]);
        }
        $args['search']['pm-c'][$matches[2]] = implode($delimeter, $items);
    }
}
$args['view'] = !empty($settings->{'view'}) ? $settings->{'view'} : 'Teaser1';

// delete empty keys
$args['search'] = array_filter($args['search']);
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/product-teaser.php', false,  $args);
