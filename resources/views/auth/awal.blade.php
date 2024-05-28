<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GO-LING | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="image mr-2">
                <img src="{{ asset('images/golinglogo.png') }}" class="brand-image img-circle elevation-3"
                    style="opacity: .8; width: 50px; height: auto;">
            </div>
            <h1 class="mb-0">GEROBAK KELILING</h1>
            <div class="d-flex align-items-center">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
                <a class="nav-link" href="{{ route('masuk') }}">Login</a>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="detailPedagang" tabindex="-1" aria-labelledby="detailPedagangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="detailPedagangBody">

                </div>
            </div>
        </div>
    </div>
    <div id="map" style="height: 800px;">

        <script>
            var pedagang = {!! $pedagang !!}

            var lokasi = pedagang.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name), {
                draggable: false,
                icon: greenIcon
            });
            var rute = {!! $rute !!}

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

                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng], {
                    icon: greenIcon,
                }).addTo(map);
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
                            x
                            .name +
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
        </script>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('lte/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @yield('js')
</body>

</html>
