@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tambah Produk Pesanan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Produk Pesanan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('simpanpesanan') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="order-items">
                        <div class="order-item">
                            <label for="order_name[]">Nama Pesanan:</label>
                            <input type="text" name="order_name[]" required>
                            <label for="quantity[]">Jumlah:</label>
                            <input type="number" name="quantity[]" required>
                            <label for="detail_order[]">Detail Pesanan:</label>
                            <input type="text" name="detail_order[]" required>
                            <button type="button" class="remove-order-item">Hapus</button>
                        </div>
                    </div>
                    <button type="button" id="add-order-item">Tambah Jenis Pesanan</button>
                    <br><br>
                    <div class="form-group">
                        <label for="alamat">Detail Alamat</label>
                        <input type="text" class="form-control" id="alamat"
                            name="alamat"placeholder="Masukkan Detail Alamat">
                    </div>
                    <div class="form-group">
                        <label for="order_time">Waktu Pengantara</label>
                        <input type="datetime-local" class="form-control" id="order_time"
                            name="order_time"placeholder="Masukkan Waktu Pengantaran">
                    </div>
                    <input type="hidden" name="lokasi" id="lokasi">
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </form>
            </div>
        </section>
        <div class="col-12">
            <div id="map" style="height: 480px; width: 100%;"></div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Menambahkan item pesanan baru
            $('#add-order-item').click(function() {
                $('#order-items').append(
                    '<div class="order-item">' +
                    '<label for="order_name[]">Nama Pesanan: </label>' +
                    '<input type="text" name="order_name[]" required>' +
                    '<label for="quantity[]">Jumlah: </label>' +
                    '<input type="number" name="quantity[]" required>' +
                    '<label for="detail_order[]">Detail Pesanan: </label>' +
                    '<input type="text" name="detail_order[]" required>' +
                    '<button type="button" class="remove-order-item">Hapus</button>' +
                    '</div>'
                );
            });
            $(document).on('click', '.remove-order-item', function() {
                $(this).closest('.order-item').remove();
            });

            var map = L.map('map').setView([-5.400219, 105.256424], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            let marker;
            let lat, lng;
            const options = {
                enableHighAccuracy: false,
                timeout: 5000,
                maximumAge: 0
            };

            navigator.geolocation.getCurrentPosition(success, error, options);

            function success(pos) {
                lat = pos.coords.latitude;
                lng = pos.coords.longitude;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                map.setView([lat, lng]);

                marker.on('dragend', function(event) {
                    var marker = event.target;
                    var position = marker.getLatLng();
                    lat = position.lat;
                    lng = position.lng;
                    marker.setLatLng(new L.LatLng(position.lat, position.lng), {
                        draggable: true
                    }).bindPopup(position.toString()).update();
                });

                const position = {
                    lat: lat,
                    lng: lng
                };
                $('#lokasi').val(JSON.stringify(position));
            }

            function error(err) {
                if (err.code === 1) {
                    alert("Hidupkan Akses Lokasi");
                } else {
                    alert("Tidak Bisa Mendapat Lokasi Terkini");
                }
            }

            // $('#order-form').submit(function(event) {
            //     event.preventDefault();

            //


            // const formData = $(this).serialize();

        });
    </script>
@endsection
