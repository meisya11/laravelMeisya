@extends('auth.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Tambahkan ini di <head> atau sebelum tag penutup </body> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('awal') }}"><b>Gerobak Keliling</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Halaman Pendaftaran</p>
                    <form action="{{ route('register-proses') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Pengguna/Usaha"
                                value="{{ old('nama') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon"
                                value="{{ old('phone') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        @error('phone')
                            <small>{{ $message }}</small>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                        <div class="input-group mb-3">
                            <select class="custom-select" name="role">
                                <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                                <option value="pedagang" {{ old('role') == 'pedagang' ? 'selected' : '' }}>Pedagang
                                </option>
                            </select>

                            <div class="input-group-append">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <p class="mb-3 text-center">
                            <a href="{{ route('masuk') }}">Kembali</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- Bootstrap 4 -->
        <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
    </body>

    </html>
@endsection
