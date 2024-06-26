@extends('layout.main')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="detailPedagang" tabindex="-1" aria-labelledby="detailPedagangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="detailPedagangBody">
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div id="map" style="height: 800px;">

        <script>
            var pedagang = {!! $pedagang !!}

            var lokasi = pedagang.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name), {
                draggable: false,
                icon: greenIcon
            });
            var rute = {!! $rute !!}
            // console.log(pedagang)

            var locations = L.layerGroup(lokasi);

            var greenIcon = L.icon({
                iconUrl: 'images/mark.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var startIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='font-size:12px' class='badge badge-primary badge-pill'>🚩<br><b>Start</b></div>",
                iconSize: [25, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var finishtIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='font-size:12px' class='badge badge-danger badge-pill'>🏁<br><b>Finish</b></div>",
                iconSize: [25, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            const map = L.map('map', {
                center: [-5.3647543, 105.2723488],
                zoom: 12,
                layers: [locations]
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20, // Anda bisa menyesuaikan maxZoom sesuai kebutuhan
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map);

            rute.forEach(r => {
                var routingControl = L.Routing.control({
                    waypoints: JSON.parse(r.lokasi),
                    show: false,
                    routeLine: function(route) {
                        var line = L.Routing.line(route, {
                            addWaypoints: false,
                            routeWhileDragging: false,
                            autoRoute: true,
                            useZoomParameter: false,
                            draggableWaypoints: false,
                            styles: [{
                                color: 'green',
                                opacity: 0.3,
                                weight: 10
                            }, {
                                color: 'green',
                                opacity: 1,
                                weight: 3
                            }]
                        });
                        line.eachLayer(function(l) {
                            l.on('click', function(e) {
                                showDetail(r.users);
                            });
                        });

                        return line;
                    },
                    createMarker: function(i, start, n) {
                        if (i == 1) {
                            return L.marker(start.latLng, {
                                draggable: false,
                                icon: finishtIcon
                            });
                        } else if (i == 0) {
                            return L.marker(start.latLng, {
                                draggable: false,
                                icon: startIcon
                            });
                        }
                    }
                }).addTo(map);
            });
            var rute = [];
            let marker;
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

                rute.push({
                    lat: lat,
                    lng: lng
                })

                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng], {
                    icon: greenIcon,
                }).addTo(map);

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
                    alert("Please allow geolocation access");
                }
            }

            // console.log(pedagang);
            function lokasimap() {
                map.removeLayer(locations)
                lokasi = pedagang.map((x) => L.marker(JSON.parse(x.lokasi), {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='font-size:12px' class='badge badge-success badge-pill'>🚎 <b>" +
                            x.name +
                            "</b></div>",
                        iconSize: [25, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    })
                }).on('click', function(e) {
                    showDetail(x.id)
                }));
                locations = L.layerGroup(lokasi);
                map.addLayer(locations)
            }


            function updatelokasi() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('locations') }}",
                    async: false,
                    success: function(response) {
                        pedagang = response;
                    }
                });
            }
            setInterval(function() {
                updatelokasi();
                lokasimap();
            }, 2000);

            function showDetail(id) {
                $('#detailPedagang').modal('show');
                $.ajax({
                    url: "/detailpedagang/" + id,
                    method: 'GET',
                    success: function(res) {
                        $('#detailPedagangBody').html(res);
                    }
                })
            }

            map.on('click', function(e) {
                L.marker(e.latlng).addTo(map);
                rute.push(e.latlng);
                console.log(rute);

                L.Routing.control({
                    waypoints: rute
                }).addTo(map);
            });
        </script>
    </div>
@endsection
