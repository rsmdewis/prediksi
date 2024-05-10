
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
<br>
<br><br>
    
@endsection
