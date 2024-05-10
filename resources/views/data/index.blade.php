
@extends('layout.main')

@section('title', 'Data Aktual')

@section('content')
    <!-- Content Row -->
    <!-- Create New Berita Button -->
    <div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Data Aktual</span>
            </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Data Aktual</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Tahun</th>
                            <th rowspan="2">Provinsi</th>
                            <th colspan="3" class="text-center">Padi Sawah</th> <!-- Menggabungkan 3 kolom menjadi 1 -->
                            <th rowspan="2">Opsi</th>
                        </tr>
                        <tr>
                            <th>Luas Panen</th>
                            <th>Produktivitas</th>
                            <th>Produksi</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->tahun }}</td>
                            <td>{{ $data->kd_provinsi }}</td>
                            <td>{{ $data->luas_panen }}</td>
                            <td>{{ $data->produktivitas }}</td>
                            <td>{{ $data->produksi }}</td>
                            <td>
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $data->id }}">Edit</button>
                                <form action="{{ route('data.destroy', $data->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah provinsi -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Aktual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('data.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="">Pilih Tahun</option>
                                @for ($i = date("Y"); $i >= 2010; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kd_provinsi">Provinsi</label>
                            <select class="form-control" name="kd_provinsi" id="kd_provinsi">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsis as $provinsi)
                                    <option value="{{ $provinsi->kd_provinsi }}">{{ $provinsi->kd_provinsi }} - {{ $provinsi->nm_provinsi }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="luas_panen">Luas Panen</label>
                            <input type="number" class="form-control" name="luas_panen" min="0">
                        </div>
                        <div class="form-group">
                            <label for="produksi">Produksi</label>
                            <input type="number" class="form-control" name="produksi" min="0">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit provinsi -->
    @foreach ($datas as $data)
        <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $data->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $data->id }}Label">Edit Data Aktual</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('data.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = date("Y"); $i >= 2010; $i--)
                                        <option value="{{ $i }}" {{ $data->tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kd_provinsi">Provinsi</label>
                                <select class="form-control" name="kd_provinsi" id="kd_provinsi">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi->kd_provinsi }}" {{ $data->kd_provinsi == $provinsi->kd_provinsi ? 'selected' : '' }}>{{ $provinsi->kd_provinsi }} - {{ $provinsi->nm_provinsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="luas_panen">Luas Panen</label>
                                <input type="number" class="form-control" name="luas_panen" min="0" value="{{ $data->luas_panen }}">
                            </div>
                            <div class="form-group">
                                <label for="produksi">Produksi</label>
                                <input type="number" class="form-control" name="produksi" min="0" value="{{ $data->produksi }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    
@endsection
