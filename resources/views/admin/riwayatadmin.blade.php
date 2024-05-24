@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelola Riwayat</h1>
                    </div><!-- /.col -->
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
                            <div class="card-header">
                                <h3 class="card-title">Rute Selesai</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Rute Dipilih</th>
                                            <th>Tanggal</th>
                                            <th>Persetujuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $d->name }}</td>
                                                    <td>
                                                        <a href="{{ route('detailrute', ['id' => $d->id]) }}"
                                                            class="btn btn-info"><i class="fas fa-map-marker-alt"></i>
                                                            Peta</a>
                                                    </td>
                                                    <td>{{ $d->created_at }}</td>
                                                    <td>{{ $d->approval }}</td>
                                                </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
