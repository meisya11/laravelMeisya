<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function createproduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jumlah' => 'required',
            'detail' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        $data['nama'] = $request->nama;
        $data['jumlah'] = $request->jumlah;
        $data['detail'] = $request->detail;
        Product::create($data);

        return redirect()->route('createproduk');
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

        return response()->route('pedagang.kelola');
    }
    public function editproduk(Request $request, $id)
    {
        $data = Product::find($id);

        return view('pedagang.kelola', compact('data'));
    }
}
