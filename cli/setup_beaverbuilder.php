<?php
/**
 * This script update some beaver builder options to the recommend settings for this theme.
 * default margins, paddings and enables beaver builder only for the posttype page
 */
if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);


function find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if (file_exists($dir . "/wp-config.php")) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));
    return null;
}

$wp_path = find_wordpress_base_path() . "/";

define('WP_USE_THEMES', false);

require_once($wp_path . 'wp-load.php');
require_once($wp_path . 'wp-admin/includes/admin.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

echo "enable beaverbuilder only for post type 'page'\n";
update_option("_fl_builder_post_types", ['page']);

echo "disable beaver builder template\n";
update_option("_fl_builder_enabled_templates", 'disabled');

echo "set default margins and paddings to '0' in global settings\n";
$option = get_option("_fl_builder_settings");
$option->row_margins = '0';
$option->row_padding = '0';
$option->column_margins = '0';
$option->column_padding = '0';
update_option("_fl_builder_settings", $option);

echo "setup basic security roles, check settings->beaverbuilder->user acccess\n";
update_option("_fl_builder_user_access", unserialize('a:5:{s:14:"builder_access";a:4:{s:13:"administrator";b:1;s:6:"editor";b:1;s:6:"author";b:0;s:11:"contributor";b:0;}s:20:"unrestricted_editing";a:4:{s:13:"administrator";b:1;s:6:"editor";b:1;s:6:"author";b:1;s:11:"contributor";b:0;}s:19:"global_node_editing";a:4:{s:13:"administrator";b:1;s:6:"editor";b:1;s:6:"author";b:1;s:11:"contributor";b:0;}s:13:"builder_admin";a:4:{s:13:"administrator";b:1;s:6:"editor";b:0;s:6:"author";b:0;s:11:"contributor";b:0;}s:22:"template_data_exporter";a:4:{s:13:"administrator";b:1;s:6:"editor";b:0;s:6:"author";b:0;s:11:"contributor";b:0;}}'));

echo "done\n";