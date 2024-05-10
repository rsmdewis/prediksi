<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Kecamatan;

class DataController extends Controller
{
    public function index()
    {
        $datas = Data::all();
        $kecamatans = Kecamatan::all();
        return view('data.index', compact('datas', 'kecamatans'));
    }
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'tahun' => 'required|integer',
            'kd_kecamatan' => 'required',
            'luas_panen' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
        ]);

        // Hitung nilai produktivitas
        $produktivitas = $validatedData['produksi'] * 10 / $validatedData['luas_panen'];

        // Simpan data ke dalam database
        Data::create([
            'tahun' => $validatedData['tahun'], 
            'kd_kecamatan' => $validatedData['kd_kecamatan'], 
            'luas_panen' => $validatedData['luas_panen'],
            'produksi' => $validatedData['produksi'],
            'produktivitas' => $produktivitas, // Simpan nilai produktivitas
        ]);

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('data.index')->with('success', 'Data berhasil disimpan.');
    }
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'tahun' => 'required|integer',
            'kd_kecamatan' => 'required',
            'luas_panen' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
        ]);

        // Temukan data berdasarkan ID
        $data = Data::findOrFail($id);

        // Update data aktual
        $data->tahun = $validatedData['tahun'];
        $data->kd_kecamatan = $validatedData['kd_kecamatan'];
        $data->luas_panen = $validatedData['luas_panen'];
        $data->produksi = $validatedData['produksi'];

        // Simpan perubahan
        $data->save();

        // Hitung nilai produktivitas
        $produktivitas = $validatedData['produksi'] * 10 / $validatedData['luas_panen'];

        // Simpan nilai produktivitas
        $data->update(['produktivitas' => $produktivitas]);

        // Redirect atau berikan respon sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $data = Data::findOrFail($id);
        $data->delete();
        return redirect()->route('data.index')->with('success', 'Data berhasil dihapus');
    }
}
