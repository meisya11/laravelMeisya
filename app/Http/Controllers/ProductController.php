<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function createproduk(Request $request)
    {
        $data = Product::get();
        return view('pedagang.createproduk', compact('data'));
    }
    public function deleteproduk(Request $request, $id)
    {
        $data = Product::find($id);

        if ($data) {
            $data->delete();
        }
        return redirect()->route('kelola');
    }
    public function updateproduk(Request $request, $id)
    {
        $data = Product::where('id', $id)->firstOrFail();

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'jumlah' => 'nullable',
            'detail' => 'nullable',
            'harga' => 'nullable',
        ]);

        $data->update($request->all());
        return redirect()->route('kelola')->with('success', 'Data produk diperbarui.');
    }
    public function storeproduk(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jumlah' => 'required',
            'detail' => 'required',
            'harga' => 'required',
        ]);


        $pedagangId = Auth::id();

        $productData = [
            'nama' => $validatedData['nama'],
            'jumlah' => $validatedData['jumlah'],
            'detail' => $validatedData['detail'],
            'harga' => $validatedData['harga'],
            'pedagang' => $pedagangId,
        ];

        Product::create($productData);

        // Redirect ke rute 'kelola' setelah berhasil menyimpan produk
        return redirect()->route('kelola');
    }

    public function editproduk(Request $request, $id)
    {
        $data = Product::find($id);

        return view('pedagang.editproduk', compact('data'));
    }
}
