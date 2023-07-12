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
        center: [44.4268, 26.1025],
        zoom: 13,
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    window.drawnItems = new L.FeatureGroup();
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
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);
    if(polygon){

        for (let i = 0; i < polygon.length; i++) {
            let polygonCoordinates = [];
            for (let j = 0; j < polygon[i].length; j++) {
                let cord = [polygon[i][j][1], polygon[i][j][0]];
                polygonCoordinates.push(cord);
            }
            console.log(polygonCoordinates)
            let drawPolygon = L.polygon(polygonCoordinates);

            map.fitBounds(drawPolygon.getBounds());
            drawnItems.addLayer(drawPolygon);
        }
    }

    map.on("draw:created", function (event) {
        let layer = event.layer;
        console.log("layer: ", layer)
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
