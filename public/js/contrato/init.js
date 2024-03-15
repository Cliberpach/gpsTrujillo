
$(document).ready(function() {
    map = new google.maps.Map(document.getElementById("map"),{
        zoom: 9,
        center:{ 
                lat: -8.11599, 
                lng: -79.02998 
               },
        gestureHandling: "greedy",
        draggableCursor: "default"
    });
    console.log(map);
    map_geocerca = new google.maps.Map(document.getElementById("map_geocerca"), {
        zoom:9,
        center:{ lat: -8.11599, lng: -79.02998 },
        gestureHandling: "greedy",
        draggableCursor: "default"
    });
    polygon = new google.maps.Polygon();
    google.maps.event.addListener(map, "click", function(event) {
        startLocation = event.latLng;
        var marker = new google.maps.Marker({
            position: startLocation,
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, "dragend", function() {
            generar();
        });
        markers.push(marker);
        generar();
    });

});
