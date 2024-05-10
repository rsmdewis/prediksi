@extends('layout.main')

@section('title', 'Dashboard')
@section('content')
<section class="content">
                <h3>Dashboard</h3>
</section>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Kecamatan</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalKecamatan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary text-white clearfix small z-1">
                <a href="{{ route('kecamatan.index') }}" class="text-white float-left">More info</a>
                <span class="float-right">
                    <i class="fas fa-arrow-circle-right"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Data Aktual</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalData}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success text-white clearfix small z-1">
                <a href="{{ route('data.index') }}" class="text-white float-left">More info</a>
                <span class="float-right">
                    <i class="fas fa-arrow-circle-right"></i>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
