<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    function index()
    {
        return view('pedagang.route');

    }
    function create(Request $request)
    {

        $data = [
            'lokasi' => $request->lokasi,
            'expiredate' => $request->expiredate,
            'users' => auth()->id(),
            'status' => 'jalan'
        ];

        $saveid = Route::create($data);

        if ($saveid) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Rute berhasil ditambahkan!',
                'id'        => $saveid->id,
            ]);
        }
        ;
        // dd($request->all());
    }
    public function updatestatusrute(Request $request, $id){
        $rute = Route::find($id);
        $rute->status=$request->status;
        $rute->save();
    }
    // public function rute_proses(Request $request)
    // {

    //     $data = [
    //         'lokasi' => $request->lokasi,
    //         'expiredate' => $request->expiredate,
    //         'users' => auth()->id(),
    //         'status' => 'jalan'
    //     ];
    //     if (Route::attempt($data)) {
    //         // Jika berhasil login, cek status dan peran (role) pengguna
    //         $saveid = Route::create();

    //         if ($data->status == 'approved') {
    //                 return redirect()->route('dashboard');
    //             } elseif ($user->role == 'pedagang' || $user->role == 'pembeli') {
    //                 return redirect()->route('dashboard');
    //             }
    //         } elseif ($user->status == 'pending') {
    //             // Jika status akun tidak diapproved, logout dan kembali ke halaman login
    //             Auth::logout();
    //             return redirect()->route('login')->with('failed', 'Akun Anda belum diapproved oleh admin.');
    //         }else{
    //             Auth::logout();
    //             return redirect()->route('login')->with('failed', 'Akun Anda ditolak. Silakan register ulang!');
    //         }
    //     }
    //     return redirect()->route('login')->with('failed', 'Email atau Password Salah');

    function detailrute($id){
        $rute = Route::find($id);

        return view ('pedagang.detailroute', compact('rute'));
    }

    function approveRoute($id){
        $rute = Route::find($id);
        if ($rute) {
            $rute->approval  = 'approve';
            $rute->save();
            return response()->json(['message' => 'Akun disetujui.']);
        } else {
            return response()->json(['message' => 'Akun tidak ditemukan.'], 404);
        }
    }
    function rejectRoute($id){
        $rute = Route::find($id);
        if ($rute) {
            $rute->approval = 'reject';
            $rute->save();
            return response()->json(['message' => 'Akun disetujui.']);
        } else {
            return response()->json(['message' => 'Akun tidak ditemukan.'], 404);
        }
    }

}
