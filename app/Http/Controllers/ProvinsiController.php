<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\provinsi;

class ProvinsiController extends Controller
{
    public function index()
{
    $provinsis = Provinsi::all();
    
    // Mendapatkan kode provinsi terakhir
    $lastprovinsi = Provinsi::latest()->first();
    $last_kd_provinsi = $lastprovinsi ? $lastprovinsi->kd_provinsi : 'P00';

    // Mendapatkan angka dari kode provinsi terakhir
    $last_kd_provinsi_number = intval(substr($last_kd_provinsi, 1)); // Menghapus karakter pertama 'K' dan mengonversi ke integer

    // Menambahkan 1 ke angka terakhir
    $new_kd_provinsi_number = $last_kd_provinsi_number + 1;

    // Mengonversi angka baru ke format KXX
    $new_kd_provinsi = 'K' . sprintf('%02d', $new_kd_provinsi_number); // Memastikan angka memiliki dua digit dengan sprintf

    return view('provinsi.index', compact('provinsis', 'new_kd_provinsi'));
}


public function store(Request $request)
{
    // Validasi data yang diterima dari form
    $validatedData = $request->validate([
        'kd_provinsi' => 'required|unique:provinsis|max:20',
        'nm_provinsi' => 'required|max:50',
        'alpha' => 'nullable|numeric|between:0,1', // Tambahkan validasi untuk alpha
    ]);

    // Buat instansi provinsi baru
    $provinsi = new Provinsi();
    $provinsi->kd_provinsi = $request->kd_provinsi;
    $provinsi->nm_provinsi = $request->nm_provinsi;
    $provinsi->alpha = $request->alpha ?? 0.00; // Set nilai default untuk alpha
    $provinsi->save();

    // Redirect ke halaman index provinsi atau ke halaman lain yang sesuai
    return redirect()->route('provinsi.index')->with('success', 'provinsi berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'kd_provinsi' => 'required|unique:provinsis,kd_provinsi,'.$id.',id|max:20',
        'nm_provinsi' => 'required|max:50',
        'alpha' => 'nullable|numeric|between:0,1', // Tambahkan validasi untuk alpha
    ]);

    // Temukan provinsi berdasarkan ID
    $provinsi = Provinsi::findOrFail($id);

    // Perbarui data provinsi
    $provinsi->kd_provinsi = $request->input('kd_provinsi');
    $provinsi->nm_provinsi = $request->input('nm_provinsi');
    $provinsi->alpha = $request->alpha ?? 0.00; // Set nilai default untuk alpha
    $provinsi->save();

    // Redirect ke halaman index provinsi atau ke halaman lain yang sesuai
    return redirect()->route('provinsi.index')->with('success', 'Data provinsi berhasil diperbarui.');
}
    public function destroy($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();
        return redirect()->route('provinsi.index')->with('success', 'Data provinsi berhasil dihapus');
    }
}

