<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;
use App\Models\Product;
use Carbon\Carbon;

class PedagangController extends Controller
{
    public function dashboardpedagang()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role == 'admin') {
                $pedagang = User::where('role', 'pedagang')->whereNotNull('lokasi')->get();
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

    public function storerute(Request $request)
    {
        $route = new Route();
        $route->latitude = $request->latitude;
        $route->longitude = $request->longitude;
        // tambahkan data tambahan jika diperlukan
        $route->save();

        return response()->json(['message' => 'Data rute berhasil disimpan'], 200);
    }

    public function route1()
    {
        return view('pedagang.route');
    }
    public function route()
    {
        $routes = Route::all();
        return response()->json($routes);
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

        return redirect()->route('pedagang.kelola');
    }


    public function riwayatpedagang()
    {
        $data = Route::where('users', auth()->id())->get();
        return view('pedagang.riwayat', compact ('data'));
    }
    public function kelola()
    {
        $data = Product::where('pedagang', auth()->id())->get();
        return view('pedagang.kelola', compact ('data'));
    }

}
