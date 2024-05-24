@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="row px-3">
            <div class="col-12">
                <nav class="navbar bg-body-tertiary">
                    <h5>{{ $rute->approval }}</h5>
                    @if (Auth::user()->role == 'pedagang' && $rute->approval == 'approve')
                        <button class="btn btn-success" type="button" id="done" onclick="doneRute()"> Selesaikan
                            Rute</button>
                    @endif
                </nav>

                <div class="col-12">
                    <div id="map" style="height: 800px; weight:100%">
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

        var rute = @json($rute->lokasi);

        L.Routing.control({
            waypoints: JSON.parse(rute)
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
        }

        function doneRute() {
            $.ajax({
                type: "POST",
                url: "{{ route('update_route', ['id' => $rute->id]) }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    lokasi: JSON.stringify(rute)
                    // expiredate: $('#expiredate').val()
                },
                dataType: "JSON",
                success: function(response) {
                    window.location = "/route1/";

                }
            });
        }
    </script>
@stop

@endsection
