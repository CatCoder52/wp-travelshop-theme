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
$map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=800x600&key='.TS_GOOGLEMAPS_API;


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


$map_style = '&markers=color:blue|';
if (count($markers) > 0) {

    $map = new stdClass();
    $map->zoom = 14;

    foreach ($markers as $k => $marker) {
        $map_url .= $map_style . 'label:' . ($k + 1) . '|' . $marker;


    }

    if (count($markers) == 1) {
        $map_url .= '&zoom=7';
    }

    echo $map_url;
    echo '<img src="' . $map_url . '" >';

}
?>


    <script>
        var map_markers = JSON.parse('<?php echo json_encode($map_markers);?>');

        function initMap() {

            if (map_markers.length == 0) {
                return;
            }

            const map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 4,
                }
            );

            for (var i = 0; i < map_markers.length; i++) {

                new google.maps.Marker({
                    position: new google.maps.LatLng(map_markers[i].lat, map_markers[i].lng),
                    map,
                    label: (i + 1).toString(),
                    title: map_markers[i].title,
                    animation: google.maps.Animation.DROP,
                }).addListener("click", function (e) {
                    console.log(e);
                });

            }

            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < map_markers.length; i++) {
                bounds.extend(map_markers[i]);
            }
            map.fitBounds(bounds);

            new google.maps.Polyline({
                path: map_markers,
                geodesic: true,
                strokeColor: "#c0c0c0",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                icons: [
                    {
                        icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
                        offset: "50%",
                        repeat: '200px'
                    },
                ],
            }).setMap(map);


        }

    </script>
    <div id="map" style="width:600px;height:600px;"></div>
    <script async
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo TS_GOOGLEMAPS_API;?>&callback=initMap">
    </script>

<hr>

<?php
// building the itinerary

foreach ($mo->getItinerarySteps() as $step) {

    // @TODO add multilanguage support
    // $content = $itineraryStep->getContentForlanguage();

    foreach ($step->sections as $section) {

        echo $section->language;
        echo '<b>' . $section->content->headline . '</b>';
        echo $section->content->description;

        $days = count($step->board);

        echo 'Tage der Etappe: ' . $days . '<br>';

        $breakfast_count = 0;
        $lunch_count = 0;
        $dinner_count = 0;
        foreach ($step->board as $board) {
            if ($board->breakfast) $breakfast_count++;
            if ($board->lunch) $lunch_count++;
            if ($board->dinner) $dinner_count++;
        }

        $board_str_parts = [];
        if ($breakfast_count > 0 || $lunch_count > 0 || $dinner_count > 0) {
            if ($breakfast_count > 0) {
                $board_str_parts[] = $breakfast_count . 'x Frühstück';
            }
            if ($lunch_count > 0) {
                $board_str_parts[] = $lunch_count . 'x Mittagessen';
            }
            if ($dinner_count > 0) {
                $board_str_parts[] = $lunch_count . 'x Abendessen';
            }
            echo '<i>Verpflegung: ' . implode(', ', $board_str_parts) . '</i><br>';
        }


        $markers = [];
        $map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=400x400&key='.TS_GOOGLEMAPS_API;
        $label_counter = 'A';
        $labels = [];

        foreach ($step->geopoints as $geopoint) {
            if (!empty($geopoint->lat) && !empty($geopoint->lng)) {
                $markers[] = $geopoint->lat . ',' . $geopoint->lng;

                if (!empty($geopoint->title)) {
                    $label_counter++;
                    $labels[$label_counter] = $geopoint->title;
                }

            }
        }

        $map_style = '&markers=color:blue|';
        if (count($markers) > 0) {
            $map_url .= $map_style . implode($map_style, $markers);
            if (count($markers) == 1) {
                $map_url .= '&zoom=7';
            }

            echo '<img src="' . $map_url . '" >';
            foreach ($labels as $label => $value) {

                echo '<div>' . $label . '=' . $value . '</div>';

            }

        }

        echo '<h2>Images</h2>';
        foreach ($step->document_media_objects as $image) {
            ?>
            <img
                    src="<?php echo $image->getUri('thumbnail'); ?>"
                    data-toggle="tooltip"
                    data-placement="bottom" data-html="true"
                    alt="<?php echo $image->alt; ?>"
                    title="<?php
                    $caption = [];
                    $caption[] = !empty($image->caption) ? $image->caption : '';
                    $caption[] = !empty($image->copyright) ? '<small>' . $image->copyright . '</small>' : '';
                    echo implode('<br>', array_filter($caption));
                    ?>"/>

            <?php
        }

        // Output step links

        // we have to group the different link types first
        $step_link_group = [];
        foreach ($step->text_media_objects as $text_media_object) {
            $step_link_group[$text_media_object->var_name]['items'][] = $text_media_object;
            $step_link_group[$text_media_object->var_name]['name'] = $text_media_object->name;
        }

        foreach ($step_link_group as $group) {
            ?>
            <h2><?php echo $group['name']; ?></h2>
            <?php
            foreach ($group['items'] as $link) {

                $lmo = new \Pressmind\ORM\Object\MediaObject($link->id_media_object, true);
                // if the linked object is not available (in most cases it must be public)
                if (empty($lmo->id)) {
                    continue;
                }

                echo $lmo->name;
                $lmoc = $lmo->getDataForLanguage();
                echo $lmoc->beschreibung_text_default;

            }
        }
        echo '<hr>';
    }
}




