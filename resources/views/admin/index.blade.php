@extends('layout.main')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelola Data Akun</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Akun</li>
                        </ol>
                    </div>
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
                                        <h3 class="card-title">Data Akun Aktif</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->name }}</td>
                                                        <td>{{ $d->email }}</td>
                                                        <td>{{ $d->status }}</td>
                                                        <td>
                                                            <a href="{{ route('editadmin', ['id' => $d->id]) }}"
                                                                class="btn btn-primary"><i class= "fas fa-pen"></i></a>
                                                            <a data-toggle="modal"
                                                                data-target="#modal-hapus{{ $d->id }}"
                                                                class="btn btn-danger"><i
                                                                    class= "fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Konfirmasi Hapus</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus data user
                                                                        <b>{{ $d->name }}</b>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <form
                                                                        action="{{ route('deleteadmin', ['id' => $d->id]) }}"
                                                                        method="POST"> @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary">Ya,
                                                                            Hapus</button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Persetujuan Akun</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $user)
                                                    @if ($user->status == 'pending')
                                                        <tr>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->role }}</td>
                                                            <td>
                                                                @if ($user->status == 'pending')
                                                                    <button class="btn btn-light"
                                                                        onclick="confirmApproval('{{ $user->id }}')">
                                                                        ✅
                                                                    </button>
                                                                    <button class="btn btn-light"
                                                                        onclick="confirmRejection('{{ $user->id }}')">
                                                                        ❌
                                                                    </button>
                                                                @endif
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
    </div>
@endsection
<script>
    function updateStatus(id, status) {
        document.querySelector(`#statusForm${id} select[name="status"]`).value = status;

        document.querySelector(`#statusForm${id}`).submit();
    }

    function confirmApproval(userId) {
        if (confirm("Anda yakin ingin menyetujui akun ini?")) {
            approveUser(userId);
        } else {
            alert("Persetujuan dibatalkan.");
        }
    }

    function confirmRejection(userId) {
        if (confirm("Anda yakin ingin menolak akun ini?")) {
            rejectUser(userId);
        } else {
            alert("Penolakan dibatalkan.");
        }
    }

    function approveUser(userId) {
        $.ajax({
            type: "POST",
            url: '/approve-user/' + userId,
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

    function rejectUser(userId) {
        $.ajax({
            type: "POST",
            url: '/reject-user/' + userId,
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

