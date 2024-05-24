<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{

    public function profileAdmin()
    {
        $id = auth()->id();
        $profile = User::where('id', $id)->first();

        return view('admin.profil', compact('profile'));
    }

    public function editprofiladmin(Request $request, $id)
    {
        $profile = User::find($id);
        // $profile = Profile::where('id', $id)->firstOrFail();

        return view('admin.editprofiladmin', compact('profile'));
    }

    public function updateProfileAdmin(Request $request, $id)
    {
        // Temukan profil admin berdasarkan ID
        $profile = User::where('id', $id)->firstOrFail();

        // Validasi data yang dikirimkan melalui formulir
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'role' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        // Lakukan pembaruan data berdasarkan data yang dikirimkan melalui request
        $profile->update($request->all());
        // Redirect ke rute yang sesuai dengan pesan sukses
        return redirect()->route('profileAdmin')->with('success', 'Profil admin diperbarui.');
    }

    // dd($request->all());


    public function profilepedagang()
    {
        $id = auth()->id();
        $profile = Profile::whereHas('user', function ($query) use ($id) {
            $query->where('id', $id); })->first();
        $user = User::get();

        return view('pedagang.profil', compact('profile', 'user'));
    }

    public function editprofilpedagang(Request $request, $id)
    {
        $profile = Profile::find($id);
        // $profile = Profile::where('id', $id)->firstOrFail();

        return view('pedagang.editprofilpedagang', compact('profile'));
    }

    public function updateprofilepedagang(Request $request, $id)
    {
        // Temukan profil pedagang berdasarkan ID
        $profile = Profile::where('id', $id)->firstOrFail();

        // Validasi data yang dikirimkan melalui formulir
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'role' => 'nullable',
            'password' => 'nullable|min:6',
            'deskripsi' => 'nullable|string|max:255',
            'jam' => 'nullable',
            'sampai' => 'nullable',
            'kategori' => 'nullable|string|max:50',
        ]);
        // dd($request->all());
        // Lakukan pembaruan data berdasarkan data yang dikirimkan melalui request
        // $profile->update($request->all());
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'phone', 'role', 'password']));
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        if (empty($request->password)) {
            unset($validatedData['password']);
        }
        $profile->update($request->only(['deskripsi', 'jam', 'sampai', 'kategori']));
        // Redirect ke rute yang sesuai dengan pesan sukses
        return redirect()->route('profilePedagang')->with('success', 'Profil pedagang diperbarui.');
    }
    public function profilePembeli()
    {
        $id = auth()->id();
        $profile = User::where('id', $id)->first();

        return view('pembeli.profil', compact('profile'));
    }

    public function editprofilpembeli(Request $request, $id)
    {
        $profile = User::find($id);
        // $profile = Profile::where('id', $id)->firstOrFail();

        return view('pembeli.editprofilpembeli', compact('profile'));
    }

    public function updateProfilepembeli(Request $request, $id)
    {
        // Temukan profil pembeli berdasarkan ID
        $profile = User::where('id', $id)->firstOrFail();

        // Validasi data yang dikirimkan melalui formulir
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'role' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        // Lakukan pembaruan data berdasarkan data yang dikirimkan melalui request
        $profile->update($request->all());
        // Redirect ke rute yang sesuai dengan pesan sukses
        return redirect()->route('profilePembeli')->with('success', 'Profil pembeli diperbarui.');
    }

}
