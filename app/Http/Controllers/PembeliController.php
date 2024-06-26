<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Detailpesanan;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;


class PembeliController extends Controller
{
    public function dashboardpembeli()
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
                return view('pedagang.dashboard', compact('pesanan', 'pembeli'));

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
    public function orderan($id)
    {
        $user = User::find($id);
        return view('pembeli.orderan', compact('user'));
    }
    public function buatpesanan()
    {
        return view('pembeli.buatpesanan');
    }

    public function simpanpesanan(Request $request)
    {
        // dd($request->all());
        $validateData = $request->validate([
            'order_name.*' => 'required|string',
            'quantity.*' => 'required|integer',
            'detail_order.*' => 'required|string',
            'lokasi' => 'required|json',
            'alamat' => 'required|string',
            'order_time' => 'required|date',
        ]);
        $lokasi = $validateData['lokasi'];
        $status = 'waiting';
        $namaproduk = $validateData['order_name'];
        $jumlah = $validateData['quantity'];
        $waktuantar = $validateData['order_time'];
        $detail = $validateData['detail_order'];
        $alamat = $validateData['alamat'];

        $user_id = Auth::id();
        $pesan = Pesanan::create([
            'user_id' => $user_id,
            'lokasi' => $lokasi,
            'alamat' => $alamat,
            'status' => $status,
            'order_time' => $waktuantar,
        ]);

        $order_id = $pesan->id;
        $pesananData = [];
        for ($i = 0; $i < count($namaproduk); $i++) {
            $pesananData[] = [
                'order_id' => $order_id,
                'order_name' => $namaproduk[$i],
                'quantity' => $jumlah[$i],
                'detail_order' => $detail[$i],
            ];
        }
        Detailpesanan::insert($pesananData);
        return redirect()->route('riwayatpembeli')->with('success', 'Pesanan berhasil disimpan. Silakan tunggu pedagang menerima pesanan Anda');
    }

    public function detailantar($id)
    {
        $lokasi = Pesanan::find($id)->lokasi;

        return view('pembeli.detail', compact('lokasi'));
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
    public function location()
    {

        $pembeli = User::where('role', 'pembeli')->get();
        return response()->json($pembeli);
    }
    public function detailpembeli($id)
    {
        $user = User::find($id);

        return view('component.detail_pembeli', compact('user'));
    }

    public function approvePesanan($id)
    {
        $pesanan = Pesanan::find($id);
        if ($pesanan) {
            $pesanan->status = 'taken';
            $pesanan->pedagang_id = Auth::user()->id;
            $pesanan->save();
            return response()->json(['message' => 'Pesanan berhasil diambil.']);
        } else {
            return response()->json(['message' => 'Tidak dapat mengambil pesanan.'], 404);
        }
    }
    public function riwayatpembeli()
    {
        $data = Pesanan::with('detail','pesananpedagang')->where('user_id', auth()->id())->get();
        return view('pembeli.riwayat', compact('data'));
    }
    public function riwayatpesanan()
    {
        $data = Pesanan::with('detail')->where('pedagang_id', auth()->id())->get();
        return view('pembeli.riwayat', compact('data'));
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
