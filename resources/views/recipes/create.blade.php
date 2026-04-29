@extends('layouts.app')

@section('content')
<div class="container-md mt-4">
    <h1 class="text-center">Tulis Resep Baru</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('recipes.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Resep</a>

    <form action="{{ route('recipes.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="text-center mb-4">
            <div class="upload-cover-image" style="position: relative;">
                <label for="cover_image" class="d-block">
                    <img id="placeholder_image" src="{{ asset('images/kamera.png') }}" alt="Tambah Foto Resep"
                        style="cursor: pointer; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                </label>
                <input type="file" id="cover_image" name="cover_image" accept="image/*" style="display: none;" required>
                <img id="preview_cover_image" src="#" alt="Preview Cover Image"
                    style="display: none; width: 160px; height: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            </div>
            <div class="tulisan">
                <h5>Tambahkan foto resep</h5>
                <p>Tampilkan foto yang telah disajikan</p>
            </div>
            @error('cover_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">
                Informasi Resep
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Resep</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="ayam">Ayam</option>
                            <option value="bayi dan anak">Bayi dan Anak</option>
                            <option value="cemilan">Cemilan</option>
                            <option value="kue">Kue</option>
                            <option value="ikan">Ikan</option>
                            <option value="eskrim">Es Krim</option>
                            <option value="mie">Mie</option>
                            <option value="minuman">Minuman</option>
                            <option value="sate">Sate</option>
                            <option value="salad">Salad</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="servings">Jumlah Porsi</label>
                                <input type="number" class="form-control" id="servings" name="servings"
                                    value="{{ old('servings') }}" min="1" required>
                                @error('servings')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="cooking_time">Durasi Memasak (menit)</label>
                                <input type="number" class="form-control" id="cooking_time" name="cooking_time"
                                    value="{{ old('cooking_time') }}" min="0" required>
                                @error('cooking_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">
                Bahan-bahan
            </div>
            <div class="card-body">
                <div id="ingredientList">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="ingredients[]" placeholder="Masukkan bahan"
                            required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="button"
                                onclick="removeIngredient(this)">Hapus</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary mt-2" type="button" onclick="addIngredient()">Tambah
                    Bahan</button>
                @error('ingredients')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">
                Instruksi dan Gambar Resep
            </div>
            <div class="card-body">
                <div id="instructionList">
                    <div class="instruction-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="circle-number">
                                <span>1</span>
                            </div>
                            <div class="flex-grow-1 ml-3">
                                <textarea class="form-control mb-2" name="instructions[]"
                                    placeholder="Masukkan instruksi" rows="3" required></textarea>
                                <input type="file" class="form-control-file mb-2" name="instruction_images_1[]"
                                    multiple>
                                <div class="text-right">
                                    <button class="btn btn-outline-danger mt-2" type="button"
                                        onclick="removeInstruction(this)">Hapus Instruksi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary mt-2" type="button" onclick="addInstruction()">Tambah
                    Instruksi</button>
                @error('instructions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-4">Tambahkan Resep</button>
        </div>
    </form>
</div>

<script>
    function addIngredient() {
        const ingredientList = document.getElementById('ingredientList');
        const newIngredient = document.createElement('div');
        newIngredient.className = 'input-group mb-2';
        newIngredient.innerHTML = `
            <input type="text" class="form-control" name="ingredients[]" placeholder="Masukkan bahan" required>
            <div class="input-group-append">
                <button class="btn btn-outline-danger" type="button" onclick="removeIngredient(this)">Hapus</button>
            </div>
        `;
        ingredientList.appendChild(newIngredient);
    }

    function removeIngredient(button) {
        button.parentElement.parentElement.remove();
    }

    function addInstruction() {
        const instructionList = document.getElementById('instructionList');
        const instructionCount = instructionList.getElementsByClassName('instruction-item').length + 1;
        const newInstruction = document.createElement('div');
        newInstruction.className = 'instruction-item mb-3';
        newInstruction.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="circle-number">
                    <span>${instructionCount}</span>
                </div>
                <div class="flex-grow-1 ml-3">
                    <textarea class="form-control mb-2" name="instructions[]" placeholder="Masukkan instruksi" rows="3" required></textarea>
                    <input type="file" class="form-control-file mb-2" name="instruction_images_${instructionCount}[]" multiple>
                    <div class="text-right">
                        <button class="btn btn-outline-danger mt-2" type="button" onclick="removeInstruction(this)">Hapus Instruksi</button>
                    </div>
                </div>
            </div>
        `;
        instructionList.appendChild(newInstruction);
        updateInstructionLabels();
    }

    function removeInstruction(button) {
        button.closest('.instruction-item').remove();
        updateInstructionLabels();
    }

    function updateInstructionLabels() {
        const instructionItems = document.getElementsByClassName('instruction-item');
        for (let i = 0; i < instructionItems.length; i++) {
            instructionItems[i].querySelector('.circle-number span').innerText = i + 1;
        }
    }

    document.getElementById('cover_image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const imgElement = document.getElementById('preview_cover_image');
            imgElement.src = e.target.result;
            imgElement.style.display = 'block'; // Menampilkan gambar yang dipilih
            document.getElementById('placeholder_image').style.display = 'none'; // Sembunyikan gambar placeholder
        }

        reader.readAsDataURL(file);
    });
</script>

<style>
    .circle-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
    }

    .tulisan {
        margin-top: 70px;
    }

    body {
        background-color: #FFFAF0;
    }

    .btn-primary {
        background-color: #FBB917 !important;
        border-color: #FBB917 !important;
    }

    .btn-primary:hover {
        background-color: #C8B560 !important;
        border-color: #C8B560 !important;
    }

    .btn-primary:active,
    .btn-primary:focus {
        background-color: #C8B560 !important;
        border-color: #C8B560 !important;
        box-shadow: none !important;
    }

    .upload-cover-image {
        display: inline-block;
        text-align: center;
    }

    .upload-cover-image img {
        width: 160px;
        height: auto;
        opacity: 0.5;
    }

    .upload-cover-image label:hover img {
        opacity: 1;
    }

    .upload-cover-image h5 {
        margin-top: 10px;
        font-weight: bold;
    }

    .upload-cover-image p {
        margin: 0;
        color: #666;
    }
</style>
@endsection