@extends('layout.main')
@section('content')
    <div id="map" style="height: 800px; weight:100%">
    @section('js')
        <script>
            var map = L.map('map').setView([-5.400219, 105.256424], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var lokasi = @json($lokasi);
            console.log(lokasi);
            var titik = JSON.parse(lokasi);
            console.log(titik);
            L.marker([titik.lat, titik.lng]).addTo(map);
            let marker, circle;
            options = {
                enableHighAccuracy: false,
                timeout: 5000,
                maximumAge: 0,
            };

            function success(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;

                if (marker) {
                    map.removeLayer(marker);
                    map.removeLayer(circle);
                }
                marker = L.marker([lat, lng]).addTo(map);
                circle = L.circle([lat, lng], {
                    radius: accuracy
                }).addTo(map);
                map.setView([lat, lng]);
            }
        </script>
    @stop
@endsection
