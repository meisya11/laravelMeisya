@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Profil</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action=""method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                      <!-- general form elements -->
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Form Edit Profile</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                          <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Admin</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="nama" value=""  placeholder="Masukkan Nama">
                              {{-- @error('nama')
                                 <small>{{ $message }}</small>
                              @enderror --}}
                           </div>
                           <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="Username" value=""  placeholder="Masukkan Username">
                            {{-- @error('nama')
                              <small>{{ $message }}</small>
                            @enderror --}}
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="" placeholder="Masukkan email">
                              {{-- @error('email')
                                <small>{{ $message }}</small>
                              @enderror --}}
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Nomor Telepon</label>
                              <input type="number" class="form-control" id="exampleInputEmail1" name="nama" value=""  placeholder="Masukkan Nomor Telepon">
                              {{-- @error('nama')
                                <small>{{ $message }}</small>
                              @enderror --}}
                              </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Password</label>
                              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder=" Masukkan Password">
                              {{-- @error('password')
                                <small>{{ $message }}</small>
                              @enderror --}}
                            </div>
                          </div>
                          <!-- /.card-body -->

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
