@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div id="map" style="height: 800px;">

            <script>
                const map = L.map('map');
                map.setView([51.505, -0.09], 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);
                let marker, circle;
                options = {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 0,
                };
                navigator.geolocation.watchPosition(success, error, options);

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

                    var lokasi = [lat, lng];
                    // console.log(lokasi);
                    $.ajax({
                        type: "get",
                        url: "{{ route('updatelokasi') }}",
                        data: {
                            lokasi: JSON.stringify(lokasi)
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
                function error(err) {

                    if (err.code === 1) {
                        alert("Hidupkan Akses Lokasi");
                    } else {
                        alert("Tidak Bisa Mendapat Lokasi Terkini");
                    }

                }
            </script>
        </div>


        </section>

    </div>
@endsection
