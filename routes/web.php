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

Route::get('/', [LoginController::class, 'awal'])->name('awal');
Route::get('/masuk', [LoginController::class, 'masuk'])->name('masuk');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/detailpedagang/{id}', [HomeController::class, 'detailPedagang'])->name('detail-pedagang');

//ADMIN//

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['admin']], function () {
    });
    Route::get('/rute', [PedagangController::class, 'rute'])->name('rute');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/statusrute', [HomeController::class, 'statusrute'])->name('statusrute');
    Route::get('/riwayatadmin', [HomeController::class, 'riwayatadmin'])->name('riwayatadmin');
    Route::get('/index', [HomeController::class, 'index'])->name('index');
    // Route::get('/create', [HomeController::class, 'create'])->name('create');
    // Route::post('/store', [HomeController::class, 'store'])->name('store');
    Route::get('/editadmin/{id}', [HomeController::class, 'editadmin'])->name('editadmin');
    Route::put('/updateadmin/{id}', [HomeController::class, 'updateadmin'])->name('updateadmin');
    Route::put('/updatestatusrute/{id}', [HomeController::class, 'updatestatusrute'])->name('updatestatusrute');
    Route::delete('/delete/{id}', [HomeController::class, 'deleteadmin'])->name('deleteadmin');
    Route::get('/profileAdmin', [ProfileController::class, 'profileAdmin'])->name('profileAdmin');
    Route::get('/editprofiladmin/{id}', [ProfileController::class, 'editprofiladmin'])->name('editprofiladmin');
    Route::put('/updateprofiladmin/{id}', [ProfileController::class, 'updateProfileAdmin'])->name('updateprofileadmin');
    Route::post('/approve-user/{user}', [HomeController::class, 'approveUser'])->name('approve-user');
    Route::post('/reject-user/{user}', [HomeController::class, 'rejectUser'])->name('reject-user');
    Route::post('/approve-rute/{user}', [HomeController::class, 'approveRoute'])->name('approve-route');
    Route::post('/reject-rute/{user}', [HomeController::class, 'rejectRoute'])->name('reject-route');
    // Route::get('/locations', [HomeController::class, 'locations'])->name('locations');


    //PEMBELI//

    Route::group(['middleware' => ['pembeli']], function () {
    });
    Route::get('/dashboardpembeli', [PembeliController::class, 'dashboardpembeli'])->name('dashboardpembeli');
    Route::get('/profilePembeli', [ProfileController::class, 'profilePembeli'])->name('profilePembeli');
    Route::get('/editprofilpembeli/{id}', [ProfileController::class, 'editprofilpembeli'])->name('editprofilpembeli');
    Route::put('/updateProfilepembeli/{id}', [ProfileController::class, 'updateProfilepembeli'])->name('updateProfilepembeli');
    Route::get('/locations', [HomeController::class, 'locations'])->name('locations');
    Route::get('/rute', [PedagangController::class, 'rute'])->name('rute');


    //PEDAGANG//


    Route::group(['middleware' => ['pedagang']], function () {
    });
    Route::get('/dashboardpedagang', [PedagangController::class, 'dashboardpedagang'])->name('dashboardpedagang');
    Route::get('/riwayatpedagang', [PedagangController::class, 'riwayatpedagang'])->name('riwayatpedagang');

    Route::get('/route1', [PedagangController::class, 'route1'])->name('route1');
    Route::post('save-route', [PedagangController::class, 'save.route'])->name('save.route');
    Route::get('route', [PedagangController::class, 'route'])->name('route');
    Route::get('/kelola', [PedagangController::class, 'kelola'])->name('kelola');
    Route::put('/updateproduk/{id}', [ProductController::class, 'updateproduk'])->name('updateproduk');
    Route::post('/storeproduk', [ProductController::class, 'storeproduk'])->name('storeproduk');
    Route::get('/createproduk', [ProductController::class, 'createproduk'])->name('createproduk');
    Route::delete('/deleteproduk/{id}', [ProductController::class, 'deleteproduk'])->name('deleteproduk');
    Route::get('/editproduk/{id}', [ProductController::class, 'editproduk'])->name('editproduk');
    Route::post('/create_route', [RouteController::class, 'createroute'])->name('create_route');
    Route::post('/update_route/{id}', [RouteController::class, 'updateroute'])->name('update_route');
    Route::get('/rute', [RouteController::class, 'index'])->name('rute');
    Route::get('/detailrute/{id}', [RouteController::class, 'detailrute'])->name('detailrute');
    Route::get('/profilePedagang', [ProfileController::class, 'profilePedagang'])->name('profilePedagang');
    Route::get('/editprofilpedagang/{id}', [ProfileController::class, 'editprofilpedagang'])->name('editprofilpedagang');
    Route::put('/updateprofilepedagang/{id}', [ProfileController::class, 'updateprofilepedagang'])->name('updateprofilepedagang');
    Route::get('/updatelokasi', [HomeController::class, 'updatelokasi'])->name('updatelokasi');
    Route::get('/updatestatusrute/{id}', [RouteController::class, 'updatestatusrute'])->name('updatestatusrute');
});
