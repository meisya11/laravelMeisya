<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GO-LING | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav d-flex"">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                @if (Auth::user()->role == 'admin')
                    <li class="user-panel d-flex">
                        <div class="image">
                            <a href="{{ route('profileAdmin') }}">
                                <!-- Ganti 'route('profile')' dengan route yang sesuai -->
                                <img src="{{ asset('images/golinglogo.png') }}"
                                    class="brand-image img-circle elevation-3" style="opacity: .8">
                            @elseif (Auth::user()->role == 'pedagang')
                    <li class="user-panel d-flex">
                        <div class="image">
                            <a href="{{ route('profilePedagang') }}">
                                <!-- Ganti 'route('profile')' dengan route yang sesuai -->
                                <img src="{{ asset('images/golinglogo.png') }}"
                                    class="brand-image img-circle elevation-3" style="opacity: .8">
                            @elseif (Auth::user()->role == 'pembeli')
                    <li class="user-panel d-flex">
                        <div class="image">
                            <a href="{{ route('profilePembeli') }}">
                            <img src="{{ asset('images/golinglogo.png') }}" class="brand-image img-circle elevation-3"
                                style="opacity: .8">
                            </a>
                        </div>
                @endif
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard" class="brand-link">
                <img src="{{ asset('images/golinglogo.png') }}" alt="GO-LING"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><b>GEROBAK KELILING</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                @if (Auth::user()->role == 'admin')
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <iconify-icon icon="pepicons-pop:house"></iconify-icon>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('index') }}" class="nav-link">
                                    <iconify-icon icon="pajamas:account"></iconify-icon>
                                    <p>
                                        Kelola Akun
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('statusrute') }}" class="nav-link">
                                    <iconify-icon icon="mdi:location"></iconify-icon>
                                    <p>Status Rute</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('riwayatadmin') }}" class="nav-link">
                                    <iconify-icon icon="tabler:checkup-list"></iconify-icon>
                                    <p>Riwayat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ 'logout' }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @elseif (Auth::user()->role == 'pedagang')
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <iconify-icon icon="pepicons-pop:house"></iconify-icon>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kelola') }}" class="nav-link">
                                    <iconify-icon icon="mdi:location"></iconify-icon>
                                    <p>Informasi Produk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rute') }}" class="nav-link">
                                    <iconify-icon icon="tabler:checkup-list"></iconify-icon>
                                    <p>Rute</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('riwayatpedagang') }}" class="nav-link">
                                    <iconify-icon icon="tabler:checkup-list"></iconify-icon>
                                    <p>Riwayat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @elseif (Auth::user()->role == 'pembeli')
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <iconify-icon icon="pepicons-pop:house"></iconify-icon>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('kelola') }}" class="nav-link">
                                    <iconify-icon icon="mdi:location"></iconify-icon>
                                    <p>Kelola Akun</p>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a href="{{ route('riwayatpembeli') }}" class="nav-link">
                                    <iconify-icon icon="tabler:checkup-list"></iconify-icon>
                                    <p>Riwayat Pencarian</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        {{-- <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer> --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('lte/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @yield('js')
</body>

</html>
