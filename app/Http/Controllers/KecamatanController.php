<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index()
{
    $kecamatans = Kecamatan::all();
    
    // Mendapatkan kode kecamatan terakhir
    $lastKecamatan = Kecamatan::latest()->first();
    $last_kd_kecamatan = $lastKecamatan ? $lastKecamatan->kd_kecamatan : 'K00';

    // Mendapatkan angka dari kode kecamatan terakhir
    $last_kd_kecamatan_number = intval(substr($last_kd_kecamatan, 1)); // Menghapus karakter pertama 'K' dan mengonversi ke integer

    // Menambahkan 1 ke angka terakhir
    $new_kd_kecamatan_number = $last_kd_kecamatan_number + 1;

    // Mengonversi angka baru ke format KXX
    $new_kd_kecamatan = 'K' . sprintf('%02d', $new_kd_kecamatan_number); // Memastikan angka memiliki dua digit dengan sprintf

    return view('kecamatan.index', compact('kecamatans', 'new_kd_kecamatan'));
}


    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'kd_kecamatan' => 'required|unique:kecamatans|max:20',
            'nm_kecamatan' => 'required|max:50',
        ]);

        // Buat instansi Kecamatan baru
        $kecamatan = new Kecamatan();
        $kecamatan->kd_kecamatan = $request->kd_kecamatan;
        $kecamatan->nm_kecamatan = $request->nm_kecamatan;
        $kecamatan->save();

        // Redirect ke halaman index kecamatan atau ke halaman lain yang sesuai
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'kd_kecamatan' => 'required|unique:kecamatans,kd_kecamatan,'.$id.',id|max:20',
        'nm_kecamatan' => 'required|max:50',
    ]);

    // Temukan kecamatan berdasarkan ID
    $kecamatan = Kecamatan::findOrFail($id);

    // Perbarui data kecamatan
    $kecamatan->kd_kecamatan = $request->input('kd_kecamatan');
    $kecamatan->nm_kecamatan = $request->input('nm_kecamatan');
    $kecamatan->save();

    return redirect()->route('kecamatan.index')->with('success', 'Data kecamatan berhasil diperbarui.');
}
    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil dihapus');
    }
}
