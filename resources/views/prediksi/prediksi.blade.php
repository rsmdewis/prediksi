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
                            <td>{{ number_format($data->produksi, 2, ',', '.') }}</td>
                            
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
                            <th>A't</th>
                            <th>A"t</th>
                            <th>at</th>
                            <th>bt</th>
                            <th>prediksi</th>
                            <th>error*</th>
                            <th>Absolute error</th>
                            <th>e*e</th>
                            <th>PE</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ isset($A1[$key]) ? number_format($A1[$key], 2, ',', '.') : 'N/A' }}</td>
                            <td>{{ isset($A2[$key]) ? number_format($A2[$key], 2, ',', '.') : 'N/A' }}</td>
                            <td>{{ isset($at[$key]) ? number_format($at[$key], 2, ',', '.') : 'N/A' }}</td>
                            <td>{{ isset($bt[$key]) ? number_format($bt[$key], 2, ',', '.') : 'N/A' }}</td>
                            <td>{{ isset($F[$key]) ? number_format($F[$key], 2, ',', '.') : ' ' }}</td>
                            <td>{{ isset($error[$key]) ? number_format($error[$key], 2, ',', '.') : ' ' }}</td>
                            <td>{{ isset($absolute_error[$key]) ? number_format($absolute_error[$key], 2, ',', '.') : ' ' }}</td>
                            <td>{{ isset($squared_error[$key]) ? number_format($squared_error[$key], 2, ',', '.') : ' ' }}</td>
                            <td>{{ isset($percentage_error[$key]) ? number_format($percentage_error[$key] * 100) . '%' : ' ' }}</td>

                            
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7" style="text-align: center; font-weight: bold;">Rata-Rata</td>
                            <td>{{ number_format($avg_absolute_error, 2) }}</td>
                            <td>{{ number_format($avg_squared_error, 2) }}</td>
                            <td>{{ number_format($avg_percentage_error * 100) }}%</td>
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
                    
                        <h5 style="font-weight: bold;" class="text-primary" >Prediksi Produksi Padi untuk tahun 2024 adalah {{ number_format($last_prediction, 2, ',', '.') }}</h5>
                    </div><br>
                </div>
                <table class="table table-bordered" id="dataTablePrediksi" width="100%" cellspacing="0">
                <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tahun</th>
                            <th>Produksi</th>
                            <th>Prediksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($datas as $key => $data)
                        <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->tahun }}</td>
                        <td>{{ number_format($data->produksi, 2, ',', '.') }}</td>
                        <td>{{ isset($F[$key]) ? number_format($F[$key], 2, ',', '.') : ' ' }}</td>
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                            <td>7</td>
                            <td>2024</td>
                            <td></td>
                            <td>{{ number_format($last_prediction, 2, ',', '.') }}</td>

                        </tr>

                    </tbody>
                    </table>
            </div>
        </div>
        
    </div>
    
</div>
<div>
    <canvas id="barChart" width="800" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mendapatkan data dari tabel HTML
    var years = [];
    var production = [];
    var prediction = [];
    var table = document.getElementById('dataTablePrediksi');
    var rows = table.getElementsByTagName('tr');
    
    for (var i = 1; i < rows.length - 1; i++) {
        var cells = rows[i].getElementsByTagName('td');
        years.push(cells[1].innerText);

        var productionValue = cells[2].innerText.replace(/\./g, '').replace(',', '.');
        production.push(productionValue ? parseFloat(productionValue) : null);

        var predictionValue = cells[3].innerText.replace(/\./g, '').replace(',', '.');
        prediction.push(predictionValue ? parseFloat(predictionValue) : null);
    }

    // Tambahkan data untuk tahun 2024
    years.push('2024');
    production.push(null); // Atur ke null jika tidak ada data produksi
    prediction.push(parseFloat('{{ number_format($last_prediction, 2, '.', '') }}'));

    // Membersihkan data dari nilai null
    var cleanedProduction = production.map(value => value !== null ? value : 0);
    var cleanedPrediction = prediction.map(value => value !== null ? value : 0);

    // Membuat diagram batang
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [{
                label: 'Produksi',
                data: cleanedProduction,
                backgroundColor: 'rgba(255, 99, 132, 0.6)', // Warna merah lebih tegas
                borderColor: 'rgba(255, 99, 132, 1)', // Warna border merah
                borderWidth: 1
            }, {
                label: 'Prediksi',
                data: cleanedPrediction,
                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Warna biru lebih tegas
                borderColor: 'rgba(54, 162, 235, 1)', // Warna border biru
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>



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