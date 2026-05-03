@extends('layouts.app')

<style>
/* ─── Variables ─────────────────────────────── */
:root {
    --cream:   #FFFAF0;
    --amber:   #FBB917;
    --amber-d: #e0a800;
    --text:    #2d2416;
    --muted:   #8a7560;
    --border:  #ede8de;
    --white:   #ffffff;
    --radius:  14px;
    --shadow:  0 2px 16px rgba(0,0,0,0.07);
}
* { box-sizing: border-box; }
body { background: var(--cream); color: var(--text); font-family: 'Georgia', serif; margin: 0; }

/* ─── Page Wrapper ──────────────────────────── */
.recipe-page { max-width: 760px; margin: 0 auto; padding: 16px; }

/* ─── Card ──────────────────────────────────── */
.r-card {
    background: var(--white); border-radius: var(--radius);
    box-shadow: var(--shadow); margin-bottom: 16px; overflow: hidden;
}
.r-card-body { padding: 20px; }
.r-card-title {
    font-size: .85rem; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .08em;
    margin: 0 0 14px; padding-bottom: 8px;
    border-bottom: 2px solid var(--border);
}

/* ─── Cover Image ───────────────────────────── */
.cover-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block; }
.cover-placeholder {
    width: 100%; aspect-ratio: 16/9; background: var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: 3rem;
}

/* ─── Recipe Name ───────────────────────────── */
.recipe-name { font-size: clamp(1.35rem, 5vw, 2rem); margin: 0 0 12px; line-height: 1.3; }

/* ─── Meta Pills ────────────────────────────── */
.meta-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
.meta-pill {
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 20px; padding: 4px 12px;
    font-size: .82rem; color: var(--muted);
    display: flex; align-items: center; gap: 5px;
}
.meta-pill i { color: var(--amber); }

/* ─── Ingredients ───────────────────────────── */
.ingredient-list { padding: 0 0 0 18px; margin: 0; }
.ingredient-list li { padding: 3px 0; font-size: .94rem; line-height: 1.5; }
.ingredient-list li::marker { color: var(--amber); }

/* ─── Instructions ──────────────────────────── */
.instruction-list { list-style: none; padding: 0; margin: 0; }
.instruction-step {
    display: flex; gap: 14px; padding: 14px 0;
    border-bottom: 1px solid var(--border);
}
.instruction-step:last-child { border-bottom: none; }
.step-number {
    flex-shrink: 0; width: 30px; height: 30px;
    background: var(--amber); color: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .84rem; margin-top: 2px;
}
.step-content { flex: 1; min-width: 0; }
.step-text { font-size: .94rem; line-height: 1.6; margin: 0 0 8px; }

/* Thumbnail — sedikit lebih besar */
.step-images { display: flex; flex-wrap: wrap; gap: 8px; }
.step-thumb {
    width: 190px; height: 190px;
    object-fit: cover; border-radius: 10px;
    border: 2px solid var(--border); cursor: zoom-in;
    transition: transform .15s, border-color .15s; flex-shrink: 0;
}
.step-thumb:hover { transform: scale(1.06); border-color: var(--amber); }

/* ─── Author ────────────────────────────────── */
.author-row { display: flex; align-items: center; gap: 14px; }
.author-avatar {
    width: 50px; height: 50px; border-radius: 50%;
    object-fit: cover; border: 2px solid var(--amber); flex-shrink: 0;
}
.author-name { font-weight: 700; font-size: .95rem; }
.author-date { font-size: .82rem; color: var(--muted); margin-top: 2px; }

/* ─── Star Picker ───────────────────────────── */
.star-picker { display: flex; flex-direction: row-reverse; gap: 2px; }
.star-picker input { display: none; }
.star-picker label {
    font-size: 28px; color: #ddd; cursor: pointer; line-height: 1;
    transition: color .12s, transform .1s;
}
.star-picker input:checked ~ label,
.star-picker label:hover,
.star-picker label:hover ~ label { color: var(--amber); }
.star-picker label:hover { transform: scale(1.18); }

/* ─── Review Form ───────────────────────────── */
.review-form { display: flex; flex-direction: column; gap: 12px; }
.reviewer-row { display: flex; align-items: flex-start; gap: 12px; }
.reviewer-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    object-fit: cover; flex-shrink: 0; margin-top: 2px;
}
.reviewer-meta { flex: 1; }
.reviewer-name { font-weight: 600; font-size: .92rem; margin-bottom: 4px; }
.review-textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: 10px;
    padding: 12px 14px; font-size: .92rem; font-family: inherit;
    resize: vertical; min-height: 88px; background: var(--cream);
    transition: border-color .2s, box-shadow .2s;
}
.review-textarea:focus {
    outline: none; border-color: var(--amber);
    box-shadow: 0 0 0 3px rgba(251,185,23,.15);
}
.btn-review {
    align-self: flex-end; background: var(--amber); color: #fff; border: none;
    padding: 10px 26px; border-radius: 8px; font-weight: 700; font-size: .92rem;
    cursor: pointer; transition: background .2s, transform .1s;
}
.btn-review:hover { background: var(--amber-d); transform: translateY(-1px); }

/* ─── Review List ───────────────────────────── */
.review-divider { border: none; border-top: 1px solid var(--border); margin: 6px 0 16px; }
.reviews-header {
    font-size: .85rem; color: var(--muted); font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em; margin-bottom: 4px;
}
.review-item { display: flex; gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--border); }
.review-item:last-child { border-bottom: none; }
.ri-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.ri-body { flex: 1; min-width: 0; }
.ri-header { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
.ri-name { font-weight: 600; font-size: .9rem; }
.ri-stars { font-size: 13px; letter-spacing: 1px; }
.ri-stars .filled { color: var(--amber); }
.ri-stars .empty  { color: #ddd; }
.ri-date { font-size: .76rem; color: var(--muted); margin-left: auto; white-space: nowrap; }
.ri-comment { font-size: .9rem; color: #444; margin-top: 5px; line-height: 1.55; word-break: break-word; }
.no-review { text-align: center; color: var(--muted); padding: 28px 0; font-size: .9rem; }

/* ─── Floating Actions ──────────────────────── */
.floating-actions {
    position: fixed; bottom: 24px; right: 18px;
    display: flex; flex-direction: column; gap: 10px; z-index: 999;
}
.fab {
    display: flex; align-items: center; gap: 8px;
    padding: 11px 18px; border-radius: 50px; border: none;
    font-size: .86rem; font-weight: 700; cursor: pointer;
    box-shadow: 0 4px 14px rgba(0,0,0,0.13);
    transition: transform .15s, box-shadow .15s, background .2s;
    white-space: nowrap;
}
.fab:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.16); }
.fab-save         { background: var(--amber); color: #fff; }
.fab-save.saved   { background: #ef4444; color: #fff; }
.fab-share { background: var(--white); color: var(--text); }
.fab-print { background: var(--white); color: var(--text); }

/* ─── Lightbox ──────────────────────────────── */
.lightbox {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.88); z-index: 9999;
    align-items: center; justify-content: center; padding: 20px;
}
.lightbox.open { display: flex; }
.lightbox img { max-width: 100%; max-height: 90vh; border-radius: 10px; }
.lb-close {
    position: absolute; top: 16px; right: 20px;
    color: #fff; font-size: 2.2rem; cursor: pointer;
    background: none; border: none; line-height: 1;
}

/* ─── Misc ──────────────────────────────────── */
.alert-ok {
    background: #f0fdf4; border: 1px solid #86efac; color: #166534;
    border-radius: 8px; padding: 10px 14px; font-size: .88rem; margin-bottom: 14px;
}
.login-hint {
    background: #fffbeb; border: 1px solid #fcd34d; color: #92400e;
    border-radius: 8px; padding: 12px 14px; font-size: .88rem; margin-bottom: 14px;
}
.login-hint a { color: var(--amber-d); font-weight: 700; }
.err-text { color: #dc2626; font-size: .8rem; margin-top: 2px; }

/* ─── Responsive ────────────────────────────── */
@media (max-width: 600px) {
    .recipe-page { padding: 10px; }
    .r-card-body { padding: 14px; }
    .step-thumb { width: 74px; height: 74px; }
    .fab span { display: none; }
    .fab { padding: 13px; border-radius: 50%; }
    .floating-actions { bottom: 16px; right: 12px; }
    .ri-date { margin-left: 0; width: 100%; }
}
@media (max-width: 380px) {
    .step-thumb { width: 102px; height: 102px; }
    .recipe-name { font-size: 1.2rem; }
}

/* ─── PRINT STYLES ──────────────────────────── */
@media print {
    /* Sembunyikan elemen yang tidak perlu */
    .floating-actions,
    .lightbox,
    nav, header, footer,
    .no-print { display: none !important; }

    /* Sembunyikan seluruh card ulasan & komentar */
    .card-review-section { display: none !important; }

    body { background: #fff !important; font-family: Georgia, serif; }
    .recipe-page { max-width: 100%; padding: 0; }

    .r-card {
        box-shadow: none !important;
        border: 1px solid #ddd;
        border-radius: 6px !important;
        margin-bottom: 12px;
        break-inside: avoid;
    }

    /* Gambar cover full width saat print */
    .cover-img { aspect-ratio: 16/9; width: 100%; }

    /* Thumbnail instruksi sedikit lebih besar saat print */
    .step-thumb { width: 100px !important; height: 100px !important; border: 1px solid #ccc; }

    /* Pastikan teks hitam */
    .r-card-title, .recipe-name, .step-text,
    .ingredient-list li, .author-name { color: #000 !important; }
    .meta-pill, .author-date, .muted { color: #555 !important; }

    /* Nomor langkah tetap berwarna */
    .step-number { background: #FBB917 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .meta-pill i { color: #FBB917 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>

@section('content')

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLb()">
    <button class="lb-close" onclick="closeLb()">&times;</button>
    <img id="lbImg" src="" alt="" onclick="event.stopPropagation()">
</div>

<div class="recipe-page">

    {{-- Cover --}}
    <div class="r-card">
        @if($recipe->image)
            <img class="cover-img"
                 src="{{ str_starts_with($recipe->image,'http') ? $recipe->image : Storage::url($recipe->image) }}"
                 alt="{{ $recipe->name }}">
        @else
            <div class="cover-placeholder"><i class="fas fa-utensils"></i></div>
        @endif
    </div>

    {{-- Nama + Meta --}}
    <div class="r-card">
        <div class="r-card-body">
            <h1 class="recipe-name">{{ $recipe->name }}</h1>
            <div class="meta-pills">
                <span class="meta-pill"><i class="fas fa-users"></i> {{ $recipe->servings }} porsi</span>
                <span class="meta-pill"><i class="fas fa-clock"></i> {{ $recipe->cooking_time }} menit</span>
                <span class="meta-pill"><i class="fas fa-tag"></i> {{ ucfirst($recipe->category) }}</span>
            </div>
            <p style="color:var(--muted);font-size:.93rem;margin:0;line-height:1.6">{{ $recipe->description }}</p>
        </div>
    </div>

    {{-- Bahan-bahan --}}
    <div class="r-card">
        <div class="r-card-body">
            <p class="r-card-title">Bahan-bahan</p>
            @php
                $ingredientsList = is_array($recipe->ingredients)
                    ? $recipe->ingredients
                    : json_decode($recipe->ingredients, true) ?? [];
            @endphp
            <ul class="ingredient-list">
                @foreach($ingredientsList as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Cara Membuat --}}
    <div class="r-card">
        <div class="r-card-body">
            <p class="r-card-title">Cara Membuat</p>
            <ol class="instruction-list">
                @foreach($instructions as $instruction)
                    @if($instruction->nama)
                        <li class="instruction-step">
                            <div class="step-number">{{ $loop->iteration }}</div>
                            <div class="step-content">
                                <p class="step-text">{{ $instruction->nama }}</p>
                                @if($instruction->image)
                                    <div class="step-images">
                                        <img class="step-thumb"
                                             src="{{ str_starts_with($instruction->image,'http') ? $instruction->image : Storage::url($instruction->image) }}"
                                             alt="Langkah {{ $loop->iteration }}"
                                             onclick="openLb(this.src)">
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div>

    {{-- Penulis --}}
    <div class="r-card">
        <div class="r-card-body">
            <p class="r-card-title">Ditulis Oleh</p>
            <div class="author-row">
                @if($recipe->user->profile_picture_url)
                    <img class="author-avatar" src="{{ $recipe->user->profile_picture_url }}" alt="">
                @else
                    <img class="author-avatar" src="{{ asset('images/default-avatar.png') }}" alt="">
                @endif
                <div>
                    <div class="author-name">{{ $recipe->user->name }}</div>
                    <div class="author-date">{{ $recipe->created_at->translatedFormat('d F Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ulasan & Komentar — disembunyikan saat print via class --}}
    <div class="r-card card-review-section">
        <div class="r-card-body">
            <p class="r-card-title">Ulasan & Komentar</p>

            @if(session('success'))
                <div class="alert-ok">✓ {{ session('success') }}</div>
            @endif

            @auth
                <form class="review-form"
                      action="{{ route('recipes.storeReview', $recipe->id) }}"
                      method="POST">
                    @csrf
                    <div class="reviewer-row">
                        @if(auth()->user()->profile_picture_url)
                            <img class="reviewer-avatar" src="{{ auth()->user()->profile_picture_url }}" alt="">
                        @else
                            <img class="reviewer-avatar" src="{{ asset('images/default-avatar.png') }}" alt="">
                        @endif
                        <div class="reviewer-meta">
                            <div class="reviewer-name">{{ auth()->user()->name }}</div>
                            <div class="star-picker">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="s{{ $i }}" name="rating" value="{{ $i }}"
                                           {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="s{{ $i }}">&#9733;</label>
                                @endfor
                            </div>
                            @error('rating')<div class="err-text">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <textarea class="review-textarea" name="comment"
                              placeholder="Bagikan pengalamanmu memasak resep ini...">{{ old('comment') }}</textarea>
                    @error('comment')<div class="err-text">{{ $message }}</div>@enderror
                    <button type="submit" class="btn-review">Kirim Ulasan</button>
                </form>
            @else
                <div class="login-hint">
                    <a href="{{ route('login') }}">Masuk</a> untuk memberikan ulasan.
                </div>
            @endauth

            <hr class="review-divider">
            @php $reviews = $recipe->reviews()->with('user')->latest()->get(); @endphp

            @if($reviews->count())
                <div class="reviews-header">{{ $reviews->count() }} Ulasan</div>
            @endif

            @forelse($reviews as $review)
                <div class="review-item">
                    @if($review->user->profile_picture_url)
                        <img class="ri-avatar" src="{{ $review->user->profile_picture_url }}" alt="">
                    @else
                        <img class="ri-avatar" src="{{ asset('images/default-avatar.png') }}" alt="">
                    @endif
                    <div class="ri-body">
                        <div class="ri-header">
                            <span class="ri-name">{{ $review->user->name }}</span>
                            <span class="ri-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'filled' : 'empty' }}">★</span>
                                @endfor
                            </span>
                            <span class="ri-date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        @if($review->comment)
                            <div class="ri-comment">{{ $review->comment }}</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-review">
                    <i class="far fa-comment-dots" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4"></i>
                    Belum ada ulasan. Jadilah yang pertama!
                </div>
            @endforelse
        </div>
    </div>

</div>{{-- /recipe-page --}}

{{-- Floating Actions — semua disembunyikan saat print --}}
<div class="floating-actions no-print">
    @auth
        {{-- Tombol Simpan ke Favorit --}}
        <button class="fab fab-save {{ $recipe->isFavoritedBy(Auth::user()) ? 'saved' : '' }}"
                id="favBtn"
                data-recipe-id="{{ $recipe->id }}"
                data-favorited="{{ $recipe->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}">
            <i class="fas fa-heart" id="favIcon"></i>
            <span id="favText">{{ $recipe->isFavoritedBy(Auth::user()) ? 'Tersimpan' : 'Simpan' }}</span>
        </button>
    @else
        <a href="{{ route('login') }}" class="fab fab-save" style="text-decoration:none">
            <i class="fas fa-heart"></i><span> Simpan</span>
        </a>
    @endauth

    <button class="fab fab-share" onclick="shareRecipe()">
        <i class="fas fa-share-alt"></i><span> Bagikan</span>
    </button>
    <button class="fab fab-print" onclick="window.print()">
        <i class="fas fa-print"></i><span> Print</span>
    </button>
</div>

<script>
/* ── Lightbox ─────────────────────────── */
function openLb(src) {
    document.getElementById('lbImg').src = src;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLb() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLb(); });

/* ── Share ────────────────────────────── */
function shareRecipe() {
    if (navigator.share) {
        navigator.share({ title: '{{ addslashes($recipe->name) }}', url: window.location.href });
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => alert('Link berhasil disalin!'));
    }
}

/* ── Favorite Toggle ──────────────────── */
@auth
const favBtn  = document.getElementById('favBtn');
const favIcon = document.getElementById('favIcon');
const favText = document.getElementById('favText');

if (favBtn) {
    favBtn.addEventListener('click', function () {
        const recipeId   = this.dataset.recipeId;
        const isFavorited = this.dataset.favorited === 'true';

        fetch(`/profile/favorites/${recipeId}`, {
            method: isFavorited ? 'DELETE' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.message === 'Recipe added to favorites') {
                favBtn.dataset.favorited = 'true';
                favBtn.classList.add('saved');
                favText.textContent = 'Tersimpan';
            } else if (data.message === 'Recipe removed from favorites') {
                favBtn.dataset.favorited = 'false';
                favBtn.classList.remove('saved');
                favText.textContent = 'Simpan';
            }
        })
        .catch(err => console.error('Favorite error:', err));
    });
}
@endauth
</script>

@endsection
