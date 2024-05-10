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

    $jumlah_data = count($datas);

    // Pastikan jumlah data tidak sama dengan nol
    if ($jumlah_data > 0) {
        $jumlah_x = 0;
        $jumlah_y = 0;
        $jumlah_xx = 0;
        $jumlah_xy = 0;

        foreach ($datas as $x => $data) {
            $jumlah_x += $x;
            $jumlah_y += $data->produksi;
            $jumlah_xx += ($x * $x);
            $jumlah_xy += ($x * $data->produksi); 
        }

        // Menghitung rata-rata X dan Y
        $rata2_x = $jumlah_x / $jumlah_data;
        $rata2_y = $jumlah_y / $jumlah_data;

        // Menghitung koefisien regresi jika jumlah data lebih dari 1
        if ($jumlah_data > 1) {
            $b1 = ($jumlah_xy - ($jumlah_x * $jumlah_y / $jumlah_data)) / ($jumlah_xx - ($jumlah_x * $jumlah_x / $jumlah_data));
            $b0 = $rata2_y - $b1 * $rata2_x;
        } else {
            $b1 = 0;
            $b0 = $rata2_y;
        }
    } else {
        // Jika tidak ada data, inisialisasi variabel dengan nilai default
        $jumlah_x = 0;
        $jumlah_y = 0;
        $jumlah_xx = 0;
        $jumlah_xy = 0;
        $rata2_x = 0;
        $rata2_y = 0;
        $b1 = 0;
        $b0 = 0;
    }

    // Inisialisasi variabel prediksi
    $prediksi = null;

    // Memeriksa apakah permintaan memiliki data prediksi
    if ($request->has('prediksi')) {
        // Ambil nilai tahun dari request
        $tahun = 1;

        // Lakukan perhitungan prediksi jika jumlah data lebih dari 1
        if ($jumlah_data > 1) {
            $x = $jumlah_data; // Asumsi $x adalah jumlah data
            $thn = ($x - 1) + $tahun;
            $prediksi = $b0 + ($b1 * $thn);
        } else {
            $prediksi = $rata2_y;
        }
    }

    // Lakukan sesuatu dengan data, misalnya:
    return view('posts.prediksi', compact('datas', 'provinsis', 'jumlah_x', 'jumlah_y', 'jumlah_xx', 'jumlah_xy', 'rata2_x', 'rata2_y', 'b1', 'b0', 'prediksi'));

}


    
}
