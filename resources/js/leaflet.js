import "leaflet";
import "leaflet-draw";

var map;

if(document.getElementById('map')){
    initMap();
    document.addEventListener('contentAreaFormChanged', function(e) {
        console.log("Map rendered!", e.detail);
        map.remove();
        initMap(e.detail);
    });
    }else{
    console.error("<div id='map'> element not found");
}

function initMap(polygon){
    map = L.map('map', {
        center: [32.162369, 74.183083],
        zoom: 13,
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let drawnItems = new L.FeatureGroup();
    drawnItems.addTo(map)
    let drawControl = new L.Control.Draw({
        draw: {
            polygon: true,  // Enable drawing polygons
            rectangle: false,  // Disable drawing rectangles
            circle: false,  // Disable drawing circles
            circlemarker: false,  // Disable drawing circles
            marker: false,  // Disable drawing markers
            polyline: false,  // Disable drawing polyLines
        },
        // edit: {
        //     featureGroup: drawnItems
        // }
    });
    map.addControl(drawControl);
    if(polygon){
        console.log(polygon)
        drawnItems.addLayer(L.geoJSON(polygon));
    }

    map.on("draw:created", function (event) {
        let layer = event.layer;
        Livewire.emit('polygonAdded', layer.toGeoJSON());
        drawnItems.addLayer(layer);
    });

    map.on('draw:edited', function (event) {
        let layers = event.layers;
        layers.eachLayer(function (layer){
            Livewire.emit('polygonUpdated', layer.toGeoJSON());
        });
    });
}
