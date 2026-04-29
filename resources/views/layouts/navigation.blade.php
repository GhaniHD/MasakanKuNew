@extends('layouts.app')

@section('content')
<style>
    /* CSS untuk mengganti warna latar belakang */
    .bg {
        background-color: #FF8C00; /* Oranye Tua */
    }
    /* CSS untuk mengganti warna tombol */
    .btn-primary {
        background-color: #413839 !important; /* Warna baru untuk tombol */
        border-color: #413839 !important; /* Border yang sama dengan warna latar tombol */
    }
    .btn-primary:hover {
        background-color: #2C2A29 !important; /* Warna untuk hover pada tombol */
        border-color: #2C2A29 !important; /* Border untuk hover pada tombol */
    }
    .btn-primary:active, .btn-primary:focus {
        background-color: #2C2A29 !important; /* Warna untuk active/focus pada tombol */
        border-color: #2C2A29 !important; /* Border untuk active/focus pada tombol */
        box-shadow: none !important; /* Hilangkan shadow default saat tombol di klik */
    }
</style>

<div class="container mt-4">
    <h1 class="text-center">Resep Makanan</h1>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <img src="path_to_image" class="card-img-top" alt="Food Recipe">
                <div class="card-body">
                    <h5 class="card-title">Nama Resep</h5>
                    <p class="card-text">Deskripsi singkat tentang resep makanan.</p>
                    <a href="#" class="btn btn-primary">Lihat Resep</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <img src="path_to_image" class="card-img-top" alt="Food Recipe">
                <div class="card-body">
                    <h5 class="card-title">Nama Resep</h5>
                    <p class="card-text">Deskripsi singkat tentang resep makanan.</p>
                    <a href="#" class="btn btn-primary">Lihat Resep</a>
                </div>
            </div>
        </div>
        <!-- Tambahkan card lainnya sesuai kebutuhan -->
    </div>
</div>
@endsection
