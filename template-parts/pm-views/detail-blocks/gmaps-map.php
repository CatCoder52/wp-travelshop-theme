<?php
/**
 * @var array $args
 */
?>
<script>
        let map_markers = JSON.parse('<?php echo json_encode($args['map_markers']);?>');
        function initMap() {
            if (map_markers.length == 0) {
                return;
            }
            const map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 4,
                }
            );
            for (let i = 0; i < map_markers.length; i++) {
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
            let bounds = new google.maps.LatLngBounds();
            for (let i = 0; i < map_markers.length; i++) {
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
<div id="map"></div>
<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo TS_GOOGLEMAPS_API;?>&callback=initMap"></script>