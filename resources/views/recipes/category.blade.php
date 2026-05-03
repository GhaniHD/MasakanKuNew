@extends('layouts.app')

@section('content')

<style>
  :root {
    --primary: #FFBD59;
    --primary-dark: #e5a805;
    --text-dark: #1a1a2e;
    --text-light: #999;
    --border: #f0f0f0;
    --shadow-sm: 0 2px 12px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 24px rgba(0,0,0,0.12);
    --radius: 12px;
    --radius-sm: 8px;
    font-family: 'Nunito', sans-serif;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  .page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 16px 48px;
  }

  .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--text-light);
    margin-bottom: 24px;
  }
  .breadcrumb-nav a { color: var(--primary-dark); text-decoration: none; font-weight: 600; }
  .breadcrumb-nav a:hover { text-decoration: underline; }
  .breadcrumb-nav span { color: #ccc; }

  .page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
    padding-bottom: 18px;
    border-bottom: 2px solid var(--border);
  }
  .page-header .icon-wrap {
    width: 48px; height: 48px;
    background: var(--primary);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff; flex-shrink: 0;
  }
  .page-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin: 0; }
  .page-header .recipe-count { font-size: 0.85rem; color: var(--text-light); margin-top: 2px; }

  .empty-state {
    text-align: center; padding: 60px 20px; color: var(--text-light);
  }
  .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.4; }
  .empty-state a {
    display: inline-block; margin-top: 16px; background: var(--primary); color: #fff;
    padding: 10px 24px; border-radius: var(--radius-sm); text-decoration: none;
    font-weight: 700; font-size: 0.9rem; transition: background 0.25s;
  }
  .empty-state a:hover { background: var(--primary-dark); }

  .cards-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }

  .recipe-card {
    background: #fff; border-radius: var(--radius); overflow: hidden;
    border: 1px solid var(--border); box-shadow: var(--shadow-sm);
    display: flex; flex-direction: column;
    transition: transform 0.25s, box-shadow 0.25s;
  }
  .recipe-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }

  .card-img-wrap {
    position: relative; height: 165px; overflow: hidden; background: #f5f5f5;
  }
  .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
  .recipe-card:hover .card-img-wrap img { transform: scale(1.06); }

  .fav-btn {
    position: absolute; top: 9px; right: 9px;
    background: rgba(255,255,255,0.88); border: none; border-radius: 50%;
    width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 0.85rem; transition: transform 0.2s, background 0.2s;
  }
  .fav-btn:hover { transform: scale(1.15); background: #fff; }

  .card-body { padding: 13px; flex: 1; display: flex; flex-direction: column; gap: 7px; }
  .card-title {
    font-size: 0.92rem; font-weight: 700; color: var(--text-dark); line-height: 1.35;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .card-meta { display: flex; gap: 10px; font-size: 0.76rem; color: var(--text-light); flex-wrap: wrap; }
  .card-meta span { display: flex; align-items: center; gap: 4px; }
  .stars { color: var(--primary); font-size: 0.72rem; }

  .card-cta {
    display: block; background: var(--primary); color: #fff; text-align: center;
    padding: 10px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.07em;
    text-transform: uppercase; text-decoration: none; transition: background 0.25s; margin-top: auto;
  }
  .card-cta:hover { background: var(--primary-dark); }

  .other-categories { margin-top: 48px; padding-top: 28px; border-top: 1px solid var(--border); }

  .section-title {
    display: flex; align-items: center; gap: 10px;
    font-size: 1rem; font-weight: 700; color: var(--text-dark); margin-bottom: 16px;
  }
  .section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

  .cat-chips { display: flex; flex-wrap: wrap; gap: 10px; }

  .cat-chip {
    display: flex; align-items: center; gap: 7px;
    background: #fff; border: 1px solid var(--border); border-radius: 40px;
    padding: 8px 16px; font-size: 0.82rem; font-weight: 700;
    color: var(--text-dark); text-decoration: none; transition: all 0.2s;
  }
  .cat-chip:hover, .cat-chip.active {
    background: var(--primary); border-color: var(--primary); color: #fff;
  }
  .cat-chip i { font-size: 0.9rem; }

  @media (max-width: 1024px) { .cards-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 768px)  { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px)  { .cards-grid { grid-template-columns: 1fr; } .card-img-wrap { height: 200px; } }
</style>

{{-- Peta ikon per nama kategori --}}
@php
  $iconMap = [
    'kue'=>'fa-birthday-cake','cemilan'=>'fa-utensils','bayi'=>'fa-child',
    'bayi dan anak'=>'fa-child','pizza'=>'fa-pizza-slice','opor'=>'fa-drumstick-bite',
    'sop'=>'fa-utensil-spoon','ikan'=>'fa-fish','sayur'=>'fa-leaf',
    'ayam'=>'fa-drumstick-bite','mie'=>'fa-bowl-food','minuman'=>'fa-glass-water',
    'sate'=>'fa-utensils','salad'=>'fa-leaf','eskrim'=>'fa-ice-cream',
  ];
  $currentIcon = $iconMap[strtolower($category)] ?? 'fa-utensils';
@endphp

<div class="page-wrapper">

  {{-- Breadcrumb --}}
  <nav class="breadcrumb-nav">
    <a href="{{ route('user.dashboard') }}">Beranda</a>
    <span>&rsaquo;</span>
    <span>Kategori</span>
    <span>&rsaquo;</span>
    <span>{{ ucfirst($category) }}</span>
  </nav>

  {{-- Page Header --}}
  <div class="page-header">
    <div class="icon-wrap">
      <i class="fas {{ $currentIcon }}"></i>
    </div>
    <div>
      <h1>Resep {{ ucfirst($category) }}</h1>
      <p class="recipe-count">{{ $recipes->count() }} resep ditemukan</p>
    </div>
  </div>

  {{-- Recipe Cards --}}
  @if ($recipes->isEmpty())
    <div class="empty-state">
      <div><i class="fas fa-search"></i></div>
      <p>Belum ada resep untuk kategori <strong>{{ ucfirst($category) }}</strong>.</p>
      <a href="{{ route('recipes.create') }}">+ Tambah Resep Baru</a>
    </div>
  @else
    <div class="cards-grid">
      @foreach ($recipes as $recipe)
        <div class="recipe-card">
          <div class="card-img-wrap">
            @if ($recipe->image)
              <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->name }}">
            @else
              <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;">
                <i class="fas fa-image" style="font-size:2rem;"></i>
              </div>
            @endif
            <button class="fav-btn" data-recipe-id="{{ $recipe->id }}">
              <i class="fa fa-heart"
                 style="color: {{ $recipe->isFavoritedBy(Auth::user()) ? '#e74c3c' : '#ccc' }}"></i>
            </button>
          </div>
          <div class="card-body">
            <p class="card-title">{{ $recipe->name }}</p>
            <div class="card-meta">
              <span><i class="fa fa-clock"></i> {{ $recipe->cooking_time }} mnt</span>
              <span><i class="fa fa-users"></i> {{ $recipe->servings }} orang</span>
            </div>
            <div class="stars">
              <i class="fa fa-star"></i><i class="fa fa-star"></i>
              <i class="fa fa-star"></i><i class="fa fa-star"></i>
              <i class="fa fa-star-o"></i>
            </div>
          </div>
          <a href="{{ route('recipes.show', $recipe->id) }}" class="card-cta">Let's Cook!</a>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Kategori Lainnya — dinamis dari DB --}}
  <div class="other-categories">
    <h2 class="section-title">Kategori Lainnya</h2>
    <div class="cat-chips">
      @foreach ($allCategories as $cat)
        @php $icon = $iconMap[strtolower($cat)] ?? 'fa-utensils'; @endphp
        <a href="{{ route('recipes.category', $cat) }}"
           class="cat-chip {{ strtolower($cat) === strtolower($category) ? 'active' : '' }}">
          <i class="fas {{ $icon }}"></i>
          {{ ucfirst($cat) }}
        </a>
      @endforeach
    </div>
  </div>

</div>

<script>
  document.querySelectorAll('.fav-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const id   = this.dataset.recipeId;
      const icon = this.querySelector('i');
      const isRed = icon.style.color === 'rgb(231, 76, 60)' || icon.style.color === '#e74c3c';

      fetch(`/profile/favorites/${id}`, {
        method: isRed ? 'DELETE' : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      })
      .then(r => r.json())
      .then(data => {
        if (data.message === 'Recipe added to favorites') icon.style.color = '#e74c3c';
        else if (data.message === 'Recipe removed from favorites') icon.style.color = '#ccc';
      })
      .catch(err => console.error(err));
    });
  });
</script>

@endsection
