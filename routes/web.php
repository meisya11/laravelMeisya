<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['admin']], function () {
    });
    Route::get('/rute', [PedagangController::class, 'rute'])->name('rute');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/detailpedagang/{id}', [HomeController::class, 'detailPedagang'])->name('detail-pedagang');


    Route::get('/statusrute', [HomeController::class, 'statusrute'])->name('statusrute');
    Route::get('/riwayatadmin', [HomeController::class, 'riwayatadmin'])->name('riwayatadmin');
    Route::get('/index', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('create');
    Route::post('/store', [HomeController::class, 'store'])->name('store');
    Route::get('/editadmin/{id}', [HomeController::class, 'editadmin'])->name('editadmin');
    Route::put('/updateadmin/{id}', [HomeController::class, 'updateadmin'])->name('updateadmin');
    Route::put('/updatestatusrute/{id}', [HomeController::class, 'deletestatusrute'])->name('deletestatusrute');
    Route::get('/upload', [PhotoController::class, 'upload1admin'])->name('upload');
    Route::post('/upload', [PhotoController::class, 'uploadadmin'])->name('upload');
    Route::delete('/delete/{id}', [HomeController::class, 'deleteadmin'])->name('deleteadmin');
    Route::get('/profileAdmin', [ProfileController::class, 'profileAdmin'])->name('profileAdmin');
    Route::get('/editProfileAdmin', [ProfileController::class, 'editProfileAdmin'])->name('editProfileAdmin');
    Route::put('/ProfileAdmin/{id}', [ProfileController::class, 'updateProfileAdmin'])->name('updateprofileadmin');
    // Endpoint untuk menyetujui akun
    Route::post('/approve-user/{user}', [HomeController::class, 'approveUser'])->name('approve-user');

    // Endpoint untuk menolak akun
    Route::post('/reject-user/{user}', [HomeController::class, 'rejectUser'])->name('reject-user');
    Route::post('/approve-rute/{user}', [RouteController::class, 'approveRoute'])->name('approve-route');

    // Endpoint untuk menolak akun
    Route::post('/reject-rute/{user}', [RouteController::class, 'rejectRoute'])->name('reject-route');

    Route::group(['middleware' => ['pembeli']], function () {
    });
    Route::get('/dashboardpembeli', [PembeliController::class, 'dashboardpembeli'])->name('dashboardpembeli');
    Route::get('/kelola', [PembeliController::class, 'kelola'])->name('kelola');
    Route::get('/editpembeli', [PembeliController::class, 'editpembeli'])->name('editpembeli');
    Route::put('/update', [PembeliController::class, 'update'])->name('update');
    Route::get('/profilpembeli', [PembeliController::class, 'profilpembeli'])->name('profilpembeli');
    Route::get('/locations', [HomeController::class, 'locations'])->name('locations');

    Route::group(['middleware' => ['pedagang']], function () {
    });
    Route::get('/dashboardpedagang', [PedagangController::class, 'dashboardpedagang'])->name('dashboardpedagang');
    Route::get('/riwayatpedagang', [PedagangController::class, 'riwayatpedagang'])->name('riwayatpedagang');
    // Route::get('/rute', [PedagangController::class, 'rute'])->name('rute');
    // Route::post('save-route', [PedagangController::class, 'save.route'])->name('save.route');
    Route::get('route', [PedagangController::class, 'route'])->name('route');
    Route::get('create', [PedagangController::class, 'create'])->name('create');
    Route::get('/upload', [PhotoController::class, 'upload1pedagang'])->name('upload');
    Route::post('/upload', [PhotoController::class, 'uploadpedagang'])->name('upload');
    Route::post('/store', [PedagangController::class, 'store'])->name('store');
    Route::get('/kelola', [PedagangController::class, 'kelola'])->name('kelola');
    Route::delete('/updateproduk/{id}', [ProductController::class, 'deleteproduk'])->name('deleteproduk');
    Route::post('/storeproduk', [ProductController::class, 'storeproduk'])->name('storeproduk');
    // Route::get('/createproduk', [ProductController::class, 'createproduk'])->name('createproduk');

    Route::post('/create_route', [RouteController::class, 'createroute'])->name('create_route');
    Route::put('/delete_route', [RouteController::class, 'deleteroute'])->name('delete_route');
    Route::get('/rute', [RouteController::class, 'index'])->name('rute');
    Route::get('/detailrute/{id}', [RouteController::class, 'detailrute'])->name('detailrute');
    Route::get('/profilePedagang', [ProfileController::class, 'profilePedagang'])->name('profilePedagang');
    Route::get('/editProfile', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::get('/editproduk', [ProductController::class, 'editproduk'])->name('editproduk');
    Route::put('/ProfilePedagang/{id}', [ProfileController::class, 'updatepedagang'])->name('updatepedagang');
    Route::get('/updatelokasi', [HomeController::class, 'updatelokasi'])->name('updatelokasi');
    Route::get('/updatestatusrute/{id}', [RouteController::class, 'updatestatusrute'])->name('updatestatusrute');
});
