@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{-- <a href="{{ route('create')}}" class="btn btn-primary mb-3">Tambah Data</a> --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rute Berjalan</h3>

                                {{-- <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Rute Dipilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pedagang as $d)
                                        @if ($d->approval == 'approve')
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->id }}</td>
                                                <td>{{ $d->name}}</td>
                                                <td>{{ $d->role }}</td>
                                                <td>{{ $d->status }}</td>
                                                <td>
                                                    <a href="{{ route('detailrute', ['id' => $d->id]) }}"
                                                        class="btn btn-info"><i class="fas fa-map-marker-alt"></i>
                                                        Peta</a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Default Modal</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus data user
                                                                <b>{{ $d->name }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form action="{{ route('delete', ['id' => $d->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Ya,
                                                                    Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            @endif
                                            <!-- /.modal -->
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rute Diajukan</h3>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Rute Dipilih</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedagang as $d)
                                                @if ($d->approval == 'pending')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->name }}</td>
                                                        <td>{{ $d->role }}</td>
                                                        <td>{{ $d->status }}</td>
                                                        <td>
                                                            <a href="{{ route('detailrute', ['id' => $d->id]) }}"
                                                                class="btn btn-info"><i class="fas fa-map-marker-alt"></i>
                                                                Peta</a>
                                                        </td>
                                                        <td>

                                                            <button class="btn btn-success ml-1"
                                                                onclick="confirmApproval('{{ $d->id }}')">
                                                                Setuju
                                                            </button>
                                                            <button class="btn btn-danger ml-1"
                                                                onclick="confirmRejection('{{ $d->id }}')">
                                                                Tolak
                                                            </button>

                                                        </td>
                                                    </tr>
                                                @endif
                                                {{-- <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Default Modal</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menghapus data user
                                                                    <b>{{ $d->name }}</b>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <form action="{{ route('deletestatusrute', ['id' => $d->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Ya,
                                                                        Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div> --}}
                                                <!-- /.modal -->
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<script>
    function updateStatus(id, approval) {
        // Menetapkan nilai status ke elemen input pada formulir
        document.querySelector(`#statusForm${id} select[name="approval"]`).value = approval;

        // Mengirim formulir secara otomatis
        document.querySelector(`#statusForm${id}`).submit();
    }
</script>

<script>
    function confirmApproval(userId) {
        if (confirm("Anda yakin ingin menyetujui akun ini?")) {
            approveRoute(userId);
        } else {
            alert("Persetujuan dibatalkan.");
        }
    }

    function confirmRejection(userId) {
        if (confirm("Anda yakin ingin menolak akun ini?")) {
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
                alert("Terjadi kesalahan saat menyetujui akun.");
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
                alert("Terjadi kesalahan saat menolak akun.");
            }
        });
    }
</script>
