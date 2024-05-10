
@extends('layout.main')

@section('title', 'Forecasting')

@section('content')
    <!-- Content Row -->
    <!-- Create New Berita Button -->
    <div class="row">
    <div class="col-md-12">
    <form action="{{ route('prediksi.provinsi') }}" method="GET" class="d-inline-block">
    @csrf
    <div class="form-row align-items-center">
        <div class="col-auto">
            <select class="form-control" name="kd_provinsi" id="kd_provinsi">
                <option value="">Pilih Provinsi</option>
                @foreach ($provinsis as $provinsi)
                    <option value="{{ $provinsi->kd_provinsi }}">{{ $provinsi->kd_provinsi }} - {{ $provinsi->nm_provinsi }}</option>
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
                <h5 class="m-0 font-weight-bold text-primary" style="color: black;">Prediksi Jumlah Produksi Padi Provinsi {{ $datas->first()->nm_provinsi }}</h5>
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
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->tahun }}</td>
                            <td>{{ $data->produksi }}</td>
                            
                        </tr>
                        @endforeach

                    </tbody>
                    </table><br>
                    <h5 style="font-weight: bold;" class="text-primary">Perhitungan Double Exponantial Smoothing</h5>
                    <div style="overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                        <tr>
                            <th>No.</th>
                            <th>S't</th>
                            <th>S"t</th>
                            <th>at</th>
                            <th>bt</th>
                            <th>prediksi</th>
                            <th>error*</th>
                            <th>Absolute error</th>
                            <th>e*e</th>
                            <th>PE</th>
                            <th>Alpha</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">Rata-Rata</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td style="font-weight: bold;">MADE</td>
                            <td style="font-weight: bold;">MSE</td>
                            <td style="font-weight: bold;">MAPE</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                </div><br>
                <div>
                        <h5 style="font-weight: bold;" class="text-primary" >Prediksi Produksi Padi untuk tahun 2024 adalah </h5>
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
            var kd_provinsi = $('#kd_provinsi').val();
            // Lakukan pengecekan apakah provinsi dipilih
            if(kd_provinsi) {
                $.ajax({
                    url: '{{ route("posts.provinsi") }}',
                    type: 'GET',
                    data: {kd_provinsi: kd_provinsi},
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
