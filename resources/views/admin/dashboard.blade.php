@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="card" style="background-color: #12ACED; padding:10px;">
            <div class="content-header">

                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><b>Dashboard</b></h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">


                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-white" style="font-weight: bold;">
                                <div class="inner">
                                    <h4 style="display: inline-block; vertical-align: middle; margin-right: 10px;"><b>
                                            Pedagang Aktif</b></h4>
                                    {{-- <i class="nav-icon fa-sharp fa-solid fa-car" --}}
                                    {{-- style="font-size: 36px; vertical-align: middle; float: right; color: #12ACED;"></i> --}}
                                    <p style="font-size: 36px">2</p>
                                    <a href="#" class="small-box-footer" style="color: black;"></i></a>

                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-white" style="font-weight: bold;">
                                <div class="inner">
                                    <h4 style="display: inline-block; vertical-align: middle; margin-right: 10px;"><b>
                                            Rute Diajukan</b></h4>
                                    {{-- <i class="nav-icon fa-sharp fa-solid fa-car" --}}
                                    {{-- style="font-size: 36px; vertical-align: middle; float: right; color: #12ACED;"></i> --}}
                                    <p style="font-size: 36px">2</p>
                                    <a href="#" class="small-box-footer" style="color: black;"></i></a>
                                </div>
                            </div>
                        </div>


                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-white" style="font-weight: bold;">
                                <div class="inner">
                                    <h4 style="display: inline-block; vertical-align: middle; margin-right: 10px;"><b>
                                            Pengguna Aktif</b></h4>
                                    {{-- <i class="nav-icon fa-sharp fa-solid fa-car" --}}
                                    {{-- style="font-size: 36px; vertical-align: middle; float: right; color: #12ACED;"></i> --}}
                                    <p style="font-size: 36px">14</p>
                                    <a href="#" class="small-box-footer" style="color: black;"></i></a>

                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-white" style="font-weight: bold;">
                                <div class="inner">
                                    <h4 style="display: inline-block; vertical-align: middle; margin-right: 10px;"><b>
                                            Total Akun</b></h4>
                                    {{-- <i class="nav-icon fa-sharp fa-solid fa-car" --}}
                                    {{-- style="font-size: 36px; vertical-align: middle; float: right; color: #12ACED;"></i> --}}
                                    <p style="font-size: 36px">22</p>
                                    <a href="#" class="small-box-footer" style="color: black;"></i></a>

                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
        </div>
        <!-- /.row -->
        <div id="map" style="height: 800px;">

            <>
                var pedagang = {!! $pedagang !!}

                var lokasi = pedagang.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name));
                // console.log(pedagang)

                var locations = L.layerGroup(lokasi);

                const map = L.map('map', {
                    center: [-5.3647543, 105.2723488],
                    zoom: 12,
                    layers: [locations]
                }); // Meningkatkan nilai zoom menjadi 14

                // L.popup({
                //     maxHeight: 6,
                //     offset: (0, 10),
                //     autoPan: false

                // })

                const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 16, // Anda bisa menyesuaikan maxZoom sesuai kebutuhan
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                var rute = []
                var popup = L.popup();


                let marker, circle, zoomed;
                options = {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 0,
                };


                navigator.geolocation.watchPosition(success, error, options);
                var greenIcon = L.icon({
                    iconUrl: 'images/mark.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });


                function success(pos) {

                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const accuracy = pos.coords.accuracy;

                    rute.push({
                        icon: greenIcon,
                        lat: lat,
                        lng: lng
                    })
                    L.marker({
                        lat: lat,
                        lng: lat
                    }).addTo(map);

                    if (marker) {
                        map.removeLayer(marker);
                        map.removeLayer(circle);
                    }
                    // marker.bindPopup(popupContent).openPopup();
                    // Removes any existing marker and circule (new ones about to be set)
                    marker = L.marker([lat, lng], {
                        icon: greenIcon
                    }).addTo(map);
                    circle = L.circle([lat, lng], {
                        radius: accuracy
                    }).addTo(map);
                    // Adds marker to the map and a circle for accuracy

                    // if (!zoomed) {
                    //     zoomed = map.fitBounds(circle.getBounds());
                    // }
                    // Set zoom to boundaries of accuracy circle
                    map.setView([lat, lng]);
                    // Set map focus to current user position
                    var lokasi = [lat, lng];
                    // console.log(lokasi);

                    // $.ajax({
                    //     type: "get",
                    //     url: "{{ route('updatelokasi') }}",
                    //     data: {
                    //         lokasi: JSON.stringify(lokasi)
                    //     },
                    //     success: function(response) {
                    //         console.log(response);
                    //     }
                    // });
                }

                function error(err) {

                    if (err.code === 1) {
                        alert("Please allow geolocation access");
                    } else {
                        alert("Cannot get current location");
                    }

                }
                map.on('click', function(e) {
                    L.marker(e.latlng).addTo(map);
                    rute.push(e.latlng);
                    console.log(rute);

                    L.Routing.control({
                        waypoints: rute,
                        icon: greenIcon
                    }).addTo(map);
                });
                // console.log(pedagang);
                function lokasimap() {

                    map.removeLayer(locations)
                    lokasi = pedagang.map((x) => L.marker(JSON.parse(x.lokasi)).bindPopup(x.name, {
                        maxHeight: 20,
                        autoPanPadding: (0, 0)
                    }));
                    // console.log(pedagang)

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
                            // console.log(pedagang);
                            // lokasi();
                            // console.log(response)
                        }
                    });
                }
                setInterval(function() {
                    updatelokasi();
                    lokasimap();
                }, 2000);
            </script>
        </div>
        <!-- /.container-fluid -->

        </section>
        <!-- /.content -->
    </div>
@endsection
