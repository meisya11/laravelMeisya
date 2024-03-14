<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function profileAdmin()
    {
        $userId = auth()->id(); // Mendapatkan ID pengguna yang sedang login
        $profile = Profile::where('user_id', $userId)->first();

        return view('admin.profil', compact('profile'));
    }


    public function editProfileAdmin($userId)
    {
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        return view('admin.editadmin', compact('profile'));
    }

    public function updateprofileadmin(Request $request, $data)
    {
        $profile = Profile::where('id', $data)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255|unique:profiles,email'.$profile->id,
            'phone' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload dan penyimpanan foto profil jika diperlukan
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profile_images', 'public');
            $profile->foto_profil = $path;
        }

        // Update kolom-kolom profil
        $profile->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profilAdmin')->with('success', 'Profil berhasil diperbarui.');
    }
    public function profilePedagang()
    {
        $userId = auth()->id(); // Mendapatkan ID pengguna yang sedang login
        $profile = Profile::where('user_id', $userId)->first();

        return view('pedagang.profil', compact('profile'));
    }


    public function editProfile($userId)
    {
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        return view('pedagang.editpedagang', compact('profile'));
    }

    // public function update(Request $request, $id)
    // {
    //     $profile = Profile::where('id', $id)->firstOrFail();
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'nullable|string|max:255|unique:email',
    //         'phone' => 'nullable|string|max:20',
    //         'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     // Proses upload dan penyimpanan foto profil jika diperlukan
    //     if ($request->hasFile('foto_profil')) {
    //         $path = $request->file('foto_profil')->store('profile_images', 'public');
    //         $profile->foto_profil = $path;
    //     }
    //     if ($validator->fails())
    //     return redirect()->back()->withInput()->withErrors($validator);
    //     $data['name'] = $request->nama;
    //     $data['email'] = $request->email;
    //     $data['phone'] = $request->phone;
    //     // Update kolom-kolom profil
    //     $profile->update($request->only('name', 'email', 'phone', 'foto_profil'));

    //     return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    // }

    public function updatepedagang(Request $request, $data)
    {
        $profile = Profile::where('id', $data)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255|unique:profiles,email'.$profile->id,
            'phone' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload dan penyimpanan foto profil jika diperlukan
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profile_images', 'public');
            $profile->foto_profil = $path;
        }

        // Update kolom-kolom profil
        $profile->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profilPedagang')->with('success', 'Profil berhasil diperbarui.');
    }
}
