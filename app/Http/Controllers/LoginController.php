<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Route;

class LoginController extends Controller
{


    public function masuk()
    {
        return view('auth.login');
    }
    public function awal()
    {
        $pedagang = User::where('role', 'pedagang')->get();
        $rute = Route::get();
        return view('auth.awal', compact('pedagang', 'rute'));
    }
    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($data)) {
            // Jika berhasil login, cek status dan peran (role) pengguna
            $user = Auth::user();

            if ($user->status == 'approved') {
                // Jika status akun adalah 'approved'
                if ($user->role == 'admin') {

                    $pedagang = User::where('role', 'pedagang')->get();
                    $rute = Route::get();
                    $count = User::where('id')->count();

                    return redirect()->route('dashboard', compact('pedagang', 'rute', 'count'));
                } elseif ($user->role == 'pedagang') {


                    // $rute = Route::where('users', auth()->id())->where('status', '!=', 'selesai')->first();
                    return redirect()->route('dashboardpedagang');

                } elseif ($user->role == 'pembeli') {

                    $pedagang = User::where('role', 'pedagang')->get();
                    $rute = Route::get();
                    return redirect()->route('dashboardpembeli', compact('pedagang', 'rute'));
                }
            } elseif ($user->status == 'pending') {
                // Jika status akun tidak diapproved, logout dan kembali ke halaman login
                Auth::logout();
                return redirect()->route('masuk')->with('failed', 'Akun Anda belum diapproved oleh admin.');
            } else {
                Auth::logout();
                return redirect()->route('masuk')->with('failed', 'Akun Anda ditolak. Silakan register ulang!');
            }
        }
        return redirect()->route('masuk')->with('failed', 'Email atau Password Salah');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('masuk')->with('succes', ' kamu berhasil logout');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:10',
            'password' => 'required|min:6',
            'role' => 'required|in:pembeli,pedagang'
        ]);

        $data['name'] = $request->nama;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['password'] = Hash::make($request->password);
        $data['status'] = 'pending';
        $data['role'] = $request->role;
        $user = User::create($data);

        if ($user) {
            return redirect()->route('masuk')->with('success', 'Registrasi berhasil. Menunggu persetujuan admin.');
        } else {
            return redirect()->route('masuk')->with('failed', 'Registrasi Gagal');
        }
    }

}
