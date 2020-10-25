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
