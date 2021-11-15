<?php

namespace Pressmind\Travelshop;

class ThemeActivation
{

    public function __construct(){
        add_action('after_switch_theme', [$this, 'activate']);
    }


    public function activate(){
        // Install
        $themeConfigFile = get_template_directory() . '/config-theme.php';
        $themeConfig = file_get_contents($themeConfigFile);

        // set the page url to a fixed constant
        $themeConfig = \Custom\InstallHelper::setConstant('SITE_URL', site_url(), $themeConfig);
        file_put_contents($themeConfigFile, $themeConfig);

        $this->setThumbnailsizes();
    }


    public function setThumbnailsizes(){

        foreach(TS_WP_IMAGES as $imagetype => $prop){

            // overwrite the default image sizes
            if(in_array($imagetype, ['thumbnail', 'medium', 'large']) === true){
                update_option( $imagetype.'_size_w', $prop['w']);
                update_option( $imagetype.'_size_h', $prop['h']);
                update_option( $imagetype.'_crop', $prop['crop']);
            }

        }

    }
}
