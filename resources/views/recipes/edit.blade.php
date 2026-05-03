@extends('layouts.app')

@section('content')
<div class="container-md mt-4">
    <h1 class="text-center">Edit Resep</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('recipes.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Resep</a>

    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Cover Image --}}
        <div class="text-center mb-4">
            <div class="upload-cover-image" style="position: relative;">
                <label for="cover_image" class="d-block">
                    <img id="placeholder_image"
                         src="{{ $recipe->image
                                ? (str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image))
                                : asset('images/kamera.png') }}"
                         alt="Foto Resep"
                         style="cursor: pointer; width: 160px; height: auto; opacity: {{ $recipe->image ? '1' : '0.5' }};">
                </label>
                <input type="file" id="cover_image" name="cover_image" accept="image/*" style="display: none;">
                <img id="preview_cover_image" src="#" alt="Preview Cover Image"
                     style="display: none; width: 160px; height: auto;">
            </div>
            <div class="tulisan">
                <h5>{{ $recipe->image ? 'Ganti foto resep' : 'Tambahkan foto resep' }}</h5>
                <p>Tampilkan foto yang telah disajikan</p>
            </div>
            @error('cover_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Informasi Resep --}}
        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">Informasi Resep</div>
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Nama Resep</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $recipe->name) }}" required>
                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $recipe->description) }}</textarea>
                    @error('description')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach(['ayam' => 'Ayam', 'bayi dan anak' => 'Bayi dan Anak', 'cemilan' => 'Cemilan',
                                  'kue' => 'Kue', 'ikan' => 'Ikan', 'eskrim' => 'Es Krim',
                                  'mie' => 'Mie', 'minuman' => 'Minuman', 'sate' => 'Sate', 'salad' => 'Salad'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('category', $recipe->category) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="servings">Jumlah Porsi</label>
                            <input type="number" class="form-control" id="servings" name="servings"
                                   value="{{ old('servings', $recipe->servings) }}" min="1" required>
                            @error('servings')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cooking_time">Durasi Memasak (menit)</label>
                            <input type="number" class="form-control" id="cooking_time" name="cooking_time"
                                   value="{{ old('cooking_time', $recipe->cooking_time) }}" min="0" required>
                            @error('cooking_time')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Bahan-bahan --}}
        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">Bahan-bahan</div>
            <div class="card-body">
                <div id="ingredientList">
                    @php
                        $ingredients = old('ingredients')
                            ?? (is_array($recipe->ingredients)
                                ? $recipe->ingredients
                                : json_decode($recipe->ingredients, true) ?? []);
                    @endphp

                    @forelse($ingredients as $ingredient)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="ingredients[]"
                                   value="{{ $ingredient }}" placeholder="Masukkan bahan" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger" type="button"
                                        onclick="removeIngredient(this)">Hapus</button>
                            </div>
                        </div>
                    @empty
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="ingredients[]"
                                   placeholder="Masukkan bahan" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger" type="button"
                                        onclick="removeIngredient(this)">Hapus</button>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button class="btn btn-outline-secondary mt-2" type="button"
                        onclick="addIngredient()">Tambah Bahan</button>
                @error('ingredients')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Instruksi --}}
        <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">Instruksi dan Gambar Resep</div>
            <div class="card-body">
                <div id="instructionList">
                    @php
                        // Ambil dari tabel instructions (relasi), bukan kolom steps/JSON
                        $existingInstructions = $recipe->instructionItems ?? $recipe->instructions()->get();
                        $oldInstructions = old('instructions');
                    @endphp

                    @if($oldInstructions)
                        @foreach($oldInstructions as $key => $instrText)
                            <div class="instruction-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="circle-number"><span>{{ $key + 1 }}</span></div>
                                    <div class="flex-grow-1 ml-3">
                                        <textarea class="form-control mb-2" name="instructions[]"
                                                  placeholder="Masukkan instruksi" rows="3" required>{{ $instrText }}</textarea>
                                        <input type="file" class="form-control-file mb-2"
                                               name="instruction_images_{{ $key + 1 }}[]" multiple>
                                        <div class="text-right">
                                            <button class="btn btn-outline-danger mt-2" type="button"
                                                    onclick="removeInstruction(this)">Hapus Instruksi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif($existingInstructions->count() > 0)
                        @foreach($existingInstructions as $key => $instrItem)
                            <div class="instruction-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="circle-number"><span>{{ $key + 1 }}</span></div>
                                    <div class="flex-grow-1 ml-3">
                                        <textarea class="form-control mb-2" name="instructions[]"
                                                  placeholder="Masukkan instruksi" rows="3" required>{{ $instrItem->nama }}</textarea>
                                        {{-- Tampilkan gambar lama jika ada --}}
                                        @if($instrItem->image)
                                            <div class="mb-2">
                                                <small class="text-muted">Gambar saat ini:</small><br>
                                                <img src="{{ $instrItem->image }}"
     style="height: 80px; border-radius: 4px; margin-top: 4px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control-file mb-2"
                                               name="instruction_images_{{ $key + 1 }}[]" multiple>
                                        <div class="text-right">
                                            <button class="btn btn-outline-danger mt-2" type="button"
                                                    onclick="removeInstruction(this)">Hapus Instruksi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="instruction-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="circle-number"><span>1</span></div>
                                <div class="flex-grow-1 ml-3">
                                    <textarea class="form-control mb-2" name="instructions[]"
                                              placeholder="Masukkan instruksi" rows="3" required></textarea>
                                    <input type="file" class="form-control-file mb-2"
                                           name="instruction_images_1[]" multiple>
                                    <div class="text-right">
                                        <button class="btn btn-outline-danger mt-2" type="button"
                                                onclick="removeInstruction(this)">Hapus Instruksi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button class="btn btn-outline-secondary mt-2" type="button"
                        onclick="addInstruction()">Tambah Instruksi</button>
                @error('instructions')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-4">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    function addIngredient() {
        const list = document.getElementById('ingredientList');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="ingredients[]" placeholder="Masukkan bahan" required>
            <div class="input-group-append">
                <button class="btn btn-outline-danger" type="button" onclick="removeIngredient(this)">Hapus</button>
            </div>`;
        list.appendChild(div);
    }

    function removeIngredient(button) {
        button.parentElement.parentElement.remove();
    }

    function addInstruction() {
        const list = document.getElementById('instructionList');
        const count = list.getElementsByClassName('instruction-item').length + 1;
        const div = document.createElement('div');
        div.className = 'instruction-item mb-3';
        div.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="circle-number"><span>${count}</span></div>
                <div class="flex-grow-1 ml-3">
                    <textarea class="form-control mb-2" name="instructions[]"
                              placeholder="Masukkan instruksi" rows="3" required></textarea>
                    <input type="file" class="form-control-file mb-2"
                           name="instruction_images_${count}[]" multiple>
                    <div class="text-right">
                        <button class="btn btn-outline-danger mt-2" type="button"
                                onclick="removeInstruction(this)">Hapus Instruksi</button>
                    </div>
                </div>
            </div>`;
        list.appendChild(div);
        updateInstructionLabels();
    }

    function removeInstruction(button) {
        button.closest('.instruction-item').remove();
        updateInstructionLabels();
    }

    function updateInstructionLabels() {
        const items = document.getElementsByClassName('instruction-item');
        for (let i = 0; i < items.length; i++) {
            items[i].querySelector('.circle-number span').innerText = i + 1;
        }
    }

    document.getElementById('cover_image').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            const img = document.getElementById('preview_cover_image');
            const placeholder = document.getElementById('placeholder_image');
            img.src = ev.target.result;
            img.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(e.target.files[0]);
    });

    updateInstructionLabels();
</script>

<style>
    .circle-number {
        width: 40px; height: 40px; border-radius: 50%;
        background-color: #f0f0f0; display: flex;
        align-items: center; justify-content: center;
        font-size: 18px; font-weight: bold;
    }
    .tulisan { margin-top: 70px; }
    body { background-color: #FFFAF0; }
    .btn-primary { background-color: #FBB917 !important; border-color: #FBB917 !important; }
    .btn-primary:hover { background-color: #C8B560 !important; border-color: #C8B560 !important; }
    .btn-primary:active, .btn-primary:focus {
        background-color: #C8B560 !important; border-color: #C8B560 !important; box-shadow: none !important;
    }
    .upload-cover-image { display: inline-block; text-align: center; }
    .upload-cover-image img { width: 160px; height: auto; }
    .upload-cover-image h5 { margin-top: 10px; font-weight: bold; }
    .upload-cover-image p { margin: 0; color: #666; }
</style>
@endsection
