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
                                        var icons = document.getElementsByClassName('traffic-icon');
                                        for (var i = 0; i < icons.length; i++) {
                                            icons[i].classList.remove('selected');
                                        }
                                        selectedIcon.classList.add('selected');
                                    }
                                }
                                window.onload = function() {
                                    var selectedStatus = localStorage.getItem('selectedStatus');
                                    if (selectedStatus) {
                                        document.getElementById(selectedStatus).classList.add('selected');
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
        </div>

        <div id="map" style="height: 600px;">

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
