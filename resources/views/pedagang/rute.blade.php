@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="card" style="background-color: #12ACED;" height="2">
            <div class="content-header">

                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <button id="saveRoute">Simpan Rute</button>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
        </div>
        <!-- /.row -->

        <div id="map" style="height: 600px;">

            <script>
                const map = L.map('map').setView([-5.400219, 105.256424], 12); // Meningkatkan nilai zoom menjadi 14

                const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19, // Anda bisa menyesuaikan maxZoom sesuai kebutuhan
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                // Tambahkan marker ketika pengguna mengklik pada peta
                map.on('click', function(e) {
                    L.marker(e.latlng).addTo(map);
                });


                // Tambahkan control pencarian alamat
                L.Control.geocoder().addTo(map);

                map.on('geocoder/showlocation', function(e) {
                    L.marker(e.location).addTo(map);
                });

                var routingControl = L.Routing.control({
                    waypoints: [],
                    routeWhileDragging: true
                }).addTo(map);


                var control = L.Routing.control({
                    waypoints: [],
                    routeWhileDragging: true
                }).addTo(map);

                map.on('click', function(e) {
                    var waypoint = e.latlng;
                    control.spliceWaypoints(control.getWaypoints().length - 1, 1, waypoint);
                });

                document.getElementById('saveRoute').addEventListener('click', function() {
                    var waypoints = control.getWaypoints();
                    var routeData = {
                        waypoints: waypoints.map(function(waypoint) {
                            return {
                                latitude: waypoint.latLng.lat,
                                longitude: waypoint.latLng.lng
                            };
                        })
                    };

                    // Kirim data rute ke server untuk disimpan
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('save.route') }}", // Ganti dengan route yang sesuai di Laravel
                        data: routeData,
                        success: function(response) {
                            alert('Rute berhasil disimpan!');
                        },
                        error: function(xhr, status, error) {
                            alert('Gagal menyimpan rute. Silakan coba lagi.');
                        }
                    });
                });
                console.log('test');
            </script>
        </div>
        <!-- /.container-fluid -->

        </section>
        <!-- /.content -->
    </div>
@endsection
