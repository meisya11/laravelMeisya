<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;
use App\Models\Product;

class PedagangController extends Controller
{
    public function dashboardpedagang()
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
        return view('pedagang.create');
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
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama' => 'required',
    //         'jumlah' => 'required',
    //         'detail' => 'required',
    //     ]);

    //     if ($validator->fails())
    //         return redirect()->back()->withInput()->withErrors($validator);

    //     $data['nama'] = $request->nama;
    //     $data['jumlah'] = $request->jumlah;
    //     $data['detail'] = $request->detail;
    //     Product::create($data);

    //     return redirect()->route('pedagang.kelola');
    // }

    public function rute()
    {
        return view('pedagang.rute');
    }
    public function route()
    {
        $routes = Route::all();
        return response()->json($routes);
    }
    public function editpedagang(Request $request, $id)
    {
        $data = User::find($id);

        return view('pedagang.edit', compact('data'));
    }
    public function profilpedagang()
    {
        $data = User::get();
        return view('pedagang.profil', compact ('data'));
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

        return view('pedagang.riwayat');
    }
    public function kelola()
    {
        $data = Product::get();
        return view('pedagang.kelola', compact ('data'));
    }

    public function deleteproduk(Request $request, $id)
    {
        $data = Product::find($id);

        if ($data) {
            $data->delete();
        }
        return redirect()->route('kelola');
    }
    public function storeproduk(Request $request)
    {
        $data = new Product();
        $data->nama= $request->nama;
        $data->jumlah = $request->jumlah;
        $data->detail = $request->detail;
        // tambahkan data tambahan jika diperlukan
        $data->save();

        return response()->json(['message' => 'Data rute berhasil disimpan'], 200);
    }
}
