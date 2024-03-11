<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;


class PembeliController extends Controller
{
    public function dashboardpembeli()
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


    public function create()
    {
        return view('create');
    }

    public function editpembeli(Request $request, $id)
    {
        $data = User::find($id);

        return view('pembeli.edit', compact('data'));
    }
    public function profilpembeli()
    {
        $data = User::get();
        return view('pembeli.profil', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required',
            'password' => 'nullable',
            'phone' => 'required|min:10',
            'role' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name'] = $request->nama;
        $data['role'] = $request->role;
        $data['phone'] = $request->phone;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::whereId($id)->update($data);

        return redirect()->route('pembeli.kelola');
    }

    public function kelola()
    {

        return view('pembeli.kelola');
    }
}
