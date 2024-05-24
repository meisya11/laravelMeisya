@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Header Konten (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Status Rute</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Status Rute</li>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Rute Berjalan</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>User</th>
                                                    <th>Rute Dipilih</th>
                                                    <th>Status Rute</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $d)
                                                    @if ($d->approval == 'approve')
                                                        <tr>
                                                            <td>{{ $d->id }}</td>
                                                            <td>{{ $d->name }}</td>
                                                            <td>
                                                                <a href="{{ route('detailrute', ['id' => $d->id]) }}"
                                                                    class="btn btn-info"><i
                                                                        class="fas fa-map-marker-alt"></i> Peta</a>
                                                            </td>
                                                            <td>{{ $d->approval }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Rute Diajukan</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>User</th>
                                                    <th>Rute Dipilih</th>
                                                    <th>Status Rute</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $d)
                                                    @if ($d->approval == 'pending')
                                                        <tr>
                                                            <td>{{ $d->id }}</td>
                                                            <td>{{ $d->name }}</td>
                                                            <td>
                                                                <a href="{{ route('detailrute', ['id' => $d->id]) }}"
                                                                    class="btn btn-info"><i
                                                                        class="fas fa-map-marker-alt"></i> Peta</a>
                                                            </td>
                                                            <td>{{ $d->approval }}</td>
                                                            <td>
                                                                <button class="btn btn-light"
                                                                    onclick="confirmApproval('{{ $d->id }}')"> ✅</button>
                                                                <button class="btn btn-light"
                                                                    onclick="confirmRejection('{{ $d->id }}')">❌</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<script>
    function confirmApproval(userId) {
        if (confirm("Anda yakin ingin menyetujui rute ini?")) {
            approveRoute(userId);
        } else {
            alert("Persetujuan dibatalkan.");
        }
    }

    function confirmRejection(userId) {
        if (confirm("Anda yakin ingin menolak rute ini?")) {
            rejectRoute(userId);
        } else {
            alert("Penolakan dibatalkan.");
        }
    }

    function approveRoute(userId) {
        $.ajax({
            type: "POST",
            url: '/approve-rute/' + userId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                alert(data.message);
                window.location.reload();
            },
            error: function(error) {
                console.log(error);
                alert("Terjadi kesalahan saat menyetujui rute.");
            }
        });
    }

    function rejectRoute(userId) {
        $.ajax({
            type: "POST",
            url: '/reject-rute/' + userId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                alert(data.message);
                window.location.reload();
            },
            error: function(error) {
                console.log(error);
                alert("Terjadi kesalahan saat menolak rute.");
            }
        });
    }
</script>
