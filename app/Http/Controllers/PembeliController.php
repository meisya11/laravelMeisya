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
            if ($role == 'admin') {$pedagang = User::where('role', 'pedagang')->whereNotNull('lokasi')->get();
                $rute = Route::get();
                return view('admin.dashboard', compact('pedagang', 'rute'));
            } elseif ($role == 'pedagang') {
                return view('pedagang.dashboard');
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
