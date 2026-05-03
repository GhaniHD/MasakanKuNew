@extends('layouts.app')

@section('content')

<style>
  :root {
    --primary: #FBB917;
    --primary-dark: #C8B560;
    --bg: #FFFAF0;
    --radius: 12px;
    --border: #e8e8e8;
    font-family: 'Nunito', sans-serif;
  }

  *, *::before, *::after { box-sizing: border-box; }

  body { background-color: var(--bg); }

  .page-wrapper {
    max-width: 820px;
    margin: 0 auto;
    padding: 24px 16px 48px;
  }

  .page-title {
    text-align: center;
    font-size: 1.6rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 24px;
  }

  /* ===== COVER UPLOAD ===== */
  .cover-upload-area {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    background: #fff;
    text-align: center;
    padding: 32px 20px;
    margin-bottom: 24px;
    cursor: pointer;
    transition: border-color 0.25s;
    position: relative;
  }

  .cover-upload-area:hover { border-color: var(--primary); }

  .cover-upload-area img.placeholder {
    width: 64px;
    opacity: 0.4;
    margin-bottom: 10px;
  }

  .cover-upload-area img#preview_cover_image {
    max-width: 100%;
    max-height: 260px;
    border-radius: 8px;
    display: none;
    margin: 0 auto 10px;
  }

  .cover-upload-area h5 { font-weight: 700; margin: 0 0 4px; color: #333; }
  .cover-upload-area p  { color: #999; font-size: 0.85rem; margin: 0; }

  /* ===== CARDS ===== */
  .form-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 20px;
    overflow: hidden;
  }

  .form-card-header {
    background: #fafafa;
    border-bottom: 1px solid var(--border);
    padding: 14px 20px;
    font-weight: 700;
    font-size: 0.95rem;
    color: #1a1a2e;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-card-header i { color: var(--primary); }

  .form-card-body { padding: 20px; }

  /* ===== FORM ELEMENTS ===== */
  .form-group { margin-bottom: 16px; }
  .form-group:last-child { margin-bottom: 0; }

  label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: #444;
    margin-bottom: 6px;
  }

  .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 0.9rem;
    font-family: 'Nunito', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
  }

  .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(251,185,23,0.15);
  }

  textarea.form-control { resize: vertical; min-height: 90px; }

  /* Category input wrapper */
  .category-wrap { position: relative; }

  .category-wrap input {
    padding-right: 40px;
  }

  .category-tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
  }

  .cat-suggestion {
    background: #f5f5f5;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    color: #555;
    transition: all 0.2s;
    white-space: nowrap;
  }

  .cat-suggestion:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
  }

  .cat-hint {
    font-size: 0.75rem;
    color: #aaa;
    margin-top: 6px;
    margin-bottom: 0;
  }

  /* Two-column row */
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

  /* ===== INGREDIENTS ===== */
  .ingredient-row {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
    align-items: center;
  }

  .ingredient-row input { flex: 1; }

  .btn-remove {
    background: #fff;
    border: 1px solid #fcc;
    color: #e74c3c;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.2s;
    flex-shrink: 0;
  }

  .btn-remove:hover { background: #fff0f0; }

  .btn-add {
    background: #fff;
    border: 1px dashed #bbb;
    color: #666;
    border-radius: 8px;
    padding: 9px 18px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 4px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .btn-add:hover { border-color: var(--primary); color: var(--primary); }

  /* ===== INSTRUCTIONS ===== */
  .instruction-item {
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 14px;
    background: #fafafa;
  }

  .instruction-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .step-number {
    width: 36px; height: 36px;
    background: var(--primary);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
    color: #fff;
    flex-shrink: 0;
  }

  .instruction-footer { text-align: right; margin-top: 8px; }

  /* ===== SUBMIT ===== */
  .btn-submit {
    display: block;
    width: 100%;
    max-width: 320px;
    margin: 28px auto 0;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 14px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 0.04em;
    transition: background 0.25s;
  }

  .btn-submit:hover { background: var(--primary-dark); }

  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #888;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    margin-bottom: 20px;
    transition: color 0.2s;
  }

  .btn-back:hover { color: #333; }

  .text-danger { color: #e74c3c; font-size: 0.8rem; margin-top: 4px; }

  .alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 0.9rem;
  }
</style>

<div class="page-wrapper">

  <a href="{{ route('recipes.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Resep
  </a>

  <h1 class="page-title">Tulis Resep Baru</h1>

  @if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ===== COVER IMAGE ===== --}}
    <label for="cover_image" style="cursor:pointer;">
      <div class="cover-upload-area" id="dropArea">
        <img src="{{ asset('images/kamera.png') }}" class="placeholder" id="placeholder_image" alt="Upload">
        <img id="preview_cover_image" src="#" alt="Preview">
        <h5>Tambahkan foto resep</h5>
        <p>Klik untuk memilih gambar • JPG, PNG, GIF maks 2MB</p>
      </div>
    </label>
    <input type="file" id="cover_image" name="cover_image" accept="image/*" style="display:none;" required>
    @error('cover_image') <div class="text-danger">{{ $message }}</div> @enderror

    {{-- ===== INFORMASI RESEP ===== --}}
    <div class="form-card">
      <div class="form-card-header"><i class="fas fa-info-circle"></i> Informasi Resep</div>
      <div class="form-card-body">

        <div class="form-group">
          <label for="name">Nama Resep <span style="color:#e74c3c">*</span></label>
          <input type="text" class="form-control" id="name" name="name"
                 value="{{ old('name') }}" placeholder="Contoh: Ayam Bakar Madu" required>
          @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="description">Deskripsi <span style="color:#e74c3c">*</span></label>
          <textarea class="form-control" id="description" name="description"
                    placeholder="Ceritakan sedikit tentang resep ini..." required>{{ old('description') }}</textarea>
          @error('description') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- KATEGORI DINAMIS --}}
        <div class="form-group">
          <label for="category">Kategori <span style="color:#e74c3c">*</span></label>
          <div class="category-wrap">
            <input type="text" class="form-control" id="category" name="category"
                   value="{{ old('category') }}"
                   placeholder="Ketik atau pilih kategori di bawah..."
                   list="category-suggestions" autocomplete="off" required>
            {{-- Datalist dari kategori yang sudah ada di DB --}}
            <datalist id="category-suggestions">
              @foreach ($existingCategories as $cat)
                <option value="{{ $cat }}">
              @endforeach
            </datalist>
          </div>
          {{-- Chip shortcuts dari kategori yang sudah ada --}}
          @if ($existingCategories->isNotEmpty())
            <div class="category-tag-list">
              @foreach ($existingCategories as $cat)
                <span class="cat-suggestion" onclick="setCategory('{{ $cat }}')">{{ ucfirst($cat) }}</span>
              @endforeach
            </div>
          @endif
          <p class="cat-hint">💡 Klik chip di atas untuk mengisi cepat, atau ketik kategori baru.</p>
          @error('category') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="servings">Jumlah Porsi <span style="color:#e74c3c">*</span></label>
            <input type="number" class="form-control" id="servings" name="servings"
                   value="{{ old('servings') }}" min="1" placeholder="Contoh: 4" required>
            @error('servings') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label for="cooking_time">Durasi Memasak (menit) <span style="color:#e74c3c">*</span></label>
            <input type="number" class="form-control" id="cooking_time" name="cooking_time"
                   value="{{ old('cooking_time') }}" min="0" placeholder="Contoh: 30" required>
            @error('cooking_time') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
        </div>

      </div>
    </div>

    {{-- ===== BAHAN-BAHAN ===== --}}
    <div class="form-card">
      <div class="form-card-header"><i class="fas fa-list"></i> Bahan-bahan</div>
      <div class="form-card-body">
        <div id="ingredientList">
          <div class="ingredient-row">
            <input type="text" class="form-control" name="ingredients[]"
                   placeholder="Contoh: 500g ayam fillet" required>
            <button class="btn-remove" type="button" onclick="removeIngredient(this)">
              <i class="fas fa-times"></i> Hapus
            </button>
          </div>
        </div>
        <button class="btn-add" type="button" onclick="addIngredient()">
          <i class="fas fa-plus"></i> Tambah Bahan
        </button>
        @error('ingredients') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
    </div>

    {{-- ===== INSTRUKSI ===== --}}
    <div class="form-card">
      <div class="form-card-header"><i class="fas fa-tasks"></i> Langkah-langkah Memasak</div>
      <div class="form-card-body">
        <div id="instructionList">
          <div class="instruction-item">
            <div class="instruction-header">
              <div class="step-number">1</div>
              <span style="font-weight:700;color:#444;font-size:0.9rem;">Langkah 1</span>
            </div>
            <textarea class="form-control" name="instructions[]"
                      placeholder="Jelaskan langkah memasak..." rows="3" required></textarea>
            <input type="file" class="form-control" name="instruction_images_1[]"
                   multiple style="margin-top:10px;">
            <div class="instruction-footer">
              <button class="btn-remove" type="button" onclick="removeInstruction(this)">
                <i class="fas fa-times"></i> Hapus Langkah
              </button>
            </div>
          </div>
        </div>
        <button class="btn-add" type="button" onclick="addInstruction()">
          <i class="fas fa-plus"></i> Tambah Langkah
        </button>
        @error('instructions') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
    </div>

    <button type="submit" class="btn-submit">
      <i class="fas fa-check-circle"></i> Tambahkan Resep
    </button>

  </form>
</div>

<script>
  // ===== CATEGORY CHIP =====
  function setCategory(val) {
    document.getElementById('category').value = val;
  }

  // ===== COVER PREVIEW =====
  document.getElementById('cover_image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
      const preview = document.getElementById('preview_cover_image');
      preview.src = ev.target.result;
      preview.style.display = 'block';
      document.getElementById('placeholder_image').style.display = 'none';
    };
    reader.readAsDataURL(file);
  });

  // ===== INGREDIENTS =====
  function addIngredient() {
    const list = document.getElementById('ingredientList');
    const row = document.createElement('div');
    row.className = 'ingredient-row';
    row.innerHTML = `
      <input type="text" class="form-control" name="ingredients[]" placeholder="Contoh: 2 sdm kecap manis" required>
      <button class="btn-remove" type="button" onclick="removeIngredient(this)">
        <i class="fas fa-times"></i> Hapus
      </button>`;
    list.appendChild(row);
  }

  function removeIngredient(btn) {
    const rows = document.querySelectorAll('#ingredientList .ingredient-row');
    if (rows.length > 1) btn.closest('.ingredient-row').remove();
  }

  // ===== INSTRUCTIONS =====
  function addInstruction() {
    const list  = document.getElementById('instructionList');
    const count = list.querySelectorAll('.instruction-item').length + 1;
    const item  = document.createElement('div');
    item.className = 'instruction-item';
    item.innerHTML = `
      <div class="instruction-header">
        <div class="step-number">${count}</div>
        <span style="font-weight:700;color:#444;font-size:0.9rem;">Langkah ${count}</span>
      </div>
      <textarea class="form-control" name="instructions[]"
                placeholder="Jelaskan langkah memasak..." rows="3" required></textarea>
      <input type="file" class="form-control" name="instruction_images_${count}[]"
             multiple style="margin-top:10px;">
      <div class="instruction-footer">
        <button class="btn-remove" type="button" onclick="removeInstruction(this)">
          <i class="fas fa-times"></i> Hapus Langkah
        </button>
      </div>`;
    list.appendChild(item);
  }

  function removeInstruction(btn) {
    const items = document.querySelectorAll('#instructionList .instruction-item');
    if (items.length > 1) {
      btn.closest('.instruction-item').remove();
      updateStepNumbers();
    }
  }

  function updateStepNumbers() {
    document.querySelectorAll('#instructionList .instruction-item').forEach((item, i) => {
      item.querySelector('.step-number').textContent = i + 1;
      item.querySelector('span').textContent = `Langkah ${i + 1}`;
    });
  }
</script>

@endsection
