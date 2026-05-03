@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card mx-auto mb-4" style="max-width: 30rem;">
        <div class="card-body text-center">
            <h5 class="card-title">Simpan semua masakanmu dalam satu tempat</h5>
            <p class="card-text">Dan bagikan dengan teman dan keluarga</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">Tambah Resep Baru</a>
        </div>
    </div>

    <h2 class="text-center medium">Daftar Resep Anda</h2>

    @if (session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
            <br>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary mt-2">Tulis Resep Lainnya</a>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    @if($recipes->isEmpty())
        <div class="alert alert-warning">
            Tidak ada resep yang ditemukan.
        </div>
    @else
        <div class="row">
            @foreach($recipes as $recipe)
                <div class="col-md-4">
                    <div class="card mb-4 recipe-card">
                        @if($recipe->image)
                            <img src="{{ str_starts_with($recipe->image, 'http')
                                            ? $recipe->image
                                            : asset('storage/' . $recipe->image) }}"
                                 class="card-img-top recipe-image"
                                 alt="{{ $recipe->name }}">
                        @else
                            <img src="{{ asset('images/default-recipe.png') }}"
                                 class="card-img-top recipe-image"
                                 alt="{{ $recipe->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                            <p class="card-text">{{ Str::limit($recipe->description, 80) }}</p>
                            <div class="d-flex gap-1 flex-wrap mt-2">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary btn-sm">Lihat Resep</a>
                                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    onclick="setDeleteAction('{{ route('recipes.destroy', $recipe->id) }}')">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Hapus (Bootstrap 5) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        background-color: #FBB917 !important;
        border-color: #FBB917 !important;
    }
    .btn-primary:hover {
        background-color: #C8B560 !important;
        border-color: #C8B560 !important;
    }
    .btn-primary:active, .btn-primary:focus {
        background-color: #C8B560 !important;
        border-color: #C8B560 !important;
        box-shadow: none !important;
    }
    .recipe-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .recipe-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

<script>
    function setDeleteAction(action) {
        document.getElementById('deleteForm').action = action;
    }
</script>
@endsection
