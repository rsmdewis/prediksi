@extends('layout.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-4 text-gray-800">Profil</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-edit"></i>
                </span>
                <span class="text">Ubah Profil</span>
            </a>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <p class="card-text"><strong>Nama:</strong> {{ $user->name }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                    <!-- Tambahkan informasi profil lainnya yang Anda perlukan -->
                </div>
            </div>
        </div>
    </div>
@endsection
