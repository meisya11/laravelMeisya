<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;


class RouteController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $rute = Route::where('users', auth()->id())->where('approval', '!=', 'reject')->first();

        if ($rute) {
                return redirect()->route('detailrute', ['id' => $rute->id]);
        }else{
            return redirect()->route('route1');
        }
    }
    function createroute(Request $request)
    {

        $data = [
            'lokasi' => $request->lokasi,
            'users' => auth()->id(),
            'name' => auth()->user()->name,
        ];

        $saveid = Route::create($data);

        if ($saveid) {
            return response()->json([
                'status' => 'success',
                'message' => 'Rute berhasil ditambahkan!',
                'id' => $saveid->id,
            ]);
        };
        // dd($request->all());
    }

    public function updateroute(Request $request)
    {
        $rute = $request->id;
        $updateRute = Route::find($request->id);
        $updateRute->save();

        if ($updateRute) {
            return response()->json([
                'status' => 'success',
                'message' => 'Rute berhasil dihapus'
            ]);
        }
    }
    public function updatestatusrute(Request $request, $id)
    {
        $rute = Route::find($id);
        $rute->save();
    }
    function detailrute($id)
    {
        $rute = Route::find($id);

        return view('pedagang.detailroute', compact('rute'));
    }

}
