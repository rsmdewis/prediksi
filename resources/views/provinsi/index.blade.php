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
                                    <th>Alpha</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($provinsis as $key => $provinsi)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $provinsi->kd_provinsi }}</td>
                                        <td>{{ $provinsi->nm_provinsi }}</td>
                                        <td>{{ $provinsi->alpha }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $provinsi->id }}">Edit</button>
                                            <form action="{{ route('provinsi.destroy', $provinsi->id) }}" method="POST" style="display: inline-block;">
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
                    <form action="{{ route('provinsi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kd_provinsi">Kode Provinsi</label>
                            <!-- Tambahkan atribut id="last_kd_provinsi" pada input -->
                            <input type="text" class="form-control" name="kd_provinsi" value="{{ $new_kd_provinsi }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nm_provinsi">Nama Provinsi</label>
                            <input type="text" class="form-control" id="nm_provinsi" name="nm_provinsi">
                        </div>
                        <div class="form-group">
                            <label for="alpha">Alpha</label>
                            <input type="text" class="form-control" id="alpha" name="alpha" step="0.01" min="0" max="1" value="0.00">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan provinsi</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit provinsi -->
    @foreach ($provinsis as $provinsi)
        <div class="modal fade" id="editModal{{ $provinsi->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $provinsi->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $provinsi->id }}Label">Edit Provinsi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('provinsi.update', $provinsi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="kd_provinsi">Kode Provinsi</label>
                                <input type="text" class="form-control" id="kd_provinsi" name="kd_provinsi" value="{{ $provinsi->kd_provinsi }}">
                            </div>
                            <div class="form-group">
                                <label for="nm_provinsi">Nama Provinsi</label>
                                <input type="text" class="form-control" id="nm_provinsi" name="nm_provinsi" value="{{ $provinsi->nm_provinsi }}">
                            </div>
                            <div class="form-group">
                                <label for="alpha">Alpha</label>
                                <input type="number" class="form-control" id="alpha" name="alpha" step="0.01" min="0" max="1" value="{{ $provinsi->alpha ?? '0.00' }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script untuk mengatur nomor urut Kode provinsi -->
    <script>
    $('#tambahModal').on('shown.bs.modal', function () {
        var lastKdprovinsi = $('#last_kd_provinsi').val();
        var nextNumber = parseInt(lastKdprovinsi.substring(1)) + 1;
        var nextKdprovinsi = 'P' + ('00' + nextNumber).slice(-2); // Format nomor dengan 2 digit

        $('#kd_provinsi').val(nextKdprovinsi);
    });
</script>


@endsection
