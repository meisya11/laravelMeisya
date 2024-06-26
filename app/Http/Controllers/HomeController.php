<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Profile;
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
                $pedagang = User::where('role', 'pedagang')->whereNotNull('lokasi')->get();
                $rute = Route::get();
                return view('admin.dashboard', compact('pedagang', 'rute'));
            } elseif ($role == 'pedagang') {
                $pembeli = User::where('role', 'pembeli')->whereNotNull('lokasi')->get();
                $pesanan = Pesanan::with('detail')->where('status', 'waiting')->get();

                return view('pedagang.dashboard', compact('pembeli', 'pesanan'));
            } elseif ($role == 'pembeli') {

                $pedagang = User::where('role', 'pedagang')->whereNotNull('lokasi')->get();
                $rute = Route::get();

                return view('pembeli.dashboard', compact('pedagang', 'rute'));
            } else {
                return view('dashboard');
            }
        }
        return redirect('/masuk');
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

    public function updateadmin(Request $request, $id)
    {

        $data = User::where('id', $id)->firstOrFail();

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|min:6',

        ]);
        $data->update($request->all());
        return redirect()->route('index')->with('success', 'Data pengguna diperbarui.');
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
        $profile = Profile::find($id);
        $data = Route::get();

        return view('component.detail_pedagang', compact('user', 'profile', 'data'));
    }
    function approveRoute($id)
    {
        $rute = Route::find($id);
        if ($rute) {
            $rute->approval = 'approve';
            $rute->save();
            return response()->json(['message' => 'Rute disetujui.']);
        } else {
            return response()->json(['message' => 'Rute tidak ditemukan.'], 404);
        }
    }
    function rejectRoute($id)
    {
        $rute = Route::find($id);
        if ($rute) {
            $rute->approval = 'reject';
            $rute->save();
            return response()->json(['message' => 'Rute disetujui.']);
        } else {
            return response()->json(['message' => 'Rute tidak ditemukan.'], 404);
        }
    }

}
