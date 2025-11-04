
let map, userMarker;
let cachedGyms = [];
let gymMarkers = [];

const cached = localStorage.getItem('cached_gyms');
if (cached) cachedGyms = JSON.parse(cached);

// codecool Budapest: 47.50570526066258, 19.057764

let userLat = parseFloat(localStorage.getItem('user_lat')) || 47.50570526066258;
let userLng = parseFloat(localStorage.getItem('user_lng')) || 19.057764;



async function preloadGyms(lat = userLat, lng = userLng, radius = 1000) {
    try {
        const res = await fetch(`/gymsdata?lat=${lat}&lng=${lng}&radius=${radius}&t=${Date.now()}`);
        if (!res.ok) throw new Error(`HTTP error ${res.status}`);
        const data = await res.json();
        cachedGyms = data.elements || [];
    } catch (err) {
        console.error("Error preloading gyms:", err);
    }
}

function isOpenNow(openingHours) {
    if (!openingHours) return "No data";

    const now = new Date();
    const day = now.getDay();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const currentTime = hours * 60 + minutes;

    try {
        const rules = openingHours.split(";").map(r => r.trim());
        const daysMap = {
            "Mo": 1, "Tu": 2, "We": 3, "Th": 4, "Fr": 5, "Sa": 6, "Su": 0
        };

        for (const rule of rules) {
            const [days, times] = rule.split(" ");
            if (!times) continue;

            const [start, end] = times.split("-").map(t => {
                const [h, m] = t.split(":").map(Number);
                return h * 60 + (m || 0);
            });

            const dayRanges = days.split(",");
            for (const d of dayRanges) {
                if (d.includes("-")) {
                    const [startDay, endDay] = d.split("-");
                    const startIndex = daysMap[startDay];
                    const endIndex = daysMap[endDay];
                    let current = startIndex;

                    while (true) {
                        if (current === day) {
                            if (currentTime >= start && currentTime <= end) return "Open";
                        }
                        if (current === endIndex) break;
                        current = (current + 1) % 7;
                    }
                } else if (daysMap[d] === day) {
                    if (currentTime >= start && currentTime <= end) return "Open";
                }
            }
        }

        return "Closed";
    } catch (e) {
        console.warn("Error parsing opening hours:", e);
        return "No data";
    }
}

async function loadGyms(map, lat = userLat, lng = userLng) {
    gymMarkers.forEach(m => map.removeLayer(m));
    gymMarkers = [];

    let gyms = cachedGyms.length ? cachedGyms : [];
    const radius = document.getElementById('radius')?.value || 1000;

    if(!gyms.length) {
        await preloadGyms(lat, lng, radius);
        gyms = cachedGyms;
    }

    gyms.forEach(el => {
        if(el.lat && el.lon) {
            const name = el.tags.name || "Unnamed Gym";
            const time = isOpenNow(el.tags.opening_hours);


            const marker = L.marker([el.lat, el.lon]).addTo(map);
            marker.bindPopup(`<b>${name}</b><br>Status: ${time}`);

            const label = L.divIcon({ className: 'label', html: name, iconSize: [100, 20] });
            const labelMarker = L.marker([el.lat, el.lon], { icon: label }).addTo(map);

            gymMarkers.push(marker, labelMarker);
        }
    });

    const statusEl = document.getElementById('status');
    if(statusEl) statusEl.textContent = `Found ${gyms.length} gyms near [${lat.toFixed(5)}, ${lng.toFixed(5)}]`;
}

function initMap() {
    map = L.map('map').setView([userLat, userLng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution:'&copy; OpenStreetMap contributors' }).addTo(map);

    const userIcon = L.icon({
        iconUrl: '/images/youarehere.png',
        iconSize:[40,40],
        iconAnchor:[20,40],
        popupAnchor:[0,-35]
    });

    userMarker = L.marker([userLat, userLng], {icon:userIcon, draggable:true}).addTo(map)
        .bindPopup("<b>You are here!</b>")
        .openPopup();

    userMarker.on('dragend', e => {
        const pos = e.target.getLatLng();
        userLat = pos.lat;
        userLng = pos.lng;
        localStorage.setItem('user_lat', userLat);
        localStorage.setItem('user_lng', userLng);
        loadGyms(map, userLat, userLng);
    });

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            userLat = pos.coords.latitude;
            userLng = pos.coords.longitude;
            userMarker.setLatLng([userLat, userLng]);
            map.setView([userLat, userLng], 14);
            localStorage.setItem('user_lat', userLat);
            localStorage.setItem('user_lng', userLng);
            preloadGyms(userLat, userLng);
            loadGyms(map, userLat, userLng);
        }, () => {
            preloadGyms(userLat, userLng);
            loadGyms(map, userLat, userLng);
        });
    } else {
        preloadGyms(userLat, userLng);
        loadGyms(map, userLat, userLng);
    }

    const searchBtn = document.getElementById('searchBtn');
    if(searchBtn) {
        searchBtn.addEventListener('click', async () => {
            const pos = userMarker.getLatLng();
            userLat = pos.lat;
            userLng = pos.lng;
            localStorage.setItem('user_lat', userLat);
            localStorage.setItem('user_lng', userLng);
            const statusEl = document.getElementById('status');
            if(statusEl) statusEl.textContent = "Searching...";

            cachedGyms = [];
            const radius = document.getElementById('radius')?.value || 1000;

            await preloadGyms(userLat, userLng, radius);
            await loadGyms(map, userLat, userLng);
        });
    }


}
