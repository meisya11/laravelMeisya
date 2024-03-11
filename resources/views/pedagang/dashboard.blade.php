@extends('layout.main')
@section('content')
    <style>
        .traffic-icon {
            color: gray;
            margin: 0 10px;
            cursor: pointer;
            /* Tambahkan kursor pointer untuk menandakan bahwa ikon dapat diklik */
        }

        .traffic-icon.selected {
            filter: grayscale(0%);
            /* Membuang efek abu-abu ketika ikon dipilih */
        }

        .traffic-icon:not(.selected) {
            filter: grayscale(100%);
            /* Mengubah warna ikon yang tidak dipilih menjadi abu-abu */
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="card" style="background-color: #12ACED;">
            <div class="content-header">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            @if ($count > 0)
                                <iconify-icon id="stopIcon" icon="openmoji:red-circle" width="48" height="48"
                                    class="traffic-icon {{ $rute->status == 'berhenti' ? 'selected' : '' }}"
                                    title="Berhenti" onclick="iconClicked('stopIcon')"></iconify-icon>
                                <iconify-icon id="breakIcon" icon="openmoji:yellow-circle" width="48" height="48"
                                    class="traffic-icon {{ $rute->status == 'istirahat' ? 'selected' : '' }}"
                                    title="Istirahat" onclick="iconClicked('breakIcon')"></iconify-icon>
                                <iconify-icon id="sellIcon" icon="openmoji:green-circle" width="48" height="48"
                                    class="traffic-icon {{ $rute->status == 'jalan' ? 'selected' : '' }}" title="Berjualan"
                                    onclick="iconClicked('sellIcon')"></iconify-icon>
                            @else
                                <b>Anda Belum Memiliki Rute yang Aktif</b>
                            @endif


                            <script>
                                // function iconClicked(iconId) {
                                //     // Reset warna semua ikon menjadi abu-abu
                                //     var icons = document.getElementsByClassName('traffic-icon');
                                //     for (var i = 0; i < icons.length; i++) {
                                //         icons[i].classList.remove('selected');
                                //     }

                                //     // Ubah warna ikon yang dipilih menjadi warna aslinya
                                //     var selectedIcon = document.getElementById(iconId);
                                //     selectedIcon.classList.add('selected');
                                // }

                                function iconClicked(iconId) {
                                    var selectedIcon = document.getElementById(iconId);
                                    var confirmationMessage = '';
                                    console.log(iconId)

                                    var status = '';
                                    switch (iconId) {
                                        case 'stopIcon':
                                            status = 'berhenti'
                                            confirmationMessage = 'Apakah Anda yakin ingin berhenti?';
                                            break;
                                        case 'breakIcon':
                                            status = 'istirahat'
                                            confirmationMessage = 'Apakah Anda yakin ingin istirahat?';
                                            break;
                                        case 'sellIcon':
                                            status = 'jalan'
                                            confirmationMessage = 'Apakah Anda yakin ingin berjualan?';
                                            break;
                                        default:
                                            status = 'selesai'
                                            confirmationMessage = 'Apakah Anda yakin?';
                                            break;
                                    }

                                    // Tampilkan pesan konfirmasi
                                    var isConfirmed = confirm(confirmationMessage);
                                    if (isConfirmed) {

                                        $.ajax({
                                            type: "GET",
                                            url: "{{ route('updatestatusrute', ['id'=>$rute->id]) }}",
                                            data: {
                                                status:status
                                            },
                                            success: function (response) {
                                            }
                                        });

                                        // Jika pengguna mengkonfirmasi, tambahkan kelas selected dan ubah warna ikon
                                        var icons = document.getElementsByClassName('traffic-icon');
                                        for (var i = 0; i < icons.length; i++) {
                                            icons[i].classList.remove('selected');
                                        }
                                        selectedIcon.classList.add('selected');
                                    }
                                }
                                // Set status yang dipilih saat halaman dimuat
                                window.onload = function() {
                                    var selectedStatus = localStorage.getItem('selectedStatus');
                                    if (selectedStatus) {
                                        document.getElementById(selectedStatus).classList.add('selected');
                                    }
                                }
                                // setInterval(submitRute, 1000);
                            </script>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
        </div>
        <!-- /.row -->
        <div id="map" style="height: 600px;">

            <script>
                const map = L.map('map');
                // Initializes map

                map.setView([51.505, -0.09], 13);
                // Sets initial coordinates and zoom level

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);
                // Sets map data source and associates with map

                let marker, circle, zoomed;
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
                    // Removes any existing marker and circule (new ones about to be set)

                    marker = L.marker([lat, lng]).addTo(map);
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
                    } else {
                        alert("Cannot get current location");
                    }

                }
            </script>
            {{-- <script>
                function updatelokasi(pos){

                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const accuracy = pos.coords.accuracy;

                    var lokasi = [lat, lng];
                    console.log(lokasi);
                }
                // setInterval(function () {navigator.geolocation.watchPosition(updatelokasi, error)}, 3000);
                navigator.geolocation.watchPosition(updatelokasi, error)

            </script> --}}
        </div>
        <!-- /.container-fluid -->

        </section>
        <!-- /.content -->
    </div>
@endsection
