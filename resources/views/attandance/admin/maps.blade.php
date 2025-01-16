<style>
    #map {
        height: 180px;
    }
</style>

<div id="map"></div>

<script>
    var lokasi = "{{ $att->loc_in }}";
    var loc = lokasi.split(",");
    var lat = loc[0];
    var long = loc[1];
    var map = L.map('map').setView([lat, long], 19);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lat, long]).addTo(map);
    var circle = L.circle([-6.980572005652388, 107.62957535971948], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 20
    }).addTo(map);

    var popup = L.popup()
    .setLatLng([lat, long])
    .setContent("{{ $att->nama }}")
    .openOn(map);
</script>
