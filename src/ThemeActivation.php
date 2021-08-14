<?php

namespace Pressmind\Travelshop;

class ThemeActivation
{

    public function __construct()
    {
        add_action('after_switch_theme', [$this, 'activate']);
    }


    public function activate()
    {

        // Install
        $themeConfigFile = get_template_directory() . '/config-theme.php';
        $themeConfig = file_get_contents($themeConfigFile);

        // set the page url to a fixed constant
        $themeConfig = $this->setConstant('SITE_URL', site_url(), $themeConfig);

        file_put_contents($themeConfigFile, $themeConfig);

        $this->setThumbnailsizes();

    }


    public function setThumbnailsizes(){

        /**
         * @todo: make the s3 plugin stateless ready
         *
         * image sizes are planned for a viewport of 1140px width
         * image ratio 1:6
         * the "thumb"-size is used for a 4 columns
         * the "medium"-size is used for a 3 columns
         * the "large"-size is used for 75% of the viewport (9/12)
         *
         * if you edit this file run: php travelshop/cli/regenerate-images.php --all` on your cli to generate new image derivated
         *
         */

        update_option( 'thumbnail_size_w', 255 );
        update_option( 'thumbnail_size_h', 159 );
        update_option( 'thumbnail_crop', 1 );

        // do not forgot the post_thumb  :-|
        set_post_thumbnail_size( 255, 159, true );

        update_option( 'medium_size_w', 350 );
        update_option( 'medium_size_h', 218 );
        update_option( 'medium_crop', 1 );

        //medium_large
        update_option( 'large_size_w', 825 );
        update_option( 'large_size_h', 515 );
        update_option( 'large_crop', 1);
    }

    /**
     * Search defined constant in a php file and replace it's value
     * @param $constant
     * @param $value
     * @param $str
     * @return string
     */
    private function setConstant($constant, $value, $str){
        return preg_replace('/(define\(\''.$constant.'\',\s*\')(.*)(\'\);)/', '$1'.$value.'$3', $str);
    }


}
