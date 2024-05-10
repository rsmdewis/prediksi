@extends('layout.main')
@section('title', 'Provinsi')
@section('content')
    <!-- Content Row -->
    <!-- Create New Berita Button -->
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Provinsi</span>
            </button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Provinsi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Provinsi</th>
                                    <th>Nama Provinsi</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kecamatans as $key => $kecamatan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $kecamatan->kd_kecamatan }}</td>
                                        <td>{{ $kecamatan->nm_kecamatan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $kecamatan->id }}">Edit</button>
                                            <form action="{{ route('kecamatan.destroy', $kecamatan->id) }}" method="POST" style="display: inline-block;">
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

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Provinsi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kecamatan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kd_kecamatan">Kode Provinsi</label>
                            <!-- Tambahkan atribut id="last_kd_kecamatan" pada input -->
                            <input type="text" class="form-control" name="kd_kecamatan" value="{{ $new_kd_kecamatan }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nm_kecamatan">Nama Provinsi</label>
                            <input type="text" class="form-control" id="nm_kecamatan" name="nm_kecamatan">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Kecamatan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Kecamatan -->
    @foreach ($kecamatans as $kecamatan)
        <div class="modal fade" id="editModal{{ $kecamatan->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $kecamatan->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $kecamatan->id }}Label">Edit Provinsi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="kd_kecamatan">Kode Provinsi</label>
                                <input type="text" class="form-control" id="kd_kecamatan" name="kd_kecamatan" value="{{ $kecamatan->kd_kecamatan }}">
                            </div>
                            <div class="form-group">
                                <label for="nm_kecamatan">Nama Provinsi</label>
                                <input type="text" class="form-control" id="nm_kecamatan" name="nm_kecamatan" value="{{ $kecamatan->nm_kecamatan }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script untuk mengatur nomor urut Kode Kecamatan -->
    <script>
    $('#tambahModal').on('shown.bs.modal', function () {
        var lastKdKecamatan = $('#last_kd_kecamatan').val();
        var nextNumber = parseInt(lastKdKecamatan.substring(1)) + 1;
        var nextKdKecamatan = 'K' + ('00' + nextNumber).slice(-2); // Format nomor dengan 2 digit

        $('#kd_kecamatan').val(nextKdKecamatan);
    });
</script>


@endsection
