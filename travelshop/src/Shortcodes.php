<?php

namespace Pressmind\Travelshop;




class Shortcodes
{

    public function __construct()
    {
        add_shortcode('ts-list', [$this, 'list']);
        add_shortcode('ts-searchroutes', [$this, 'searchRoutes']);
        add_shortcode('ts-searchpage', [$this, 'searchPage']);
    }

    /**
     * @example [ts-list view="Teaser1" pm-ot="123" pm-t="Italien"  pm-pr="1-1000" pm-dr=20201231-20210131 pm-*=...]
     * attr "view" defines the view template (default "Teaser1"), located in wp-content/themes/travelshop/template-parts/pm-views/*
     * @see for further Documentation and all possible attributes see readme.md section "Query API"
     * @param $atts
     * @return string
     */
    public function list($atts)
    {

        if(empty($atts['pm-ot'])){
            return false;
        }

        // support constants as Object Type ID, for better theme normalization
        if(preg_match('/^([0-9]+)$/', $atts['pm-ot']) == 0){
            $atts['pm-ot'] = constant($atts['pm-ot']);
        }

        // remap wordpress shortcode to subkeys
        foreach ($atts as $key => $value) {
            if (preg_match('/^pm\-c\-([a-zA-Z0-9_\-]+)$/', $key, $matches) > 0) {
                $atts['pm-c'][$matches[1]] = $value;
                unset($atts[$key]);
            }
        }


        $search = \BuildSearch::fromRequest($atts);
        $mediaObjects = $search->getResults();

        /*
        $total_result = $search->getTotalResultCount();
        $current_page = $search->getPaginator()->getCurrentPage();
        $pages = ceil($total_result / $search->getPaginator()->getPageSize());
        */

        $view = 'Teaser1';
        if(empty($atts['view']) === false){
            $view = $atts['view'];
        }

        $output = '<div class="container">
                <div class="row">';
        foreach ($mediaObjects as $mediaObject) {
            $output .= $mediaObject->render($view, 'de');
        }
        $output .= '</div>
                </div>';
        return $output;

    }


    /**
     * This Shortcode is for demo purposes only.
     * it's rendundant to the current defined routing.. so use it only for demonstration
     * @return string
     */
    public function searchRoutes(){
        global $config;
        $output = '<ul>';
        foreach ($config['data']['media_types_pretty_url'] as $id_object_type => $pretty_url) {
            $route = trim($pretty_url['prefix'], '/').'-suche';
            $url = site_url().'/'.$route.'/';
            $output .= '<li><a href="'.$url.'">'.$route.'</a></li>';
        }
        $output .= '</ul>';
        return $output;
    }

    /**
     * Delivers the default searchpage by the defined constant (see config-theme.php)
     * e.g. [ts-searchpage page="TS_TOUR_PRODUCTS"]
     * @param $atts
     * @return string|null
     */
    public function searchPage($atts){
        global $PMTravelShop;
        $page = $PMTravelShop->RouteProcessor->get_url_by_object_type(constant($atts['page']));
        if($page == false){
            return null;
        }

        return site_url().'/'.$page.'/';

    }
}

