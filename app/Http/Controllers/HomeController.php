<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\User;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'admin') {
                $pedagang = User::where('role', 'pedagang')->get();
                $rute = Route::where('status', '!=', 'selesai')->get();

                return view('admin.dashboard', compact('pedagang', 'rute'));
            } elseif ($role == 'pedagang') {

                $count = Route::where('users', auth()->id())->where('status', '!=', 'selesai')->count();
                $rute = Route::where('users', auth()->id())->where('status', '!=', 'selesai')->first();
                return view('pedagang.dashboard', compact('count', 'rute'));
            } elseif ($role == 'pembeli') {

                $pedagang = User::where('role', 'pedagang')->get();

                return view('pembeli.dashboard', compact('pedagang'));
            } else {
                return view('dashboard');
            }
        }

        // Jika tidak terotentikasi, mungkin Anda ingin menangani sesuatu di sini, seperti menampilkan halaman login.
        return redirect('/login');
    }

    public function updatelokasi(Request $request)
    {

        $id = Auth::id();

        $lokasi = $request->lokasi;

        $user = User::find($id);
        $user->lokasi = $lokasi;
        $user->save();

        return response()->json(['message' => 'data diterima', 'lokasi' => $request->lokasi]);
    }
    public function locations()
    {

        $pedagang = User::where('role', 'pedagang')->get();
        return response()->json($pedagang);
    }


    public function index()
    {

        $data = User::get();

        return view('admin.index', compact('data'));
    }

    public function deleteadmin(Request $request, $id)
    {
        $data = User::find($id);

        if ($data) {
            $data->delete();
        }
        return redirect()->route('index');
    }
    public function editadmin(Request $request, $id)
    {
        $data = User::find($id);

        return view('admin.editadmin', compact('data'));
    }

    public function updateadmin(Request $request, User $user)
    {
        // dd($request->all());
        $user->update($request->all());
        return redirect()->route('index')->with('success', 'Data pengguna diperbarui.');
    }

    public function profiladmin()
    {
        $data = User::get();

        return view('admin.profil', compact('data'));
    }

    public function statusrute()
    {

        $data = Route::get();
        return view('admin.statusrute', compact('data'));
    }

    public function deletestatusrute(Request $request, $id)
    {
        $pedagang = User::find($id);

        if ($pedagang) {
            $pedagang->delete();
        }
        return redirect()->route('index');
    }
    public function riwayatadmin()
    {
        $data = Route::get();

        return view('admin.riwayatadmin', compact('data'));
    }

    public function approveUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 'approved';
            $user->save();
            return response()->json(['message' => 'Akun disetujui.']);
        } else {
            return response()->json(['message' => 'Akun tidak ditemukan.'], 404);
        }
    }

    public function rejectUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 'rejected';
            $user->save();
            return response()->json(['message' => 'Akun ditolak.']);
        } else {
            return response()->json(['message' => 'Akun tidak ditemukan.'], 404);
        }
    }
    public function detailPedagang($id)
    {
        $user = User::find($id);

        return view('component.detail_pedagang', compact('user'));
    }
}
