
@extends('layout.main')

@section('title', 'Forecasting')

@section('content')
    <!-- Content Row -->
    <!-- Create New Berita Button -->
    <div class="row">
    <div class="col-md-12">
    <form action="{{ route('posts.kecamatan') }}" method="GET" class="d-inline-block">
    @csrf
    <div class="form-row align-items-center">
        <div class="col-auto">
            <select class="form-control" name="kd_kecamatan" id="kd_kecamatan">
                <option value="">Pilih Kecamatan</option>
                @foreach ($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan->kd_kecamatan }}">{{ $kecamatan->kd_kecamatan }} - {{ $kecamatan->nm_kecamatan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fas fa-chart-line"></i>
                </span>
                <span class="text">Prediksi</span>
            </button>
        </div>
    </div>
</form>

        <br><br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            @if ($datas->isNotEmpty())
                <h6 class="m-0 font-weight-bold text-primary">Prediksi Jumlah Produksi Padi Kecamatan {{ $datas->first()->nm_kecamatan }}</h6>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive" id="data-table-container">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tahun</th>
                            <th>Jumlah Produksi</th>
                            <th>X</th>
                            <th>XX</th>
                            <th>XY</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->tahun }}</td>
                            <td>{{ $data->produksi }}</td>
                            <td>{{ $key }}</td>
                            <td>{{ $key * $key }}</td>
                            <td>{{ $key * $data->produksi }}</td>
                            
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Jumlah</td>
                            <td>{{ $jumlah_y }}</td>
                            <td>{{ $jumlah_x }}</td>
                            <td>{{ $jumlah_xx }}</td>
                            <td>{{ $jumlah_xy }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Rata-rata</td>
                            <td>{{ $rata2_y }}</td>
                            <td>{{ $rata2_x }}</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2">B1</td>
                            <td colspan="4">{{ $b1 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">B0</td>
                            <td colspan="4">{{ $b0 }}</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                        <p>Prediksi Produksi Padi untuk tahun berikutnya adalah {{ $prediksi }}</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn-prediksi').click(function() {
            var kd_kecamatan = $('#kd_kecamatan').val();
            // Lakukan pengecekan apakah kecamatan dipilih
            if(kd_kecamatan) {
                $.ajax({
                    url: '{{ route("posts.kecamatan") }}',
                    type: 'GET',
                    data: {kd_kecamatan: kd_kecamatan},
                    success: function(response) {
                        // Masukkan data ke dalam tabel dan tampilkan
                        $('#dataTable tbody').html(response);
                        $('#dataTable').show(); // Tampilkan tabel data
                    }
                });
            }
        });
    });
</script>



    
@endsection
