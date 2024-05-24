@extends('auth.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <title>Login</title>

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
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Halaman Login</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login-proses') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3 d-grid">
                            <button name="submit" type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-3 text-center">
                                <a href="{{ route('register') }}">Belum punya akun?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </body>

    </html>
@endsection
