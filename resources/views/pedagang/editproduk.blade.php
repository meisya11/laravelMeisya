@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Produk</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Produk</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('updateproduk', $data->id) }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Edit Data Produk</h3>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Produk</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nama"
                                            value="{{ $data->nama }}"placeholder="Masukkan Nama Produk">
                                        @error('nama')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <label for="number">Masukkan Jumlah Produk:</label>
                                    <input type="number" id="number" class="form-control" name="jumlah"
                                        value="{{ $data->jumlah }}"required>
                                    {{-- <button type="button" onclick="add()">+</button>
                                        <button type="button" onclick="subtract()">-</button> --}}

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
                                            name="detail"value="{{ $data->detail }}" placeholder="Masukkan Detail Produk">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Harga Produk</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="harga"value="{{ $data->harga }}" placeholder="Masukkan Harga Produk">

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                </form>
            </div>
            <!-- /.card -->
    </div>
    <!-- /.card -->
    </div>
    <!--/.col (left) -->
    </div><!-- /.container-fluid -->
    </form>
    </section>
    </div>
@endsection
