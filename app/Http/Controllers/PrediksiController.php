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
    $kd_provinsi = $request->kd_provinsi;
    $datas = Data::join('provinsis', 'data.kd_provinsi', '=', 'provinsis.kd_provinsi')
                ->where('data.kd_provinsi', $kd_provinsi)
                ->select('data.*', 'provinsis.nm_provinsi', 'provinsis.alpha')
                ->get();
    $provinsis = Provinsi::all();
    $m = 1; // Nilai m yang Anda tentukan

    if ($datas->isEmpty()) {
        return view('prediksi.prediksi', compact('datas', 'provinsis'))
                ->withErrors('Data tidak ditemukan untuk kd_provinsi ini.');
    }

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
    $prediksi = [];

    // Inisialisasi nilai A1 dan A2 untuk tahun pertama
    $A1[0] = $datas[0]->produksi ?? 0;
    $A2[0] = $datas[0]->produksi ?? 0;

    // Perhitungan smoothing pertama dan kedua
    for ($i = 1; $i < $n; $i++) {
        $produksi = $datas[$i]->produksi ?? 0;
        $A1[$i] = $alpha * $produksi + (1 - $alpha) * $A1[$i - 1];
        $A2[$i] = $alpha * $A1[$i] + (1 - $alpha) * $A2[$i - 1];
    }

    // Perhitungan nilai at dan bt
    for ($i = 0; $i < $n; $i++) {
        $at[$i] = 2 * $A1[$i] - $A2[$i];
        $bt[$i] = ($alpha / (1 - $alpha)) * ($A1[$i] - $A2[$i]);
    }

    // Hitung Prediksi untuk m tahun ke depan
    for ($i = 0; $i < $n; $i++) {
        $F[$i + $m] = $at[$i] + ($bt[$i] * $m);
    }

    // Hitung Prediksi, Error dan Metrics
    for ($i = 1; $i < $n; $i++) {
        $prediksi[$i] = $at[$i - 1] + ($bt[$i - 1] * $m);
        $produksi = $datas[$i]->produksi;

        if ($produksi !== null) {
            $error[$i] = $produksi - $prediksi[$i];
            $absolute_error[$i] = abs($error[$i]);
            $squared_error[$i] = $error[$i] * $error[$i];
            $percentage_error[$i] = $produksi != 0 ? abs($error[$i] / $produksi) : 0;
        } else {
            $error[$i] = null;
            $absolute_error[$i] = null;
            $squared_error[$i] = null;
            $percentage_error[$i] = null;
        }

        // Periksa apakah data sudah ada sebelum menyimpannya
        Smoothing::updateOrCreate(
            [
                'kd_provinsi' => $kd_provinsi,
                'tahun' => $datas[$i]->tahun,
            ],
            [
                'produksi' => $produksi,
                'prediksi' => $prediksi[$i] ?? null,
            ]
        );
    }

    // Menyimpan data untuk tahun 2018 jika belum ada
    Smoothing::updateOrCreate(
        [
            'kd_provinsi' => $kd_provinsi,
            'tahun' => $datas[0]->tahun,
        ],
        [
            'produksi' => $datas[0]->produksi,
            'prediksi' => null,
        ]
    );

    // Menyimpan data untuk tahun 2024 jika belum ada
    Smoothing::updateOrCreate(
        [
            'kd_provinsi' => $kd_provinsi,
            'tahun' => $datas[$n - 1]->tahun + 1,
        ],
        [
            'produksi' => null,
            'prediksi' => end($F),
        ]
    );

    $last_prediction = end($F);
    $avg_absolute_error = !empty(array_filter($absolute_error, 'is_numeric')) ? array_sum(array_filter($absolute_error, 'is_numeric')) / count(array_filter($absolute_error, 'is_numeric')) : 0;
    $avg_squared_error = !empty(array_filter($squared_error, 'is_numeric')) ? array_sum(array_filter($squared_error, 'is_numeric')) / count(array_filter($squared_error, 'is_numeric')) : 0;
    $avg_percentage_error = !empty(array_filter($percentage_error, 'is_numeric')) ? array_sum(array_filter($percentage_error, 'is_numeric')) / count(array_filter($percentage_error, 'is_numeric')) : 0;

    return view('prediksi.prediksi', compact('datas', 'provinsis', 'A1', 'A2', 'at', 'bt', 'F', 'last_prediction', 'error', 'absolute_error', 'squared_error', 'percentage_error', 'avg_absolute_error', 'avg_squared_error', 'avg_percentage_error'));
}






}