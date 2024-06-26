@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profil Pedagang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <style>
            .btn.btn-primary {
                /* Atur padding sesuai kebutuhan */
                padding: 10px;
            }

            .fas.fa-pen {
                /* Atur padding sesuai kebutuhan */
                padding: 5px;
            }
        </style>
        <!-- Main content -->


        <section class="container mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Nama Usaha
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->user->name }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Email
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->user->email }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Nomor Telepon
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->user->phone }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Role
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->user->role }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Deskripsi Usaha
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->deskripsi }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Jam Operasional
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <p class="text-muted mb-0">
                                        {{ $profile->jam }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Sampai Jam
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->sampai }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Kategori Usaha
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ $profile->kategori }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <a href="{{ route('editprofilpedagang', ['id' => $profile->id]) }}" class="btn btn-primary">
                                <i class= "fas fa-pen"></i>Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            document.querySelector('.hBack').addEventListener('click', function(event) {
                event.preventDefault();
                window.history.back();
            });
        </script>
    </div>
@endsection
