{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('content')

<style>
  :root {
    --primary: #FFBD59;
    --primary-dark: #e5a805;
    --text-dark: #1a1a2e;
    --text-mid: #555;
    --text-light: #999;
  }

  .notfound-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 16px;
    font-family: 'Nunito', sans-serif;
  }

  .notfound-box {
    text-align: center;
    max-width: 480px;
    width: 100%;
  }

  .notfound-illustration {
    margin: 0 auto 32px;
    width: 220px;
    height: 220px;
    position: relative;
  }

  .notfound-plate {
    width: 180px;
    height: 180px;
    background: #fff8e7;
    border-radius: 50%;
    border: 3px dashed var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
  }

  .notfound-plate i {
    font-size: 5rem;
    color: var(--primary);
    opacity: 0.5;
  }

  .notfound-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: var(--primary);
    color: var(--text-dark);
    font-size: 0.7rem;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.06em;
    font-family: 'Nunito', sans-serif;
  }

  .notfound-code {
    font-size: 5.5rem;
    font-weight: 900;
    color: var(--primary);
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -2px;
  }

  .notfound-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 12px;
  }

  .notfound-desc {
    font-size: 0.92rem;
    color: var(--text-light);
    line-height: 1.7;
    margin-bottom: 32px;
  }

  .notfound-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .notfound-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 28px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: background 0.22s, transform 0.15s;
    font-family: 'Nunito', sans-serif;
  }

  .notfound-btn-primary {
    background: var(--primary);
    color: var(--text-dark);
  }
  .notfound-btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: var(--text-dark);
    text-decoration: none;
  }

  .notfound-btn-outline {
    background: transparent;
    color: var(--text-mid);
    border: 1.5px solid #e0e0e0;
  }
  .notfound-btn-outline:hover {
    background: #f5f5f5;
    transform: translateY(-2px);
    color: var(--text-mid);
    text-decoration: none;
  }

  .notfound-suggestions {
    margin-top: 48px;
    text-align: left;
  }

  .notfound-suggestions-title {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-light);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 14px;
    text-align: center;
  }

  .notfound-links {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
  }

  .notfound-link-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text-mid);
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s, transform 0.15s;
    font-family: 'Nunito', sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }

  .notfound-link-chip:hover {
    border-color: var(--primary);
    color: var(--primary-dark);
    transform: translateY(-1px);
    text-decoration: none;
  }

  .notfound-link-chip i {
    color: var(--primary);
    font-size: 0.8rem;
  }
</style>

<div class="notfound-wrapper">
  <div class="notfound-box">

    {{-- Ilustrasi --}}
    <div class="notfound-illustration">
      <div class="notfound-plate">
        <i class="fas fa-utensils"></i>
        <span class="notfound-badge">404</span>
      </div>
    </div>

    {{-- Teks --}}
    <div class="notfound-code">404</div>
    <h1 class="notfound-title">Halaman Tidak Ditemukan</h1>
    <p class="notfound-desc">
      Sepertinya resep yang kamu cari sudah habis atau tidak pernah ada.<br>
      Mungkin alamatnya salah ketik, atau halamannya sudah dipindahkan.
    </p>

    {{-- Tombol Aksi --}}
    <div class="notfound-actions">
      <a href="{{ url('/') }}" class="notfound-btn notfound-btn-primary">
        <i class="fas fa-home"></i> Kembali ke Beranda
      </a>
      <a href="javascript:history.back()" class="notfound-btn notfound-btn-outline">
        <i class="fas fa-arrow-left"></i> Halaman Sebelumnya
      </a>
    </div>

    {{-- Quick Links --}}
    <div class="notfound-suggestions">
      <p class="notfound-suggestions-title">Mungkin kamu mencari ini?</p>
      <div class="notfound-links">
        <a href="{{ url('/') }}" class="notfound-link-chip">
          <i class="fas fa-home"></i> Beranda
        </a>
        <a href="{{ route('search') }}" class="notfound-link-chip">
          <i class="fas fa-search"></i> Cari Resep
        </a>
        <a href="{{ route('recipes.popular') }}" class="notfound-link-chip">
          <i class="fas fa-fire"></i> Resep Populer
        </a>
        @auth
          <a href="{{ route('recipes.create') }}" class="notfound-link-chip">
            <i class="fas fa-plus"></i> Buat Resep
          </a>
          <a href="{{ route('profile.favorites') }}" class="notfound-link-chip">
            <i class="fas fa-heart"></i> Favorit Saya
          </a>
        @endauth
      </div>
    </div>

  </div>
</div>

@endsection
