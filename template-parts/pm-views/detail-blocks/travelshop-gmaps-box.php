<?php
/**
 * THIS FILE IS A DIRTY DRAFT!!!
 * it's possible to add two types of itineraries in pressmind:
 *
 * 1. the very complex one: booking package specific itineraries
 *    which has a dependencies to the travel duration and dates
 *    and can contain different variants and travel bricks.
 *
 * or
 *
 * 2. the easy one: media object specific itineraries
 *    which has  -- NO -- dependencies to travel duration or dates
 *
 * THIS FILE handles type 2, the "easy one"
 */

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\ORM\Object\Itinerary\Variant;
use Pressmind\ORM\Object\MediaObject;

/**
 * @var array $args
 */

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $args['moc'];

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['mo'];


// check if the itinerary steps are set for this object, if not return
if (empty($mo->getItinerarySteps())) {
    return;
}


// Building a google map
$markers = [];
$map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=640x640&key='.TS_GOOGLEMAPS_API;


foreach ($mo->getItinerarySteps() as $step) {
    foreach ($step->geopoints as $geopoint) {
        if (!empty($geopoint->lat) && !empty($geopoint->lng)) {
            $markers[] = $geopoint->lat . ',' . $geopoint->lng;
            $map_markers[] = [
                'title' => strip_tags($geopoint->title),
                'lat' => $geopoint->lat,
                'lng' => $geopoint->lng
            ];

        }
    }
}
?>
<div class="travelshop-gmaps-box">
    <a class="show-map" data-modal="true" data-modal-id="100">
        <?php
            $map_style = '&markers=color:blue|';
            if (count($markers) > 0) {

                $map = new stdClass();
                $map->zoom = 6;

                foreach ($markers as $k => $marker) {
                    $map_url .= $map_style . 'label:' . ($k + 1) . '|' . $marker;
                }

                if (count($markers) == 1) {
                    $map_url .= '&zoom=7';
                } else {
                    // $map_url .= '&zoom=' . $map->zoom;
                }

                // echo $map_url;
                echo '<img class="travelshop-gmaps-box-image" src="' . $map_url . '" >';
            }
        ?>
    </a>
    <div class="travelshop-gmaps-box-contact">
        <div class="travelshop-gmaps-box-contact-phone">
            <strong>Persönliche Beratung</strong><br />
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="20px" height="20px" viewBox="0 0 24 24" stroke-width="0" stroke="#000" fill="#06f" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                </svg>
                <span>+49 (12) 345 678</span>
            </a><br />
            <small>Mo - Fr : 10:00 - 18:00 Uhr </small>
        </div>
        <div class="travelshop-gmaps-box-contact-whatsapp">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#27ae60" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                    <path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />
                </svg>
            </a><br />
            <small>WhatsApp</small>
        </div>
    </div>
</div>

<?php 
    // Booking Date Modal
    $args = [];
    $args['id_post'] = 100;
    $args['title'] = 'Reise-Etappen';
    ob_start();
    include(get_template_directory() . '/template-parts/pm-views/detail-blocks/travelshop-gmaps-map.php');
    $args['content'] = ob_get_contents();
    ob_end_clean();
    include(get_template_directory() . '/template-parts/layout-blocks/modalscreen.php' ); 
?>