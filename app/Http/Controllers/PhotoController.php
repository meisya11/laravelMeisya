<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    public function uploadpedagang(Request $request)
    {
        // Validasi bahwa file yang diunggah adalah file gambar
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        if ($request->file('photo')) {
            // Simpan file gambar ke dalam direktori yang diinginkan
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);

            // Jika Anda ingin menyimpan nama file gambar ke dalam database, Anda dapat melakukannya di sini

            // Redirect atau tampilkan pesan sukses jika diperlukan
            return back()
                ->with('success','Foto berhasil diunggah.')
                ->with('image',$imageName);
        }

        // Redirect atau tampilkan pesan gagal jika diperlukan
        return back()->with('error','Terjadi kesalahan saat mengunggah foto.');
    }
        public function upload1pedagang()
        {
            return view('pedagang.upload');
        }
        public function uploadadmin(Request $request)
    {
        // Validasi bahwa file yang diunggah adalah file gambar
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        if ($request->file('photo')) {
            // Simpan file gambar ke dalam direktori yang diinginkan
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);

            // Jika Anda ingin menyimpan nama file gambar ke dalam database, Anda dapat melakukannya di sini

            // Redirect atau tampilkan pesan sukses jika diperlukan
            return back()
                ->with('success','Foto berhasil diunggah.')
                ->with('image',$imageName);
        }

        // Redirect atau tampilkan pesan gagal jika diperlukan
        return back()->with('error','Terjadi kesalahan saat mengunggah foto.');
    }
        public function upload1admin()
        {
            return view('admin.profil');
        }
    }
