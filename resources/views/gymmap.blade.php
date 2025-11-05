<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Gyms Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="icon" href="{{ asset('images/dumbbell-svgrepo-com.svg') }}" type="image/png">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        #map { height: 100vh; width: 100%; }
        .controls {
            position: fixed;
            top: 10px; left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .back, button {
            display: inline-block;
            background-color: #ea580c;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back:hover, button:hover {
            background-color: #f97316;
            transform: translateY(-2px);
        }

        .back:active {
            transform: translateY(0);
        }
        select { padding:5px 10px; background: rgb(256,256,256); color:black; border-color:rgb(256,256,256,0.2); border-radius:6px; cursor:pointer;}

        .label { background:white; border:1px solid #999; border-radius:6px; padding:2px 4px; font-size:12px; pointer-events:none; }
    </style>
</head>
<body>

<div class="controls">
    <label>Radius:
        <select id="radius">
            <option value="1000" selected>1 km</option>
            <option value="2000">2 km</option>
            <option value="5000">5 km</option>
        </select>
    </label>
    <button id="searchBtn">Search Again</button>
    <span id="status">Loading...</span>
    <a href="{{ route('dashboard') }}" class="back">Back</a>

</div>

<div id="map"></div>

<!-- External libraries -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<!-- map.js -->
<script src="{{ asset('js/map.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        initMap();
    });
</script>

</body>
</html>
