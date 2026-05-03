@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Nunito', sans-serif;
        background-size: cover;
        background-position: center 35px;
        margin: 0;
        padding: 0;
    }

    h1 {
        font-size: 1.5rem;
        /* Perkecil ukuran h1 */
        margin-bottom: 20px;
        font-weight: 600;
    }

    p {
        font-size: 1.5rem;
        margin-bottom: 1px;
    }

    @import url('https://fonts.googleapis.com/css?family=Roboto');

    img {
        max-width: 100%;
        height: auto;
    }

    .card {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header {
        height: 180px;
        /* Sesuaikan tinggi gambar */
        position: relative;
        overflow: hidden;
    }

    .img-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .text {
        padding: 15px;
        flex-grow: 1;
    }

    .normal-text {
        font-size: 1em;
        color: #888;
        margin-right: 10px;
    }

    .small-text {
        font-size: 0.875em;
        /* Ukuran teks lebih kecil */
        vertical-align: middle;
    }

    .stars {
        margin: 10px 0;
    }

    .stars a {
        color: #ffd700;
        text-decoration: none;
    }

    .stars a:hover {
        color: #ff9b00;
    }

    .info {
        margin-top: 10px;
    }

    a.btn {
        display: block;
        background: #FFBD59;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        text-align: center;
        padding: 10px;
        font-size: 0.9em;
        text-decoration: none;
        transition: 250ms;

    }

    a.btn:hover {
        background: #C8B560;
    }

    .card-container .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-container .card .img-wrapper {
        position: relative;
    }

    .card-container .card .favorite-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        width: 30px;
        height: 30px;
        border-radius: 60%;
        padding-top: 1px;
        padding-left: 5px;
    }

    .card-container .card .text {
        padding: 15px;
    }

    .card-container .card .text h1.food {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }

    .card-container .card .stars {
        margin-top: 10px;
    }

    .card-container .card .btn {
        margin: 10px;
    }



    .Populer {
        position: absolute;
        width: 38%;
        height: 33%;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fbfaf6+9,d4cebf+74,d4cebf+74,d4cebf+100 */


    }


    .cont_central {
        position: absolute;
        width: 100%;
        top: 50%;
        margin-top: -200px;
    }

    .cont_modal {
        position: relative;
        width: 300px;
        height: 400px;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition-delay: 0.7s;
        -webkit-transition-delay: 0.7s;
        -o-transition-delay: 0.7s;
        transition-delay: 0.7s;
    }

    .cont_photo {
        position: relative;
        width: 200px;
        height: 300px;
        padding: 5px;
        overflow: hidden;
        background-color: #eee;
        top: -20px;
        float: left;
        z-index: 2;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition: all 0.5s;
        box-shadow: 1px 1px 20px -5px rgba(0, 0, 0, 0.5);
    }

    .cont_img_back {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 5px;
    }

    .cont_img_back>img {
        width: 100%;
        opacity: 0.7;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition: all 1s;
    }

    .cont_img_back:hover>img {
        transform: scale(1.5);
    }

    .cont_text_ingredients {
        position: absolute;
        width: 0px;
        top: 0px;
        left: 290px;
        margin-left: 10px;
        height: 400px;
        float: left;
        border-radius: 5px;
        z-index: 3;
        box-shadow: 1px 1px 20px -5px rgba(0, 0, 0, 0.2);

        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fbf9f9+28,e8eaed+100 */
        background: rgb(251, 249, 249);
        /* Old browsers */
        background: -moz-linear-gradient(-45deg, rgba(251, 249, 249, 1) 28%, rgba(232, 234, 237, 1) 100%);
        /* FF3.6-15 */
        background: -webkit-linear-gradient(-45deg, rgba(251, 249, 249, 1) 28%, rgba(232, 234, 237, 1) 100%);
        /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(135deg, rgba(251, 249, 249, 1) 28%, rgba(232, 234, 237, 1) 100%);
        /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition-delay: 0.7s;
        -webkit-transition-delay: 0.7s;
        -o-transition-delay: 0.7s;
        transition-delay: 0.7s;
    }

    .cont_mins {
        position: relative;
        float: left;
        width: 100%;
    }

    .sub_mins {
        position: relative;
        float: left;
        width: 60px;
        height: 60px;
        background-color: rgba(255, 253, 112, 0.8);
        border-radius: 50%;
        margin: 16px;
        margin-bottom: 0px;
        opacity: 0;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition: all 0.5s;
        transition-delay: 1s;
        -webkit-transition-delay: 1s;
        -o-transition-delay: 1s;
        transition-delay: 1s;

    }

    .sub_mins>h3 {
        font-size: 24px;
        margin-top: 7px;
        margin-bottom: -15px;
    }

    .sub_mins>span {
        font-size: 9px;
        font-weight: 700;
    }

    .cont_servings {
        position: relative;
        float: left;
        width: 60px;
        height: 60px;
        background-color: rgba(255, 253, 112, 0.8);
        border-radius: 50%;
        margin: 16px;
        opacity: 0;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        transition-delay: 0.7s;
        -webkit-transition-delay: 0.7s;
        -o-transition-delay: 0.7s;
        transition-delay: 0.7s;
    }

    .cont_servings>h3 {
        font-size: 24px;
        margin-top: 5px;
        margin-bottom: -15px;
    }

    .cont_servings>span {
        font-size: 9px;
        font-weight: 700;
    }

    .cont_icon_right {
        position: relative;
        float: right;
        margin-top: 16px;
        font-size: 20px;
    }

    .cont_icon_right>a {
        margin: 16px;
        margin-top: 16px;
        color: #fff;
        transition: color 0.3s;
        /* Tambahkan transisi untuk efek smooth */
    }

    .decorated-text {
        position: relative;
        display: flex;
        align-items: center;
    }

    .decorated-text::after {
        content: '';
        display: block;
        width: 940px;
        /* Panjang garis */
        height: 0.1px;
        /* Ketebalan garis */
        background-color: #dcdcdc;
        /* Warna garis */
        margin-left: 10px;
        /* Jarak antara teks dan garis */
    }

    .favorite-icon {
        position: absolute;
        top: 10px;
        right: 13px;
        text-decoration: none;
        color: rgba(0, 0, 0, 0.5);
        /* Warna ikon awal */
        font-size: 1.2em;
        transition: color 0.3s;
    }

    .favorite-icon:hover {
        color: red !important;
    }

    .favorite-icon.active {
        color: red !important;
    }

    .separator {
        border-top: 1px solid #eee;
        margin: 0;
        height: 1px;
        width: 100%;
    }

    * {
        box-sizing: border-box
    }

    body {
        font-family: Verdana, sans-serif;
        margin: 0
    }
</style>
</head>

<body>
    <section class="py-1">
        <div class="container px-4 px-lg-2 mt-1">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="decorated-text">Resep Populer</h1>
                    <div class="row card-container">
                        @foreach ($recipes as $recipe)
                                                                        <div class="col-lg-3 col-md-6 mb-4">
                                                                            <div class="card h-100">
                                                                                <div class="header">
                                                                                    <div class="img-wrapper">
                                                                                        @if($recipe->image)
                                                                                            <img src="{{ str_starts_with($recipe->image, 'http')
    ? $recipe->image
    : Storage::url($recipe->image) }}" class="card-img-top"
                                                                                                alt="{{ $recipe->name }}">
                                                                                            <button class="favorite-icon" data-recipe-id="{{ $recipe->id }}"
                                                                                                style="background: transparent; border: none; outline: none;">
                                                                                                <i class="fa fa-heart" style="color: {{ $recipe->isFavoritedBy(Auth::user()) ? 'red' : 'grey' }}"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="separator"></div>
                                                                                <div class="text">
                                                                                    <h1 class="food">{{ $recipe->name }}</h1>
                                                                                    <i class="fa-solid fa-clock normal-text small-text">{{ $recipe->cooking_time }}
                                                                                        Waktu</i>
                                                                                    <i class="fa fa-users normal-text small-text"> Orang {{ $recipe->servings }}</i>
                                                                                    <div class="stars">
                                                                                        @php
    $rating = $recipe->reviews_avg_rating;
    $full_stars = (int) $rating;
    $half_star = $rating - $full_stars >= 0.5 ? 1 : 0;
                                                                                        @endphp

                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            @if ($i <= $full_stars)
                                                                                                <i class="fas fa-star text-warning"></i>
                                                                                            @elseif ($i - 0.5 == $full_stars && $half_star)
                                                                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                                                            @else
                                                                                                <i class="far fa-star text-warning"></i>
                                                                                            @endif
                                                                                        @endfor
                                                                                        <span class="rating-text">{{ number_format($rating, 1) }}/5</span>
                                                                                    </div>
                                                                                </div>
                                                                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn">Let's Cook!</a>
                                                                            </div>
                                                                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
     document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.favorite-icon').forEach(button => {
                button.addEventListener('click', function () {
                    const recipeId = this.dataset.recipeId;
                    const icon = this.querySelector('i');
                    const isFavorited = icon.style.color === 'red';

                    fetch(`/profile/favorites/${recipeId}`, {
                        method: isFavorited ? 'DELETE' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Recipe added to favorites') {
                                icon.style.color = 'red';
                                alert('Resep berhasil ditambahkan ke favorit!');
                            } else if (data.message === 'Recipe removed from favorites') {
                                icon.style.color = 'grey';
                                alert('Resep berhasil dihapus dari favorit!');
                            } else {
                                alert('Terjadi kesalahan.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
</script>
@endsection
