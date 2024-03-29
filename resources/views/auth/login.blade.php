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
    </head>

    <body>
        <div class="container py-5">
            <div class="w-50 center border rounded px-3 py-3 mx-auto">
                <h1>Login</h1>
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
                    <!-- Konten lainnya di dalam card -->
                    <div class="card-body">
                        <p class="mb-3 text-center">
                            <a href="{{ route('register') }}">Belum punya akun?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <script>
                Swal.fire('{{ $message }}');
            </script>
        @endif

        @if ($message = Session::get('failed'))
            <script>
                Swal.fire('{{ $message }}');
            </script>
        @endif
    </body>

    </html>

@endsection
