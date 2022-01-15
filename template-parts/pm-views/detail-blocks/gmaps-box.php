<?php

/**
 * @var array $args
 */

// check if the itinerary steps are set for this object, if not return
if (empty($args['media_object']->getItinerarySteps())) {
    return;
}

if(empty(TS_GOOGLEMAPS_API)){
    echo '<!-- TS_GOOGLEMAPS_API is empty, no google maps api key specified -->';
    return;
}

$id_modal = uniqid();
?>
<div class="travelshop-gmaps-box">
    <a class="show-map" data-modal="true" data-modal-id="<?php echo $id_modal; ?>">
        <?php
            $map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=350x350&key='.TS_GOOGLEMAPS_API;
            $map_style = '&markers=color:blue|';
            if (count($args['map_markers']) > 0) {
                foreach ($args['map_markers'] as $k => $marker) {
                    $map_url .= $map_style . 'label:' . ($k + 1) . '|' . $marker['lat'] . ',' . $marker['lng'];
                }
                if(count($args['map_markers']) == 1) {
                    $map_url .= '&zoom=7';
                }
                echo '<img class="travelshop-gmaps-box-image" src="' . $map_url . '" >';
            }
        ?>
    </a>
    <?php load_template(get_template_directory().'/template-parts/pm-views/detail-blocks/contact-box.php', false, $args);?>
</div>
<?php 
    // Google Maps Modal
    $args_maps = [];
    $args_maps['id_modal'] = $id_modal;
    $args_maps['title'] = 'Reise-Etappen';
    $args_maps['content'] = \Pressmind\Travelshop\Template::render(APPLICATION_PATHAPPLICATION_PATH . '/template-parts/pm-views/detail-blocks/gmaps-map.php', $args);
    load_template(get_template_directory() . '/template-parts/layout-blocks/modalscreen.php', false, $args_maps);
