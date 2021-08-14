<?php

namespace Pressmind\Travelshop;


use Pressmind\HelperFunctions;
use Pressmind\Registry;

class AdminPage
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        add_options_page('Travelshop', 'Travelshop', 'manage_options', 'pmwc-admin', [$this, 'admin_page']);
    }


    public function admin_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo '<div class="wrap">';
        echo '<h1>pressmind® Travelshop Theme</h1>';
        echo '<h2>Configuration</h2>';
        echo '<p>';


        $configFiles = [];
        $configFiles[] = array('config-theme.php', 'Common Config: (config-theme.php)');
        $configFiles[] = array('config-routing.php', 'Routing: (config-routing.php)');
        $configFiles[] = array('pm-config.php', 'pressmind web-core SDK: (pm-config.php)');
        foreach ($configFiles as $config) {
            echo '<a href="theme-editor.php?file='.$config[0].'&theme='.wp_get_theme().'">'.$config[1].'</a><br>';
        }

        echo '</p>';

        echo '<h2>Loaded Object Type Description</h2>';
        echo '<p>
              This is a auto generated report created during pressmind web-core sdk installation.<br>
              It represents the current datamodel. You can use the property_names in your templates.
              </p>
            ';
        $sdk_config = Registry::getInstance()->get('config');
        foreach (glob(HelperFunctions::replaceConstantsFromConfig($sdk_config['docs_dir']).'/objecttypes/*.html') as $file) {

            $content = file_get_contents($file);
            $str = str_replace('h1>', 'b><br>', $content);
            echo $str;
        }


        echo '</div>';
    }

}