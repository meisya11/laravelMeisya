@extends('layout.main')
@section('content')
    <div class="modal fade" id="detailPembeli" tabindex="-1" aria-labelledby="detailPembeliLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="detailPembeliBody">
                </div>
            </div>
        </div>
    </div>
    <div id="map" style="height: 800px;">

        <script>
            var pesanan = {!! $pesanan !!}
            console.log(pesanan);
            var pembeli = {!! $pembeli !!}
            var lokasi = pesanan.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name), {
                draggable: false,
                icon: greenIcon
            });
            console.log(lokasi);
            var titik = pembeli.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name), {
                draggable: false,
                icon: goldIcon
            });
            console.log(titik);

            var locations = L.layerGroup(lokasi);

            var greenIcon = L.icon({
                iconUrl: 'images/mark.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var goldIcon = L.icon({
                iconUrl: 'images/gold.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            let marker;

            const map = L.map('map');
            map.setView([51.505, -0.09], 13);
            layers: [locations]
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

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
                }
                marker = L.marker([lat, lng]).addTo(map);

                map.setView([lat, lng]);

                var lokasi = [lat, lng];
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
            function lokasimap() {
                map.removeLayer(locations)
                lokasi = pesanan.map((x) => L.marker(JSON.parse(x.lokasi), {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='font-size:12px' class=badge-success badge-pill'>🚩<b>" +
                            x.user_id +
                            "</b></div>",
                        iconSize: [25, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    })
                }).on('click', function(e) {
                    showDetail(x.user_id)
                    console.log(x);
                }));
                locations = L.layerGroup(lokasi);
                map.addLayer(locations)
            }
            function titikpembeli() {
                titik = pembeli.map((x) => L.marker(JSON.parse(x.lokasi), {
                    draggable: false,
                    icon: goldIcon
                }));
                locations = L.layerGroup(titik);
                map.addLayer(locations)
            }
            function updatelokasi() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('location') }}",
                    async: false,
                    success: function(response) {
                        pedagang = response;
                    }
                });
            }
            setInterval(function() {
                updatelokasi();
                lokasimap();
                titikpembeli();
            }, 2000);
            function showDetail(id) {
                $('#detailPembeli').modal('show');
                $.ajax({
                    url: "/detailpembeli/" + id,
                    method: 'GET',
                    success: function(res) {
                        $('#detailPembeliBody').html(res);
                    }
                })
            }
        </script>
    </div>
@endsection
