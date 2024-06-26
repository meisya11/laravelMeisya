@extends('layout.main')
@section('content')
    <div class="modal fade" id="detailPedagang" tabindex="-1" aria-labelledby="detailPedagangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="detailPedagangBody">
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelola Riwayat </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Riwayat</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id Pesanan</th>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Produk </th>
                                            <th>Detail Produk</th>
                                            <th>Waktu Antar</th>
                                            <th>Alamat Antar</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Status Pesanan</th>
                                            <th>Pedagang</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $d->id }}</td>
                                                <td>{{ $loop->iteration }}</td>
                                                @foreach ($d->detail as $detail)
                                                    <td>{{ $detail->order_name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ $detail->detail_order }}</td>
                                                @endforeach
                                                <td>{{ $d->order_time }}</td>
                                                <td>{{ $d->alamat }}</td>
                                                <td>{{ $d->created_at }}</td>
                                                <td>{{ $d->status }}</td>
                                                @if ($d->status == 'waiting')
                                                    {
                                                    <td>-</td>
                                                    }
                                                @else{
                                                    <td><button class="btn btn-info"
                                                            onclick="showDetail('{{ $d->pedagang_id }}')">{{ $d->pesananpedagang->name }}</button>
                                                    </td>
                                                    }
                                                @endif
                                                <td>
                                                    <a href="{{ route('detailantar', ['id' => $d->id]) }}"
                                                        class="btn btn-info"><i class="fas fa-map-marker-alt"></i>
                                                        Peta</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script>
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
