<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Test</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
        integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"
        integrity="sha512-h9FcoyWjHcOcmEVkxOfTLnmZFWIH0iZhZT1H2TbOq55xssQGEJHEaIm+PgoUaZbRvQTNTluNOEfb1ZRy6D3BOw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/css/app.css')
</head>

<body class="d-flex h-100 text-center text-white bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <main class="px-3">
            <h1>Add Area</h1>
            <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                been the industry's standard dummy text ever since the 1500s.</p>
            <p class="lead">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="email" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select class="form-select" id="category">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date">
                            </div>
                            <div class="mb-3">
                                <label for="owner" class="form-label">Owner</label>
                                <select class="form-select" id="owner">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="col-12">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            </p>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"
        integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let map;

        async function initMap() {
            const {
                Map
            } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("map"), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 8,
            });
        }

        setTimeout(() => {
            initMap();
        }, 500);
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1-7rCun_Jhh-ODzJSdqzqOoz18dU9DbI&callback=initMap"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"
        integrity="sha512-puJW3E/qXDqYp9IfhAI54BJEaWIfloJ7JWs7OeD5i6ruC9JZL1gERT1wjtwXFlh7CjE7ZJ+/vcRZRkIYIb6p4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var leafletMap = L.map('map', {
            center: [51.505, -0.09],
            zoom: 13,
        });
        var latlngs = [
            [37, -109.05],
            [41, -109.03],
            [41, -102.05],
            [37, -102.04]
        ];

        var polygon = L.polygon(latlngs, {
            color: 'red'
        }).addTo(leafletMap);

        // zoom the map to the polygon
        leafletMap.fitBounds(polygon.getBounds());
    </script>
</body>

</html>
