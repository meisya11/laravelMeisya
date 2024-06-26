@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pesanan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Pesanan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('orderan') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="product">Pilih Produk</label>
                        <select name="product_id" id="product" class="form-control" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($user->product as $product)
                                <option value="{{ $product->id }}">{{ $product->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </form>
            </div>
        </section>
    </div>
@endsection
