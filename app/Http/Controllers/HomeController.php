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

            // Menyesuaikan tampilan berdasarkan peran pengguna
            if ($role == 'admin') {
                $pedagang = User::where('role', 'pedagang')->get();
                return view('admin.dashboard', compact('pedagang'));
            } elseif ($role == 'pedagang') {

                $count = Route::where('users', auth()->id())->where('status', '!=', 'selesai')->count();
                $rute = Route::where('users', auth()->id())->where('status', '!=', 'selesai')->first();
                // dd($rute);
                return view('pedagang.dashboard', compact('count', 'rute'));
            } elseif ($role == 'pembeli') {

                $pedagang = User::where('role', 'pedagang')->get();

                return view('pembeli.dashboard', compact('pedagang'));
            } else {
                // Peran lainnya, Anda dapat menyesuaikan atau menangani kasus ini sesuai kebutuhan
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
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name'] = $request->nama;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role;
        User::create($data);

        return redirect()->route('admin.index');
    }

    public function editadmin(Request $request, $id)
    {
        $data = User::find($id);

        return view('admin.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required',
            'password' => 'nullable',
            'role' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name'] = $request->nama;
        $data['role'] = $request->role;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::whereId($id)->update($data);

        return redirect()->route('admin.index');
    }



    public function deleteadmin(Request $request, $id)
    {
        $data = User::find($id);

        if ($data) {
            $data->delete();
        }
        return redirect()->route('admin.index');
    }

    public function profiladmin()
    {
        $data = User::get();

        return view('admin.profil', compact('data'));
    }

    public function statusrute()
    {

        $data = Route::get();
        // $datapending = Route::with(['pedagang'])->where('approval',0)->get();
        // $dataapprove = Route::with(['pedagang'])->where('approval',1)->get();
        // $datareject = Route::with(['pedagang'])->where('approval',2)->get();

        return view('admin.statusrute', compact('data'));
    }
    public function riwayatadmin()
    {
        $data = Route::get();

        return view('admin.riwayatadmin', compact('data'));
    }

    public function approveUser($id)
    {
        // Logika untuk menyetujui akun
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
        // Logika untuk menolak akun
        $user = User::find($id);
        if ($user) {
            $user->status = 'rejected';
            $user->save();
            return response()->json(['message' => 'Akun ditolak.']);
        } else {
            return response()->json(['message' => 'Akun tidak ditemukan.'], 404);
        }
    }
}
