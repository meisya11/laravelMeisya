@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="row px-3">
            <div class="col-12">
                {{-- <div class="mb-3">
                    <label class="form-label" for="expiredate"> Waktu Akhir Rute</label>
                    <input type="datetime-local" class="form-control" name="expiredate" id="expiredate">
                </div> --}}

                <div class="col-12 float-end">
                    <button class="btn btn-success" type="button" id="saveRoute" onclick="submitRute()"> Simpan
                        Rute</button>
                    <button class="btn btn-success float-right" type="button" id="saveRoute" onclick="submitRute()"> Simpan
                        Rute</button>
                </div>


                <div class="col-12">
                    <div id="map" style="height: 800px; weight: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')

    <script>
        var map = L.map('map').setView([-5.400219, 105.256424], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var rute = [];
        let marker, zoomed;
        options = {
            enableHighAccuracy: false,
            timeout: 5000,
            maximumAge: 0,
        };
        navigator.geolocation.getCurrentPosition(success, error, options);

        function success(pos) {

            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;
            // console.log(lokasi);
            rute.push({
                lat: lat,
                lng: lng
            })
            L.marker({
                lat: lat,
                lng: lng
            }).addTo(map);
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
                waypoints: rute
            }).addTo(map);
        });

        function submitRute() {
            $.ajax({
                type: "POST",
                url: "{{ route('create_route') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    lokasi: JSON.stringify(rute),
                    expiredate: $('#expiredate').val()
                },
                dataType: "JSON",
                success: function(response) {
                    window.location = "/detailrute/" + response.id;

                }
            });
        }
        // Sets map data source and associates with map

        // let marker, circle, zoomed;

        // navigator.geolocation.watchPosition(success, error);

        // function success(pos) {

        //     const lat = pos.coords.latitude;
        //     const lng = pos.coords.longitude;
        //     const accuracy = pos.coords.accuracy;

        //     if (marker) {
        //         map.removeLayer(marker);
        //         map.removeLayer(circle);
        //     }
        //     // Removes any existing marker and circule (new ones about to be set)

        //     marker = L.marker([lat, lng]).addTo(map);
        //     circle = L.circle([lat, lng], {
        //         radius: accuracy
        //     }).addTo(map);
        //     // Adds marker to the map and a circle for accuracy

        //     if (!zoomed) {
        //         zoomed = map.fitBounds(circle.getBounds());
        //     }
        //     // Set zoom to boundaries of accuracy circle

        //     map.setView([lat, lng]);
        //     // Set map focus to current user position

        // }

        // function error(err) {

        //     if (err.code === 1) {
        //         alert("Please allow geolocation access");
        //     } else {
        //         alert("Cannot get current location");
        //     }

        // }
        // setInterval(submitRute, 1000);
    </script>
@stop

@endsection
