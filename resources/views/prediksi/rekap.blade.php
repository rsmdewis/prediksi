@extends('layout.main')

@section('title', 'Forecasting')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="filterForm" class="d-inline-block">
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
                        <button type="button" class="btn btn-primary" id="btnPrediksi">
                            <span class="icon text-white-50">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="text">Prediksi</span>
                        </button>
                    </div>
                </div>
            </form>

            <br><br>

            <div class="card shadow mb-4" id="dataCard" style="display:none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Prediksi Jumlah Produksi Padi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="data-table-container">
                        <table class="table table-bordered" id="dataTablePrediksi" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun</th>
                                    <th>Produksi</th>
                                    <th>Prediksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div>
        <canvas id="lineChart" width="800" height="400"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnPrediksi').click(function() {
                var kd_provinsi = $('#kd_provinsi').val();

                if (!kd_provinsi) {
                    alert('Silakan pilih provinsi terlebih dahulu.');
                    return;
                }

                $.ajax({
                    url: '{{ route("prediksi.getrekap") }}',
                    type: 'GET',
                    data: { kd_provinsi: kd_provinsi },
                    success: function(response) {
                        var smoothings = response.smoothings;

                        // Sort data by year
                        smoothings.sort(function(a, b) {
                            return a.tahun - b.tahun;
                        });

                        var tableBody = $('#dataTablePrediksi tbody');
                        tableBody.empty();

                        smoothings.forEach(function(data, index) {
                            var row = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + data.tahun + '</td>' +
                                '<td>' + number_format(data.produksi, 2, ',', '.') + '</td>' +
                                '<td>' + number_format(data.prediksi, 2, ',', '.') + '</td>' +
                                '</tr>';
                            tableBody.append(row);
                        });

                        $('#dataCard').show();

                        // Membuat diagram garis
                        var years = [];
                        var production = [];
                        var prediction = [];

                        smoothings.forEach(function(data) {
                            years.push(data.tahun);
                            production.push(parseFloat(data.produksi));
                            prediction.push(parseFloat(data.prediksi));
                        });

                        // Memperbarui chart
                        updateChart(years, production, prediction);
                    },
                    error: function(response) {
                        alert(response.responseJSON.error);
                    }
                });
            });

            function number_format(number, decimals, dec_point, thousands_sep) {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + (Math.round(n * k) / k).toFixed(prec);
                    };
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            function updateChart(years, production, prediction) {
                var ctx = document.getElementById('lineChart').getContext('2d');
                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: years,
                        datasets: [{
                            label: 'Produksi',
                            data: production,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna merah transparan
                            borderColor: 'rgba(255, 99, 132, 1)', // Warna garis merah
                            borderWidth: 3, // Menebalkan garis produksi
                            tension: 0, // Garis tidak bergelombang
                            fill: false
                        }, {
                            label: 'Prediksi',
                            data: prediction,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna biru transparan
                            borderColor: 'rgba(54, 162, 235, 1)', // Warna garis biru
                            borderWidth: 3, // Menebalkan garis prediksi
                            tension: 0, // Garis tidak bergelombang
                            fill: false
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
            }
        });
    </script>
@endsection
