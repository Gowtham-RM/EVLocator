<!DOCTYPE html>
<html>
<head>
    <title>Locator - Station</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />
    <script src="https://unpkg.com/leaflet-geosearch/dist/bundle.min.js"></script>
    <style>
      #map { height: 700px; margin-top: 10px; }
        
        /* Align Exit Navigation button to the left */
        .input-container {
            position: absolute;
            top: 6px;
            left: 50px; /* Aligned to the left */
            display: flex;
            gap: 10px;
            z-index: 1000; /* Ensures it stays on top of the map */
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .input-container input, .input-container button {
            padding: 5px;
            font-size: 14px;
            border-radius: 10%;
        }

        .input-container button {
            cursor: pointer;
            background-color: red;
            color: aliceblue;
        }
        
        /* Popup button styles */
        .popup-button {
            padding: 6px 10px;
            font-size: 13px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s ease-in-out;
        }
        .popup-button.navigate {
            background-color: #28a745;
            color: white;
        }
        .popup-button.exit {
            background-color: #dc3545;
            color: white;
        }
        .popup-button:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }
        .popup-button:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
<div class="input-container">
        <button onclick="exitNavigation()">Exit Navigation</button>
        
        <button onclick="findNearestStation()">Find Nearest Station</button>
    </div>
    <div id="map"></div>

    <script>
    var map = L.map('map').setView([11.28154, 77.5974], 13);

    var streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var routingControl;
    var liveLocation = null;
    var liveLocationMarker, liveLocationCircle;
    var chargingStations = []; // Global array to store charging station data

    googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    googleStreets.addTo(map);

    // Fetch charging station data from your backend API
    const API_BASE_URL = window.API_BASE_URL || 'https://evlocator-backend.onrender.com';
    fetch(`${API_BASE_URL}/api/charging-stations`)
        .then(response => response.json())
        .then(data => {
            // Store the fetched data in the global chargingStations array
            chargingStations = data;

            // Use the fetched data to dynamically populate charging stations on the map
            data.forEach(station => {
                var marker = L.marker([station.lat, station.lng]).addTo(map)
                .bindPopup(`
  <div>
    <strong>${station.name}</strong><br>
    ${station.address}<br>
    <strong>${station.connectors|| "No connectors available"}</strong>
    <br>
    <button class="popup-button navigate" onclick="navigateFromMarker(${station.lat}, ${station.lng})">Navigate Here</button>
    <a href="book.php" target="blank">
        <button class="popup-button book" onclick="bookNow(this)">Book now</button>
    </a>
    <button class="popup-button exit" onclick="exitNavigation()">Exit</button>
  </div>
`);


                // Add hover effect for the marker
                marker.on('mouseover', function () {
                    marker.openPopup(); // Show popup on hover
                });
                marker.on('mouseout', function () {
                    marker.openPopup(); // Hide popup when not hovered
                });
            });
        })
        .catch(error => {
            console.error('Error fetching charging stations:', error);
        });

    // Automatically display live location marker and circle
    navigator.geolocation.watchPosition(
        (pos) => {
            liveLocation = [pos.coords.latitude, pos.coords.longitude];
            if (liveLocationMarker) map.removeLayer(liveLocationMarker);
            liveLocationMarker = L.marker(liveLocation).addTo(map).bindPopup("Current location");
            if (liveLocationCircle) map.removeLayer(liveLocationCircle);
            liveLocationCircle = L.circle(liveLocation, { radius: pos.coords.accuracy }).addTo(map);
        },
        (err) => alert("Unable to get live location: " + err.message),
        { enableHighAccuracy: true }
    );

    // Function to find the nearest charging station
    function findNearestStation() {
        if (!liveLocation) {
            alert("Live location not available.");
            return;
        }

        let nearestStation = null;
        let minDistance = Infinity;

        // Iterate through each charging station and calculate the distance
        chargingStations.forEach(station => {
            const stationLatLng = L.latLng(station.lat, station.lng);
            const distance = L.latLng(liveLocation).distanceTo(stationLatLng); // Get the distance in meters

            if (distance < minDistance) {
                minDistance = distance;
                nearestStation = station;
            }
        });

        // Check if nearest station was found
        if (nearestStation) {
            const distanceInKm = (minDistance / 1000).toFixed(2); // Convert meters to kilometers and round to 2 decimal places
            alert(`The nearest station is: ${nearestStation.name}, located ${distanceInKm} km away.`);
            
            // Optionally, you can center the map on the nearest station
            map.setView([nearestStation.lat, nearestStation.lng], 15);

            // Add a marker for the nearest station
            L.marker([nearestStation.lat, nearestStation.lng]).addTo(map)
            .bindPopup(`
  <div>
    <strong>${nearestStation.name}</strong><br>
    ${nearestStation.address}<br>
    <strong>${nearestStation.connectors|| "No connectors available"}</strong>
    <br>
    <button class="popup-button navigate" onclick="navigateFromMarker(${nearestStation.lat}, ${nearestStation.lng})">Navigate Here</button>
    <a href="book.php" target="blank">
        <button class="popup-button book" onclick="bookNow(this)">Book now</button>
    </a>
    <button class="popup-button exit" onclick="exitNavigation()">Exit</button>
  </div>
`).openPopup();

        } else {
            alert("No stations found.");
        }
    }

    // Navigation from charging station to live location
    function navigateFromMarker(markerLat, markerLng) {
        if (routingControl) map.removeControl(routingControl);
        if (!liveLocation) {
            alert("Live location not available.");
            return;
        }
        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(markerLat, markerLng),
                L.latLng(liveLocation[0], liveLocation[1])
            ],
            routeWhileDragging: true,
            lineOptions: { styles: [{ color: 'blue', opacity: 0.7, weight: 8 }] }
        }).addTo(map);
    }

    // Exit navigation function
    function exitNavigation() {
        if (routingControl) {
            map.removeControl(routingControl);
            routingControl = null;
            alert("Navigation exited.");
        }
    }

    /*// Search functionality using GeoSearch
    const searchControl = new GeoSearch.GeoSearchControl({
        provider: new GeoSearch.OpenStreetMapProvider(),
        style: 'bar',
        autoClose: true,
        retainZoomLevel: false,
        searchLabel: 'Search for a place...',
    });
    map.addControl(searchControl);

    map.on('geosearch/showlocation', (result) => {
        map.setView([result.location.y, result.location.x], 15);
    });*/
</script>

</body>
</html>
