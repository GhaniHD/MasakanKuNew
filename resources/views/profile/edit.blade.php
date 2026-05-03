@extends('layouts.app')

@section('content')

<style>
  :root {
    --primary: #FFBD59;
    --primary-dark: #e5a805;
    --text-dark: #1a1a2e;
    --text-mid: #555;
    --text-light: #999;
    --border: #f0f0f0;
    --shadow-sm: 0 2px 12px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 24px rgba(0,0,0,0.13);
    --radius: 12px;
    --radius-sm: 8px;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  .profile-page-wrapper {
    max-width: 760px;
    margin: 0 auto;
    padding: 32px 16px 48px;
    font-family: 'Nunito', sans-serif;
  }

  .profile-section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 1rem; font-weight: 700; color: var(--text-dark);
    margin-bottom: 20px;
  }
  .profile-section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

  /* ===== Profile Header ===== */
  .profile-header {
    background: #fff;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    padding: 28px;
    display: flex;
    align-items: center;
    gap: 24px;
    margin-bottom: 24px;
  }

  .profile-avatar-wrap {
    position: relative; flex-shrink: 0;
    width: 88px; height: 88px;
    cursor: pointer;
  }
  .profile-avatar-wrap img {
    width: 88px; height: 88px;
    border-radius: 50%; object-fit: cover;
    border: 3px solid var(--primary);
    display: block;
    transition: filter 0.2s;
  }
  .profile-avatar-wrap:hover img { filter: brightness(0.72); }

  .profile-avatar-overlay {
    position: absolute; inset: 0;
    border-radius: 50%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 3px; opacity: 0;
    transition: opacity 0.2s;
    pointer-events: none;
  }
  .profile-avatar-wrap:hover .profile-avatar-overlay { opacity: 1; }
  .profile-avatar-overlay i    { color: #fff; font-size: 1.1rem; }
  .profile-avatar-overlay span { color: #fff; font-size: 0.62rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; }

  .profile-header-info h2 { font-size: 1.15rem; font-weight: 800; color: var(--text-dark); }
  .profile-header-info p  { font-size: 0.82rem; color: var(--text-light); margin-top: 4px; }

  /* ===== Card ===== */
  .profile-card {
    background: #fff;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    padding: 24px 28px;
    margin-bottom: 20px;
  }

  /* ===== Alert ===== */
  .profile-alert {
    padding: 10px 14px;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
  }
  .profile-alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
  .profile-alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

  /* ===== Form ===== */
  .profile-form-group { margin-bottom: 16px; }
  .profile-form-group label {
    display: block;
    font-size: 0.78rem; font-weight: 700;
    color: var(--text-mid);
    letter-spacing: 0.04em; text-transform: uppercase;
    margin-bottom: 6px;
  }
  .profile-form-group input[type="text"],
  .profile-form-group input[type="email"],
  .profile-form-group input[type="password"] {
    width: 100%;
    padding: 10px 14px;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--border);
    font-size: 0.9rem; color: var(--text-dark);
    background: #fafafa;
    font-family: 'Nunito', sans-serif;
    transition: border-color 0.2s;
    outline: none;
  }
  .profile-form-group input:focus { border-color: var(--primary); background: #fff; }
  .profile-field-error { font-size: 0.78rem; color: #c0392b; margin-top: 5px; }

  .profile-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

  /* ===== Buttons ===== */
  .profile-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 26px;
    border-radius: var(--radius-sm); border: none;
    font-size: 0.85rem; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
    cursor: pointer;
    transition: background 0.22s, transform 0.15s;
    font-family: 'Nunito', sans-serif;
  }
  .profile-btn-primary { background: var(--primary); color: var(--text-dark); }
  .profile-btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
  .profile-btn-danger  { background: #fdecea; color: #c0392b; border: 1.5px solid #f5c6c6; }
  .profile-btn-danger:hover  { background: #f9d0cc; }
  .profile-btn-ghost   { background: transparent; color: var(--text-mid); border: 1.5px solid var(--border); }
  .profile-btn-ghost:hover { background: #f5f5f5; }

  /* ===== Favorites Link ===== */
  .profile-fav-link {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px; background: #fff;
    border-radius: var(--radius);
    border: 1.5px dashed var(--primary);
    color: var(--primary-dark);
    font-weight: 700; font-size: 0.88rem;
    text-decoration: none; margin-bottom: 20px;
    transition: background 0.2s;
    font-family: 'Nunito', sans-serif;
  }
  .profile-fav-link:hover { background: #fff8e7; color: var(--primary-dark); }

  /* ===== Danger Zone ===== */
  .profile-danger-zone {
    border: 1.5px solid #fca5a5;
    border-radius: var(--radius);
    padding: 20px 24px; background: #fff;
    margin-bottom: 20px;
  }
  .profile-danger-zone .profile-section-title { color: #c0392b; }
  .profile-danger-zone .profile-section-title::after { background: #fca5a5; }

  /* ===== MODAL ===== */
  #profileAvatarModal {
    position: fixed !important;
    top: 0 !important; left: 0 !important;
    width: 100vw !important; height: 100vh !important;
    background: rgba(0,0,0,0.5) !important;
    z-index: 99999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
    transition: opacity 0.22s ease, visibility 0.22s ease;
  }
  #profileAvatarModal.is-open {
    visibility: visible !important;
    opacity: 1 !important;
    pointer-events: auto !important;
  }

  .profile-modal-box {
    background: #fff;
    border-radius: var(--radius);
    padding: 28px 28px 24px;
    width: 100%; max-width: 380px;
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.22s ease;
    position: relative;
    z-index: 100000;
  }
  #profileAvatarModal.is-open .profile-modal-box { transform: scale(1); }

  .profile-modal-preview {
    width: 96px; height: 96px;
    border-radius: 50%; object-fit: cover;
    border: 3px solid var(--primary);
    margin: 0 auto 16px; display: block;
  }
  .profile-modal-box h3 { font-size: 1rem; font-weight: 800; color: var(--text-dark); margin-bottom: 6px; font-family: 'Nunito', sans-serif; }
  .profile-modal-box p  { font-size: 0.83rem; color: var(--text-light); margin-bottom: 20px; line-height: 1.5; font-family: 'Nunito', sans-serif; }
  .profile-modal-actions { display: flex; gap: 10px; justify-content: center; }

  @media (max-width: 520px) {
    .profile-two-col { grid-template-columns: 1fr; }
    .profile-header { flex-direction: column; text-align: center; }
  }
</style>

@php
  use Illuminate\Support\Str;
  $avatarUrl = $user->profile_picture_url
    ? (Str::startsWith($user->profile_picture_url, 'http')
        ? $user->profile_picture_url
        : asset($user->profile_picture_url))
    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFBD59&color=1a1a2e&size=128';
@endphp

<div class="profile-page-wrapper">

  {{-- ===== Profile Header ===== --}}
  <div class="profile-header">
    <div class="profile-avatar-wrap" id="profileAvatarTrigger" title="Klik untuk ganti foto">
      <img src="{{ $avatarUrl }}" alt="Foto Profil" id="profileAvatarHeaderImg">
      <div class="profile-avatar-overlay">
        <i class="fas fa-camera"></i>
        <span>Ganti Foto</span>
      </div>
    </div>
    <div class="profile-header-info">
      <h2>{{ $user->name }}</h2>
      <p>{{ $user->email }}</p>
    </div>
  </div>

  {{-- ===== Flash Status ===== --}}
  @if (session('status') === 'profile-updated')
    <div class="profile-alert profile-alert-success">
      <i class="fas fa-check-circle"></i> Profil berhasil diperbarui.
    </div>
  @elseif (session('status') === 'profile-picture-updated')
    <div class="profile-alert profile-alert-success">
      <i class="fas fa-check-circle"></i> Foto profil berhasil diperbarui.
    </div>
  @endif

  {{-- ===== Informasi Pribadi ===== --}}
  <div class="profile-card">
    <h3 class="profile-section-title"><i class="fas fa-user"></i> Informasi Pribadi</h3>
    <form action="{{ route('profile.update') }}" method="POST">
      @csrf
      @method('PATCH')
      <div class="profile-two-col">
        <div class="profile-form-group">
          <label for="profileName">Nama</label>
          <input type="text" name="name" id="profileName" value="{{ old('name', $user->name) }}">
          @error('name')
            <p class="profile-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
          @enderror
        </div>
        <div class="profile-form-group">
          <label for="profileEmail">Email</label>
          <input type="email" name="email" id="profileEmail" value="{{ old('email', $user->email) }}">
          @error('email')
            <p class="profile-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
          @enderror
        </div>
      </div>
      <button type="submit" class="profile-btn profile-btn-primary">
        <i class="fas fa-save"></i> Simpan Perubahan
      </button>
    </form>
  </div>

  {{-- ===== Lihat Favorit ===== --}}
  <a href="{{ route('profile.favorites') }}" class="profile-fav-link">
    <i class="fas fa-heart" style="color:#e74c3c;"></i> Lihat Resep Favorit Saya
  </a>

  {{-- ===== Hapus Akun ===== --}}
  <div class="profile-danger-zone">
    <h3 class="profile-section-title"><i class="fas fa-exclamation-triangle"></i> Hapus Akun</h3>
    <p style="font-size:0.83rem; color:var(--text-mid); margin-bottom:16px; line-height:1.6;">
      Tindakan ini tidak dapat dibatalkan. Seluruh data, resep, dan favorit akan dihapus secara permanen.
    </p>

    @if ($errors->userDeletion->any())
      <div class="profile-alert profile-alert-error">
        <i class="fas fa-times-circle"></i> {{ $errors->userDeletion->first('password') }}
      </div>
    @endif

    <form action="{{ route('profile.destroy') }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="profile-form-group" style="max-width:320px;">
        <label for="profilePasswordDelete">Konfirmasi Password</label>
        <input type="password" name="password" id="profilePasswordDelete" placeholder="••••••••">
      </div>
      <button type="submit" class="profile-btn profile-btn-danger">
        <i class="fas fa-trash"></i> Hapus Akun Saya
      </button>
    </form>
  </div>

</div>

{{-- ===== Modal Ganti Foto ===== --}}
<div id="profileAvatarModal">
  <div class="profile-modal-box">
    <img src="{{ $avatarUrl }}" alt="Preview" class="profile-modal-preview" id="profileModalPreviewImg">
    <h3>Ganti Foto Profil?</h3>
    <p id="profileModalFileName">Pilih foto baru dari perangkatmu</p>
    <div class="profile-modal-actions">
      <button type="button" class="profile-btn profile-btn-ghost" id="profileModalCancel">
        <i class="fas fa-times"></i> Batal
      </button>
      <button type="button" class="profile-btn profile-btn-primary" id="profileModalConfirm">
        <i class="fas fa-check"></i> Ya, Ganti
      </button>
    </div>
  </div>
</div>

{{-- Hidden file input & upload form --}}
<input type="file" id="profileHiddenFileInput" accept="image/jpeg,image/png,image/jpg,image/gif" style="display:none;">
<form id="profileUploadForm" action="{{ route('profile.update.picture') }}" method="POST"
      enctype="multipart/form-data" style="display:none;">
  @csrf
  <input type="file" name="profile_picture" id="profileFormFileInput">
</form>

<script>
(function () {
  const trigger     = document.getElementById('profileAvatarTrigger');
  const fileInput   = document.getElementById('profileHiddenFileInput');
  const modal       = document.getElementById('profileAvatarModal');
  const preview     = document.getElementById('profileModalPreviewImg');
  const fileName    = document.getElementById('profileModalFileName');
  const btnCancel   = document.getElementById('profileModalCancel');
  const btnConfirm  = document.getElementById('profileModalConfirm');
  const uploadForm  = document.getElementById('profileUploadForm');
  const formFile    = document.getElementById('profileFormFileInput');
  const headerImg   = document.getElementById('profileAvatarHeaderImg');

  let selectedFile  = null;

  function openModal() {
    modal.classList.add('is-open');
    modal.style.setProperty('visibility', 'visible', 'important');
    modal.style.setProperty('opacity', '1', 'important');
    modal.style.setProperty('pointer-events', 'auto', 'important');
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.style.setProperty('visibility', 'hidden', 'important');
    modal.style.setProperty('opacity', '0', 'important');
    modal.style.setProperty('pointer-events', 'none', 'important');
    fileInput.value = '';
    selectedFile = null;
  }

  // Klik avatar → buka file picker
  trigger.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    fileInput.click();
  });

  // File dipilih → tampilkan preview & buka modal
  fileInput.addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;
    selectedFile = this.files[0];

    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
    };
    reader.readAsDataURL(selectedFile);

    fileName.textContent = selectedFile.name;
    openModal();
  });

  // Tombol Batal
  btnCancel.addEventListener('click', closeModal);

  // Klik backdrop → tutup
  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeModal();
  });

  // Tombol Konfirmasi → submit
  btnConfirm.addEventListener('click', function () {
    if (!selectedFile) return;

    try {
      const dt = new DataTransfer();
      dt.items.add(selectedFile);
      formFile.files = dt.files;
    } catch (err) {
      console.warn('DataTransfer error:', err);
    }

    headerImg.src = preview.src;
    closeModal();
    uploadForm.submit();
  });
})();
</script>

@endsection
