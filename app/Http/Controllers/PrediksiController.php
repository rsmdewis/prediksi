<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Provinsi;

class PrediksiController extends Controller
{
    public function index(Request $request)
    {
        
        $provinsis = Provinsi::all();
        return view('prediksi.index', compact('provinsis'));
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
    return view('prediksi.prediksi', compact('datas', 'provinsis'));

}   
}
