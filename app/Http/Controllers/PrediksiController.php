<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Provinsi;
use App\Models\Smoothing;

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
                    ->select('data.*', 'provinsis.nm_provinsi', 'provinsis.alpha')
                    ->get();
    $provinsis = Provinsi::all();
    $m = 1; // Nilai m yang Anda tentukan

    // Ambil nilai alpha dari data provinsi
    $alpha = $datas->first()->alpha;

    $n = count($datas);
    $A1 = [];
    $A2 = [];
    $at = [];
    $bt = [];
    $F = [];
    $error = [];
    $absolute_error = [];
    $squared_error = [];
    $percentage_error = [];

    // Inisialisasi nilai A1 dan A2
    $A1[0] = $datas[0]->produksi;
    $A2[0] = $datas[0]->produksi;

    // Perhitungan smoothing pertama dan kedua
    for ($i = 1; $i < $n; $i++) {
        $A1[$i] = $alpha * $datas[$i]->produksi + (1 - $alpha) * $A1[$i - 1];
        $A2[$i] = $alpha * $A1[$i] + (1 - $alpha) * $A2[$i - 1];
    }

    // Perhitungan nilai at dan bt
    for ($i = 0; $i < $n; $i++) {
        $at[$i] = 2 * $A1[$i] - $A2[$i];
        $bt[$i] = ($alpha / (1 - $alpha)) * ($A1[$i] - $A2[$i]);
    }
    

    // Hitung Prediksi dan error
    for ($i = 0; $i < $n; $i++) {
        $F[$i + $m] = $at[$i] + ($bt[$i] * $m);
        
        
    }
    for ($i = 1; $i < $n; $i++) {
        $prediksi[$i] = $at[$i -1] + ($bt[$i-1] * $m);
        

        // Hitung error
        $error[$i] = $datas[$i]->produksi - $prediksi[$i];

        // Hitung absolute error
        $absolute_error[$i] = abs($error[$i]);

        // Hitung squared error
        $squared_error[$i] = $error[$i] * $error[$i];

        // Hitung percentage error
        if ($datas[$i]->produksi != 0) {
            $percentage_error[$i] = abs($error[$i] / $datas[$i]->produksi);
        } else {
            $percentage_error[$i] = 0;
        }
        Smoothing::create([
            'kd_provinsi' => $kd_provinsi,
            'tahun' => $datas[$i]->tahun,
            'produksi' => $datas[$i]->produksi,
            'prediksi' => $prediksi[$i],
        ]);
        
    }
    $last_prediction = end($F);
    // Hitung rata-rata absolute error
$avg_absolute_error = array_sum($absolute_error) / count($absolute_error);

// Hitung rata-rata squared error
$avg_squared_error = array_sum($squared_error) / count($squared_error);

// Hitung rata-rata percentage error
$avg_percentage_error = array_sum($percentage_error) / count($percentage_error);
    // Lakukan sesuatu dengan data, misalnya:
    return view('prediksi.prediksi', compact('datas', 'provinsis', 'A1', 'A2', 'at', 'bt', 'F', 'last_prediction','error', 'absolute_error', 'squared_error', 'percentage_error','avg_absolute_error', 'avg_squared_error', 'avg_percentage_error'));
}


}