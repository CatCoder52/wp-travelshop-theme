<?php
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
$moc = $args['data'];

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];


$markers = [];
$map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=800x600&key=AIzaSyAR2e2Fz1U5EfexwhRj2Q2EA094mA63GK8';

/** @var Variant $variant */
foreach ($mo->getItineraryVariants() as $variant) {
    foreach ($variant->steps as $step) {
            foreach ($step->geopoints as $geopoint) {
                if(!empty($geopoint->lat) && !empty($geopoint->lng)){
                    $markers[] = $geopoint->lat.','.$geopoint->lng;
                    $map_markers[] = [
                        'title' => strip_tags($geopoint->title),
                        'lat'   => $geopoint->lat,
                        'lng'  => $geopoint->lng
                    ];

                }
            }
    }
}


$map_style = '&markers=color:blue|';
if(count($markers) > 0){

    $map = new stdClass();
    $map->zoom = 14;

    foreach($markers as $k => $marker){
        $map_url .= $map_style.'label:'.($k + 1).'|'.$marker;


    }

    if(count($markers) == 1){
        $map_url .= '&zoom=7';
    }

    echo $map_url;
    echo '<img src="'.$map_url.'" >';

}
?>



<script>
    var map_markers = JSON.parse('<?php echo json_encode($map_markers);?>');

    function initMap() {

        if(map_markers.length == 0){
            return;
        }

        const map = new google.maps.Map(
            document.getElementById('map'), {
                zoom: 4,
            }
        );

        for (var i = 0; i < map_markers.length; i++) {

             new google.maps.Marker({
                position:  new google.maps.LatLng (map_markers[i].lat,map_markers[i].lng),
                map,
                label: (i + 1).toString(),
                title: map_markers[i].title,
                animation: google.maps.Animation.DROP,
            }).addListener("click", function(e){
                console.log(e);
            });

        }

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < map_markers.length; i++) {
            bounds.extend (map_markers[i]);
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
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAR2e2Fz1U5EfexwhRj2Q2EA094mA63GK8&callback=initMap">
    </script>


<?php



// Reiseverlauf


echo '<hr>';


/** @var Variant $variant */
foreach ($mo->getItineraryVariants() as $variant) {
    foreach ($variant->steps as $step) {
        foreach ($step->sections as $section) {


            echo $section->language;


            echo('<b>' . $section->content->headline . '</b>');
            echo($section->content->description);


            $days = count($step->board);

            echo 'Tage der Etappe: '.$days.'<br>';

            $breakfast_count = 0;
            $lunch_count = 0;
            $dinner_count = 0;
            foreach ($step->board as $board) {
                if($board->breakfast) $breakfast_count++;
                if($board->lunch) $lunch_count++;
                if($board->dinner) $dinner_count++;
            }

            $board_str_parts = [];
            if($breakfast_count > 0 || $lunch_count > 0 || $dinner_count > 0){

                if($breakfast_count > 0){
                    $board_str_parts[] = $breakfast_count.'x Frühstück';
                }
                if($lunch_count > 0){
                    $board_str_parts[] = $lunch_count.'x Mittagessen';
                }

                if($dinner_count > 0){
                    $board_str_parts[] = $lunch_count.'x Abendessen';
                }

                echo '<i>Verpflegung: '.implode(', ',$board_str_parts).'</i><br>';
            }


            // Maps API Key: AIzaSyAR2e2Fz1U5EfexwhRj2Q2EA094mA63GK8

            $markers = [];
            $map_url = 'https://maps.googleapis.com/maps/api/staticmap?size=400x400&key=AIzaSyAR2e2Fz1U5EfexwhRj2Q2EA094mA63GK8&';
            $label_counter  = 'A';
            $labels  = [];

            foreach ($step->geopoints as $geopoint) {
                if(!empty($geopoint->lat) && !empty($geopoint->lng)){
                    $markers[] = $geopoint->lat.','.$geopoint->lng;

                    if(!empty($geopoint->title)){
                        $label_counter++;
                        $labels[$label_counter] = $geopoint->title;
                    }

                }
            }

            $map_style = '&markers=color:blue|';
            if(count($markers) > 0){
                $map_url .= $map_style.implode($map_style, $markers);
                if(count($markers) == 1){
                    $map_url .= '&zoom=7';
                }

                echo '<img src="'.$map_url.'" >';
                foreach($labels as $label => $value){

                    echo '<div>'.$label.'='.$value.'</div>';

                }

            }

            /* Bugfix #152227 opened
            echo '<h2>Images</h2>';
            foreach ($step->document_media_objects as $image) {
                echo '<pre>' . print_r($image->toStdClass(), true) . '</pre>';
                echo '<img src="' . $image->getImageSrc('detail') . '">';
            }
            */

            echo '<hr>';
        }
    }
}