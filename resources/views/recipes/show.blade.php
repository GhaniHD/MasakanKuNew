@extends('layouts.app')
<style>
    .rating {
        list-style-type: none;
        padding: 0;
        display: inline-block;
    }

    .rating .star {
        display: inline-block;
        cursor: pointer;
    }

    .rating .star:hover,
    .rating .star:hover~.star {
        color: orange;
    }

    .rating .star.active {
        color: red;
    }

    .card-image {
        border-radius: 12px !important;
        overflow: hidden;
        /* Pastikan kartu memotong gambar yang berlebihan */
        width: 680px;
        /* Menetapkan lebar card */
        height: 520px;
        /* Menetapkan tinggi card sama dengan lebar untuk membuatnya kotak */
        margin: 0 auto;
        /* Menempatkan card di tengah */
        transform: translateX(-150px);
        /* Menggeser card sedikit ke kiri */
    }

    .card-image .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Mengatur gambar menjadi cover penuh */
        display: block;
    }

    .instruction-image {
        max-width: 90%;
        /* Mengatur maksimum lebar gambar */
        display: block;
        /* Mengubah gambar menjadi elemen blok */
        margin: 0 auto;
        /* Menempatkan gambar di tengah */
        transform: translateX(-20px);
        /* Menggeser card sedikit ke kiri */
    }

    .card-container {
        border-radius: 12px !important;
        overflow: hidden;
        /* Pastikan kartu memotong gambar yang berlebihan */
        width: 680px;
        /* Menetapkan lebar card */
        height: auto;
        /* Menetapkan tinggi card sama dengan lebar untuk membuatnya kotak */
        margin: 0 auto;
        /* Menempatkan card di tengah */
        transform: translateX(-150px);
        /* Menggeser card sedikit ke kiri */
    }

    .instruction-list {
        list-style: none;
        /* Menghilangkan penomoran default */
        padding-left: 0;
    }

    .instruction-item {
        margin-bottom: 20px;
        position: relative;
    }

    .instruction-number {
        background-color: #555;
        color: #fff;
        border-radius: 50%;
        margin-top: 9px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        position: absolute;
        top: -10px;
        left: -10px;
    }

    .instruction-image {
        margin-top: 10px;
        max-width: 100%;
        height: 120px;
        position: relative;
        margin-left: 20px;
        border-radius: 5px
    }

    .instruction-item {
        display: flex;
        flex-direction: column;
    }

    .instruction-text {
        margin-left: 40px;
        /* Memberikan jarak antara nomor dan teks */
    }

    .author-section {
        display: flex;
        align-items: center;
        margin-top: 20px;
        transform: translateX(-1px);
        /* Menggeser card sedikit ke kiri */
    }

    .author-section img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 15px;
        margin-bottom: 40px;
    }

    .author-section .author-info {
        display: flex;
        flex-direction: column;
    }

    .author-section .author-info .author-name {
        font-weight: bold;
    }

    .author-section .author-info .author-date {
        font-size: 0.9em;
        color: gray;
    }

    .follow-button {
        background-color: #D7C4AB !important;
        color: white;
        border: none;
        width: 80px;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9em;
    }

    .follow-button:hover {
        background-color: #333;
    }

    .follow-button {
        background-color: honeydew;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9em;
    }

    .follow-button:hover {
        background-color: #333;
    }

    /* Floating Action Card */
    .action-card {
        position: fixed;
        top: 20px;
        right: 250px;
        width: 300px;
        margin-top: 68px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        z-index: 1000;
    }

    .action-card button,
    .action-card a {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: wheat;
        color: #333;
        text-decoration: none;
        font-size: 0.9em;
    }

    .action-card button:hover,
    .action-card a:hover {
        background-color: #f0f0f0;
    }

    .save-recipe {
        background-color: #ffa500;
        border-radius: 10px;
        color: white;
    }

    .save-recipe:hover {
        background-color: #e69500;
    }

    .btn-primary {
        color: white !important;
        background-color: #D7C4AB !important;
        border-color: #007bff;
    }

    .btn-primary1 {
        color: white !important;
        background-color: #D7C4AB !important;
        border-color: #007bff;
        margin-left: 550px;
        margin-bottom: 20px;
    }
</style>
@section('content')

<div class="container mt-1">
    <!-- Recipe Image Card -->
    <div class="container">
        <div class="card mb-3 card-image">
            @if($recipe->image)
                <img src="{{ Storage::url($recipe->image) }}" class="card-img-top" alt="{{ $recipe->name }}">
            @endif
        </div>
    </div>


    <!-- Recipe Name and Description Card -->
    <div class="card mb-3 card-container">
        <div class="card-body">
            <b>
                <h2 class="card-title">{{ $recipe->name }}</h2>
            </b>
        </div>
    </div>

    <div class="card mb-3 card-container">
        <div class="card-body">
            <h4 class="card-title">Deskripsi</h4>
            <p class="card-text">{{ $recipe->description }}</p>
        </div>
    </div>

    <!-- Ingredients Card -->
    <div class="card mb-3 card-container">
        <div class="card-body">
            <h4 class="card-title">Bahan-bahan</h4>
            <!-- Recipe Details: Number of People and Time -->
            <div class="recipe-details mb-3">
                <span class="recipe-detail-item small-text">
                    <i class="fas fa-users"></i> {{ $recipe->servings }}
                </span>
                <span class="recipe-detail-item small-text">
                    <i class="fas fa-clock"></i>{{ $recipe->cooking_time }} menit
                </span>
            </div>
            <!-- Other content -->
            <ul class="card-text">
                @php
                    // Menghapus tanda kurung siku dan tanda kutip dari string
                    $cleanedIngredients = str_replace(['[', ']', '"'], '', $recipe->ingredients);

                    // Memecah string menjadi array berdasarkan koma
                    $ingredientsArray = explode(', ', $cleanedIngredients);
                @endphp

                @foreach($ingredientsArray as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>
    </div>


    <!-- Instructions Card -->
    <div class="card mb-3 card-container">
        <div class="card-body">
            <h4 class="card-title">Cara Membuat</h4>
            <ol class="card-text instruction-list">
                @foreach($instructions as $instruction)
                    @if ($instruction->nama)
                        <li class="instruction-item">
                            <span class="instruction-number">{{ $loop->iteration }}</span>
                            <span class="instruction-text">{{ $instruction->nama }}</span>
                            @if ($instruction->image)
                                <img src="{{ Storage::url($instruction->image) }}" class="instruction-image"
                                    alt="{{ $instruction->nama }}">
                            @endif
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div>

    <div class="card mb-3 card-container">
        <div class="card-body p-4">
            <form action="{{ route('recipes.storeReview', ['recipe' => $recipe->id]) }}" method="POST">
                @csrf

                <div class="d-flex align-items-center mb-3">
                    @auth
                        <div class="profile-image mr-3 mb-3">
                            <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Picture"
                                class="rounded-circle" width="50">
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="mb-2">{{ auth()->user()->name }}</h5>
                            <ul class="rating" id="rating">
                                <li class="star" data-value="1"><i class="far fa-star fa-sm text-danger"
                                        title="1 Bintang"></i></li>
                                <li class="star" data-value="2"><i class="far fa-star fa-sm text-danger"
                                        title="2 Bintang"></i></li>
                                <li class="star" data-value="3"><i class="far fa-star fa-sm text-danger"
                                        title="3 Bintang"></i></li>
                                <li class="star" data-value="4"><i class="far fa-star fa-sm text-danger"
                                        title="4 Bintang"></i></li>
                                <li class="star" data-value="5"><i class="far fa-star fa-sm text-danger"
                                        title="5 Bintang"></i></li>
                            </ul>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                    @endauth
                </div>

                <h2>{{ $recipe->title }}</h2>

                <div class="form-group">
                    <label for="comment">Komentar:</label>
                    <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                </div>

                <!-- Input hidden untuk menyimpan ID resep -->
                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary submit-button">Kirim</button>
            </form>
        </div>
    </div>

    <!-- Author Section -->
    <div class="card mb-3 card-container">
        <div class="card-body">
            <h4 class="card-title">Ditulis Oleh</h4>
            <div class="author-section">
                <img src="/mnt/data/image.png" alt="Author Image">
                <div class="author-info">
                    <span class="author-name">Laily Agustien (Ummifaizfaqih) <span>@cook_ummifaizfaqih</span></span>
                    <span class="author-date">pada 18 Mei 2024</span>
                    <span class="author-location">Palembang</span>
                    <button class="follow-button">Ikuti</button>
                </div>
            </div>
            <div class="author-description">
                Fulltime Mom yang suka banget mencoba berbagai macam resep Owner @Pempek Ummi Palembang
            </div>
        </div>
    </div>
</div>
<!-- Floating Action Card -->
<div class="action-card">
    <h4> <button class="save-recipe">Simpan Resep</button></h4>
    <h4><button>Bagikan</button></h4>
    <h4><button>Print</button></h4>
</div>
</div>


<!-- Back to Recipes Button -->
<a href="{{ route('recipes.popular') }}" class="btn btn-primary1">Kembali</a>
</div>
</div>

<!-- Formulir penilaian dan komentar -->
<section>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');

        stars.forEach(function (star) {
            star.addEventListener('click', function () {
                const value = this.dataset.value;
                document.getElementById('rating-value').value = value;

                stars.forEach(function (innerStar) {
                    if (innerStar.dataset.value <= value) {
                        innerStar.querySelector('i').classList.add('text-danger');
                    } else {
                        innerStar.querySelector('i').classList.remove('text-danger');
                    }
                });
            });
        });
    });
</script>

@endsection