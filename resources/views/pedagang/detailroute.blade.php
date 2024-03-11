@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="row px-3">
            <div class="col-4 my-auto">
                <h6>Waktu Akhir Rute</h6>
                <h4>{{ date('d F Y h:i', strtotime($rute->expiredate)) }}</h4>
            </div>

            <div class="col-8">
                <div id="map" style="height: 600px; weight: 100%;">
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

    </script>
@stop

@endsection
