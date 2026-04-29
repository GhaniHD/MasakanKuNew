<nav class="navbar navbar-expand-lg bg-orange shadow border-bottom">
    <a class="navbar-brand text-white" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="SunnyResep" style="height: 30px; margin-left: 10px;">
    </a>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            @if (Route::has('login'))
                @auth               <form action="{{ route('search') }}" method="GET" class="d-flex justify-center align-center search-form">
                        <input class="form-control search-input me-2" type="text" name="query" placeholder="Cari Resep Terbaik..."
                            required>
                        <button class="btn btn-outline-success search-button" type="submit">Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/user/dashboard') }}"><i class="fa-solid fa-house move-up"
                                style="margin-right: 3px;"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/populer') }}"><i
                                class="fa-brands fa-gratipay fa-lg move-up" style="margin-right: 3px;"></i>Populer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/recipes') }}"><i
                                class="fa-regular fa-square-plus fa-lg move-up" style="margin-right: 3px;"></i>Tambahkan
                            Resep</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/profile') }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/populer') }}"><i
                                class="fa-solid fa-heart-circle-check"></i>Populer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/recipes') }}"><i
                                class="fa-solid fa-pen-to-square fa-lg move-up" style="margin-right: 2px;"></i>Tambahkan
                            Resep</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Profile
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
</nav>

<style>
    .navbar {
        background-color: #FFFFFF !important;
        border-bottom: 2px solid #fff !important;
        /* Border bawah dengan warna abu-abu */
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.2);
        /* Efek bayangan lebih jelas */
    }

    .navbar-brand {
        color: #363636 !important;
    }

    .text-white {
        color: #363636 !important;
    }

    .navbar-brand img.logo-img {
        max-height: 70px;
        /* Atur tinggi maksimum gambar logo */
        width: auto;
        /* Menjaga aspek rasio */
    }

    .text-white:hover {
        color: #d9dddc !important;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(54, 54, 54, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    body {
        background-color: #FFFAF0;

    }

    /* Tambahkan CSS ini ke file CSS Anda */
    .search-form {
        position: absolute;
        top: 50%;
        left: 40%;
        transform: translate(-50%, -50%);
    }

    .search-input {
        width: 300px;
        /* Atur lebar kolom pencarian sesuai keinginan */
    }

    .search-button {
        background-color: #FBB917 !important;
        /* Ubah warna background tombol menjadi putih */
        color: white;
        /* Ubah warna teks tombol menjadi hitam */
        border-color: #ccc;
        /* Ubah warna border tombol */
    }

    /* Tambahkan beberapa hover effects untuk tombol */
    .search-button:hover {
        background-color: #f8f9fa;
        /* Warna background saat hover */
        color: black;
        /* Warna teks saat hover */
        border-color: #aaa;
        /* Warna border saat hover */
    }
</style>