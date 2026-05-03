@extends('layouts.app')

@section('content')

<style>
  /* ===== VARIABLES & RESET ===== */
  :root {
    --primary: #FFBD59;
    --primary-dark: #e5a805;
    --text-dark: #1a1a2e;
    --text-mid: #555;
    --text-light: #999;
    --card-bg: #fff;
    --border: #f0f0f0;
    --shadow-sm: 0 2px 12px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 24px rgba(0,0,0,0.12);
    --radius: 12px;
    --radius-sm: 8px;
    font-family: 'Nunito', sans-serif;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  /* ===== LAYOUT ===== */
  .page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px 48px;
  }

  .main-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 32px;
    margin-top: 32px;
  }

  /* ===== SLIDER ===== */
  .slideshow-container {
    position: relative;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-md);
  }

  .mySlides { display: none; position: relative; }
  .mySlides img { width: 100%; height: 420px; object-fit: cover; display: block; }

  .slide-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 40px 24px 20px;
    background: linear-gradient(transparent, rgba(0,0,0,0.55));
    color: #fff;
    font-size: 0.9rem;
  }

  .slide-number {
    position: absolute;
    top: 14px; left: 16px;
    background: rgba(0,0,0,0.4);
    color: #fff;
    font-size: 0.75rem;
    padding: 3px 10px;
    border-radius: 20px;
    backdrop-filter: blur(4px);
  }

  .prev, .next {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(6px);
    border: none;
    color: #fff;
    width: 40px; height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.25s;
    z-index: 10;
  }

  .prev { left: 14px; }
  .next { right: 14px; }
  .prev:hover, .next:hover { background: rgba(255,255,255,0.45); }

  .dots-container { text-align: center; padding: 12px 0; }

  .dot {
    cursor: pointer;
    width: 8px; height: 8px;
    margin: 0 4px;
    background: #ccc;
    border-radius: 50%;
    display: inline-block;
    transition: background 0.3s, transform 0.3s;
  }

  .dot.active, .dot:hover { background: var(--primary); transform: scale(1.3); }

  /* ===== SECTION TITLE ===== */
  .section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 20px;
  }

  .section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
  }

  /* ===== RECIPE CARDS GRID ===== */
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
  }

  .recipe-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    transition: transform 0.25s, box-shadow 0.25s;
  }

  .recipe-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
  }

  .card-img-wrap {
    position: relative;
    height: 160px;
    overflow: hidden;
  }

  .card-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
  }

  .recipe-card:hover .card-img-wrap img { transform: scale(1.06); }

  .card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: #f5f5f5; color: #ccc; font-size: 2rem;
  }

  .fav-btn {
    position: absolute;
    top: 9px; right: 10px;
    background: rgba(255,255,255,0.85);
    border: none;
    border-radius: 50%;
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background 0.2s, transform 0.2s;
  }

  .fav-btn:hover { background: #fff; transform: scale(1.15); }

  .card-body {
    padding: 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .card-meta {
    display: flex;
    gap: 12px;
    font-size: 0.78rem;
    color: var(--text-light);
  }

  .card-meta span { display: flex; align-items: center; gap: 4px; }

  .stars { color: var(--primary); font-size: 0.75rem; }

  .card-cta {
    display: block;
    background: var(--primary);
    color: #fff;
    text-align: center;
    padding: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-decoration: none;
    text-transform: uppercase;
    transition: background 0.25s;
    margin-top: auto;
  }

  .card-cta:hover { background: var(--primary-dark); }

  .show-all-wrap { text-align: center; margin-top: 24px; }

  .btn-show-all {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    padding: 11px 32px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.25s;
  }

  .btn-show-all:hover { background: var(--primary-dark); }

  /* ===== SIDEBAR ===== */
  .sidebar { display: flex; flex-direction: column; gap: 28px; }

  /* Popular Recipe */
  .popular-card {
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    position: relative;
  }

  .popular-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s;
  }

  .popular-card:hover img { transform: scale(1.04); }

  .popular-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    padding: 32px 14px 14px;
  }

  .popular-name {
    color: #fff;
    font-size: 1rem;
    font-weight: 700;
  }

  .popular-meta {
    display: flex;
    gap: 10px;
    margin-top: 6px;
  }

  .badge {
    background: rgba(255,189,89,0.9);
    color: #1a1a2e;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
  }

  /* ===== KATEGORI GRID =====
     - Grid 4 kolom
     - aspect-ratio: 1/1 → semua kotak persegi & seragam di semua ukuran layar
     - Font & icon pakai clamp() agar responsif otomatis
  */
  .kategori-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
  }

  .kategori-item {
    background: var(--primary);
    border-radius: var(--radius-sm);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    aspect-ratio: 1 / 1;       /* kunci: kotak selalu persegi */
    padding: 6px 4px;
    text-decoration: none;
    color: #fff;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-align: center;
    line-height: 1.2;
    overflow: hidden;
    transition: background 0.25s, transform 0.25s;
  }

  .kategori-item:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: #fff;
  }

  .kategori-item i {
    font-size: clamp(0.9rem, 2.2vw, 1.4rem);
    flex-shrink: 0;
  }

  .kategori-item .cat-label {
    font-size: clamp(0.48rem, 1.05vw, 0.62rem);
    display: block;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0 2px;
  }

  /* ===== RESPONSIVE ===== */
  @media (max-width: 1024px) {
    .main-grid { grid-template-columns: 1fr 260px; gap: 20px; }
    .cards-grid { grid-template-columns: repeat(2, 1fr); }
  }

  @media (max-width: 768px) {
    .main-grid { grid-template-columns: 1fr; }
    .cards-grid { grid-template-columns: repeat(2, 1fr); }
    .mySlides img { height: 280px; }
    .kategori-grid { grid-template-columns: repeat(4, 1fr); }
  }

  @media (max-width: 480px) {
    .cards-grid { grid-template-columns: 1fr; }
    .mySlides img { height: 220px; }
    .kategori-grid { grid-template-columns: repeat(4, 1fr); gap: 6px; }
  }
</style>

@php
  /*
  |--------------------------------------------------------------------------
  | FA Icon Map — keyword → class FontAwesome
  | Matching: exact dulu, lalu partial (str_contains)
  |--------------------------------------------------------------------------
  */
  $iconMap = [
    // Makanan berat
    'ayam'      => 'fa-drumstick-bite',
    'sate'      => 'fa-fire',
    'opor'      => 'fa-bowl-food',
    'sop'       => 'fa-bowl-food',
    'sup'       => 'fa-bowl-food',
    'ikan'      => 'fa-fish',
    'seafood'   => 'fa-fish',
    'laut'      => 'fa-fish',
    'udang'     => 'fa-shrimp',
    'mie'       => 'fa-bowl-food',
    'mi'        => 'fa-bowl-food',
    'pasta'     => 'fa-bowl-food',
    'pizza'     => 'fa-pizza-slice',
    'nasi'      => 'fa-bowl-rice',
    'daging'    => 'fa-drumstick-bite',
    'rendang'   => 'fa-drumstick-bite',
    'bakso'     => 'fa-bowl-food',
    'burger'    => 'fa-burger',
    'sandwich'  => 'fa-bread-slice',
    'roti'      => 'fa-bread-slice',
    'telur'     => 'fa-egg',
    'tahu'      => 'fa-utensils',
    'tempe'     => 'fa-utensils',

    // Sayur & sehat
    'sayur'     => 'fa-leaf',
    'salad'     => 'fa-leaf',
    'buah'      => 'fa-apple-whole',
    'sehat'     => 'fa-heart',
    'diet'      => 'fa-heart',
    'vegan'     => 'fa-seedling',

    // Snack & dessert
    'kue'       => 'fa-birthday-cake',
    'cake'      => 'fa-cake-candles',
    'cemilan'   => 'fa-cookie-bite',
    'snack'     => 'fa-cookie-bite',
    'eskrim'    => 'fa-ice-cream',
    'es krim'   => 'fa-ice-cream',
    'coklat'    => 'fa-cookie',
    'dessert'   => 'fa-cake-candles',
    'pudding'   => 'fa-utensils',
    'donat'     => 'fa-circle',

    // Minuman
    'minuman'   => 'fa-glass-water',
    'jus'       => 'fa-glass-water',
    'kopi'      => 'fa-mug-hot',
    'teh'       => 'fa-mug-hot',
    'smoothie'  => 'fa-blender',
    'susu'      => 'fa-glass-water',

    // Bayi & anak
    'bayi'      => 'fa-baby',
    'mpasi'     => 'fa-baby',
    'anak'      => 'fa-child',

    // Sarapan
    'sarapan'   => 'fa-egg',
    'breakfast' => 'fa-egg',
  ];

  $getIcon = function(string $catName) use ($iconMap): string {
    $lower = strtolower(trim($catName));
    if (isset($iconMap[$lower])) return $iconMap[$lower];
    foreach ($iconMap as $keyword => $icon) {
      if (str_contains($lower, $keyword)) return $icon;
    }
    return 'fa-utensils';
  };
@endphp

<div class="page-wrapper">

  {{-- ===== SLIDER ===== --}}
  <div class="slideshow-container">
    <div class="mySlides">
      <div class="slide-number">1 / 3</div>
      <img src="{{ asset('images/SunnyRE.png') }}" alt="Slide 1">
      <div class="slide-caption">Temukan Resep Terbaik Untukmu</div>
    </div>
    <div class="mySlides">
      <div class="slide-number">2 / 3</div>
      <img src="{{ asset('images/SunnyA.png') }}" alt="Slide 2">
      <div class="slide-caption">Masak dengan Mudah & Menyenangkan</div>
    </div>
    <div class="mySlides">
      <div class="slide-number">3 / 3</div>
      <img src="{{ asset('images/SunnyT.png') }}" alt="Slide 3">
      <div class="slide-caption">Jadikan Dapurmu Lebih Istimewa</div>
    </div>
    <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
    <button class="next" onclick="plusSlides(1)">&#10095;</button>
  </div>

  <div class="dots-container">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>

  {{-- ===== MAIN GRID ===== --}}
  <div class="main-grid">

    {{-- ===== LEFT: Recipe Cards ===== --}}
    <div>
      <h2 class="section-title">Resep Tersedia</h2>
      <div class="cards-grid">
        @foreach ($recipes as $index => $recipe)
          @if ($index < 9)
            <div class="recipe-card">
              <div class="card-img-wrap">
                @if ($recipe->image)
                  <img src="{{ str_starts_with($recipe->image, 'http')
    ? $recipe->image
    : Storage::url($recipe->image) }}" alt="{{ $recipe->name }}">
                @else
                  <div class="card-img-placeholder">
                    <i class="fas fa-image"></i>
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
                  <span><i class="fa fa-users"></i> {{ $recipe->servings }} Orang</span>
                </div>
                <div class="stars">
                  <i class="fa fa-star"></i><i class="fa fa-star"></i>
                  <i class="fa fa-star"></i><i class="fa fa-star"></i>
                  <i class="fa fa-star-o"></i>
                </div>
              </div>
              <a href="{{ route('recipes.show', $recipe->id) }}" class="card-cta">Let's Cook!</a>
            </div>
          @endif
        @endforeach
      </div>

      @if (count($recipes) > 9)
        <div class="show-all-wrap">
          <button id="show-all-button" class="btn-show-all">Semua Resep</button>
        </div>
      @endif
    </div>

    {{-- ===== RIGHT: Sidebar ===== --}}
    <div class="sidebar">

      {{-- Popular Recipes --}}
      <div>
        <h2 class="section-title">Resep Populer</h2>
        @foreach ($popularRecipes as $recipe)
          <div class="popular-card" style="margin-bottom: 14px;">
            <img src="{{ str_starts_with($recipe->image, 'http') ? $recipe->image
            : Storage::url($recipe->image) }}" alt="{{ $recipe->name }}">
            <div class="popular-overlay">
              <p class="popular-name">{{ $recipe->name }}</p>
              <div class="popular-meta">
                <span class="badge">
                  <i class="fa fa-clock"></i> {{ $recipe->cooking_time ?? '50' }} Menit
                </span>
                <span class="badge">
                  <i class="fa fa-users"></i> {{ $recipe->servings ?? '4' }} Porsi
                </span>
              </div>
            </div>
            <button class="fav-btn" data-recipe-id="{{ $recipe->id }}"
                    style="position:absolute; top:10px; right:10px;">
              <i class="fa fa-heart"
                 style="color: {{ $recipe->isFavoritedBy(Auth::user()) ? '#e74c3c' : '#ccc' }}"></i>
            </button>
          </div>
        @endforeach
      </div>

      {{-- Kategori — max 8, FA icon, kotak seragam --}}
      <div>
        <h2 class="section-title">Kategori</h2>
        <div class="kategori-grid">
          @forelse ($categories as $cat)
            @php $icon = $getIcon($cat); @endphp
            <a href="{{ route('recipes.category', $cat) }}" class="kategori-item">
              <i class="fas {{ $icon }}"></i>
              <span class="cat-label">{{ strtoupper($cat) }}</span>
            </a>
          @empty
            <p style="color:#999;font-size:0.8rem;grid-column:1/-1;">Belum ada kategori.</p>
          @endforelse
        </div>
      </div>

    </div>{{-- end sidebar --}}
  </div>{{-- end main-grid --}}
</div>{{-- end page-wrapper --}}

<script>
  // ===== SLIDER =====
  let slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) { showSlides(slideIndex += n); }
  function currentSlide(n) { showSlides(slideIndex = n); }

  function showSlides(n) {
    const slides = document.querySelectorAll('.mySlides');
    const dots   = document.querySelectorAll('.dot');
    if (n > slides.length) slideIndex = 1;
    if (n < 1) slideIndex = slides.length;
    slides.forEach(s => s.style.display = 'none');
    dots.forEach(d => d.classList.remove('active'));
    slides[slideIndex - 1].style.display = 'block';
    dots[slideIndex - 1].classList.add('active');
  }

  setInterval(() => plusSlides(1), 5000);

  // ===== SHOW ALL =====
  document.getElementById('show-all-button')?.addEventListener('click', () => {
    window.location.href = '/user/all-recipes';
  });

  // ===== FAVORITE TOGGLE =====
  document.querySelectorAll('.fav-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const id   = this.dataset.recipeId;
      const icon = this.querySelector('i');
      const isRed = icon.style.color === 'rgb(231, 76, 60)' || icon.style.color === '#e74c3c';

      fetch(`/profile/favorites/${id}`, {
        method: isRed ? 'DELETE' : 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      })
      .then(r => r.json())
      .then(data => {
        if (data.message === 'Recipe added to favorites') {
          icon.style.color = '#e74c3c';
        } else if (data.message === 'Recipe removed from favorites') {
          icon.style.color = '#ccc';
        }
      })
      .catch(err => console.error(err));
    });
  });
</script>

@endsection
