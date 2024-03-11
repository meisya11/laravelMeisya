<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
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
                    return redirect()->route('dashboard');
                } elseif ($user->role == 'pedagang') {
                    return redirect()->route('dashboardpedagang');
                }elseif ($user->role =='pembeli'){
                    return redirect()->route('dashboardpembeli');
                }
            } elseif ($user->status == 'pending') {
                // Jika status akun tidak diapproved, logout dan kembali ke halaman login
                Auth::logout();
                return redirect()->route('login')->with('failed', 'Akun Anda belum diapproved oleh admin.');
            }else{
                Auth::logout();
                return redirect()->route('login')->with('failed', 'Akun Anda ditolak. Silakan register ulang!');
            }
        }
        return redirect()->route('login')->with('failed', 'Email atau Password Salah');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('succes', ' kamu berhasil logout');
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
            return redirect()->route('login')->with('success', 'Registrasi berhasil. Menunggu persetujuan admin.');
        } else {
            return redirect()->route('login')->with('failed', 'Registrasi Gagal');
        }
    }

}
