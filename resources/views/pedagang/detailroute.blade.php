@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="row px-3">
            <div class="col-12">
                <button class="btn btn-success" type="button" id="done" onclick="doneRute()"> Selesaikan Rute</button>
                <div class="col-12">
                    <div id="map" style="height: 600px; weight:100%">
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

        function doneRute() {
            $.ajax({
                type: "PUT",
                url: "{{ route('delete_route') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    lokasi: JSON.stringify(rute)
                    // expiredate: $('#expiredate').val()
                },
                dataType: "JSON",
                success: function(response) {
                    window.location = "/route/" + response.id;

                }
            });
        }
    </script>
@stop

@endsection
