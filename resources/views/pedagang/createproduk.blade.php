@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Informasi Produk</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Data Produk</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('storeproduk') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Data Produk</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Produk</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="nama"placeholder="Masukkan Nama Produk">
                                        @error('nama')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <label for="number">Jumlah Produk</label>
                                    <input type="number" id="number" class="form-control"
                                        placeholder="Masukkan Jumlah Produk" name="jumlah" required>
                                    <script>
                                        function add() {
                                            var numberInput = document.getElementById("number");
                                            var currentValue = parseInt(numberInput.value) || 0;
                                            numberInput.value = currentValue + 1;
                                        }

                                        function subtract() {
                                            var numberInput = document.getElementById("number");
                                            var currentValue = parseInt(numberInput.value) || 0;
                                            numberInput.value = currentValue - 1;
                                        }
                                    </script>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Detail Produk</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="detail"placeholder="Masukkan Detail Produk">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Harga Produk</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="harga"placeholder="Masukkan Harga Produk">
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
