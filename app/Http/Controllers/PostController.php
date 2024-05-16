<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Data;
use App\Models\Provinsi;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function dashboard()
    {
        
        $totalProvinsi = Provinsi::count();
        $totalData = Data::count();
        return view('posts.dashboard', [
            'totalProvinsi' => $totalProvinsi,
            'totalData' => $totalData
        ]);
    }
    public function index(Request $request)
    {
        
        $provinsis = Provinsi::all();
        return view('posts.index', compact('provinsis'));
    }
    
    public function getDataByProvinsi(Request $request)
{
    // Ambil data berdasarkan kd_kecamatan
    $kd_provinsi = $request->kd_provinsi;
    $datas = Data::join('provinsis', 'data.kd_provinsi', '=', 'provinsis.kd_provinsi')
                    ->where('data.kd_provinsi', $kd_provinsi)
                    ->select('data.*', 'provinsis.nm_provinsi')
                    ->get();
    $provinsis = Provinsi::all();
    // Lakukan sesuatu dengan data, misalnya:
    return view('posts.prediksi', compact('datas', 'provinsis'));

}


    
}
