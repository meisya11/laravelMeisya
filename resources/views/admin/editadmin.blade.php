@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Admin</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('updateadmin',['id' => $data->id]) }}"method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Form Edit ADMIN</h3>
                        </div>
                        <form>
                          <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengguna</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="nama" value="{{ $data->name}}"  placeholder="">
                              @error('name')
                                 <small>{{ $message }}</small>
                              @enderror
                           </div>
                           <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="Username" value="{{ $data->email}}"  placeholder="">
                            @error('email')
                              <small>{{ $message }}</small>
                            @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Nomor Telepon</label>
                              <input type="phone" class="form-control" id="exampleInputEmail1" name="phone" value="{{ $data->phone}}" placeholder="">
                              @error('phone')
                                <small>{{ $message }}</small>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Password</label>
                              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder=" Masukkan Password">
                              @error('password')
                                <small>{{ $message }}</small>
                              @enderror
                            </div>
                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div><!-- /.container-fluid -->
            </form>
      </section>
  </div>

@endsection
