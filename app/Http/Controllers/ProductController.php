<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function simpanproduk(Request $request)
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

        return redirect()->route('kelola');
    }
}
