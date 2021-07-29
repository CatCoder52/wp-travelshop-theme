<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;

// bind the beaver builder settings to the query string api
$args['search']['pm-ot'] = !empty($settings->{'pm-ot'}) ? $settings->{'pm-ot'} : ''; // id_object_type
$args['search']['pm-vi'] = !empty($settings->{'pm-vi'}) ? implode(',', $settings->{'pm-vi'}) : ''; // visibility
$args['search']['pm-l'] = !empty($settings->page) && !empty($settings->items_per_page) ? $settings->page.','.$settings->items_per_page : '';
$args['search']['pm-o'] = (!empty($settings->order_by) && !empty($settings->order)) ? (($settings->order_by == 'rand') ? 'rand' : $settings->order_by.'-'.$settings->order): '';
$args['search']['pm-po'] = !empty($settings->{'pm-po'}) ? $settings->{'pm-po'} : ''; // id_pool
$args['search']['pm-t'] = !empty($settings->{'pm-t'}) ? $settings->{'pm-t'} : ''; // fulltext term
$args['search']['pm-id'] = !empty($settings->{'pm-id'}) ? $settings->{'pm-id'} : ''; // ids
$args['search']['pm-vr'] = !empty($settings->{'pm-vr'}) ? $settings->{'pm-vr'} : ''; // valid from, valid to range
$args['search']['pm-du'] = !empty($settings->{'pm-du'}) ? $settings->{'pm-du'} : ''; // duration range
$args['search']['pm-pr'] = !empty($settings->{'pm-pr'}) ? $settings->{'pm-pr'} : ''; // price range
$args['search']['pm-dr'] = !empty($settings->{'pm-dr'}) ? $settings->{'pm-dr'} : ''; // travel date range
foreach($settings as $k => $v){ // categories
    if(!empty($v) && preg_match('/^category_'.$args['search']['pm-ot'] .'_([0-9]+)\-([a-z0-9\_]+)$/', $k, $matches) > 0){
        $args['search']['pm-c'][$matches[2]] = $v;
    }
}
$args['view'] = !empty($settings->{'pm-ot'}) ? $settings->{'view_'. $settings->{'pm-ot'}} : '';

// delete empty keys
$args['search'] = array_filter($args['search']);

load_template(get_template_directory() . '/template-parts/layout-blocks/product-teaser.php', false,  $args);
