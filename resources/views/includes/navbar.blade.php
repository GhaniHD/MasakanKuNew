<nav class="navbar navbar-expand-lg shadow border-bottom">
    <div class="container-fluid px-3">

        <!-- LOGO -->
        <a class="navbar-brand m-0" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="SunnyResep">
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- SEARCH TENGAH -->
            <form action="{{ route('search') }}" method="GET"
                  class="search-form-desktop mx-auto d-none d-lg-flex">
                <input class="form-control search-input me-2"
                       type="text" name="query"
                       placeholder="Cari Resep..." required>
                <button class="btn search-button" type="submit">Search</button>
            </form>

            <!-- KANAN: MENU + PROFILE -->
            <div class="d-flex align-items-center ms-auto right-section">

                <!-- MENU -->
                <ul class="navbar-nav d-flex flex-row align-items-center me-3 menu-right">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/user/dashboard') }}">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/populer') }}">
                            <i class="fa-solid fa-heart"></i> Populer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/recipes') }}">
                            <i class="fa-solid fa-plus"></i> Tambahkan Resep
                        </a>
                    </li>
                </ul>

                <!-- PROFILE -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- SEARCH MOBILE -->
            <form action="{{ route('search') }}" method="GET" class="search-form-mobile">
                <input class="form-control search-input"
                       type="text" name="query"
                       placeholder="Cari Resep..." required>
                <button class="btn search-button" type="submit">Search</button>
            </form>

        </div>
    </div>
</nav>

<style>
/* NAVBAR */
.navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    padding: 10px 15px;
}

.navbar-brand img {
    height: 35px;
}

/* MENU KANAN */
.menu-right {
    gap: 15px;
}

/* NAV LINK */
.nav-link {
    color: #363636 !important;
    font-weight: 500;
    white-space: nowrap;
}

.nav-link:hover {
    color: #FBB917 !important;
}

/* SEARCH */
.search-input {
    border-radius: 8px;
    border: 1px solid #ddd;
    min-width: 250px;
}

.search-button {
    background-color: #FBB917;
    color: white;
    border: none;
    border-radius: 8px;
}

.search-button:hover {
    background-color: #e0a800;
}

/* DROPDOWN */
.dropdown-menu {
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

/* MOBILE SEARCH */
.search-form-mobile {
    display: none;
    flex-direction: column;
    gap: 8px;
    margin-top: 10px;
}

/* RESPONSIVE */
@media (max-width: 991px) {

    .search-form-desktop {
        display: none !important;
    }

    .menu-right {
        flex-direction: column !important;
        align-items: center;
        margin-top: 10px;
    }

    .right-section {
        flex-direction: column;
        align-items: center;
    }

    .search-form-mobile {
        display: flex;
        width: 100%;
    }

    .search-input {
        width: 100%;
    }
}

body {
    background-color: #FFFAF0;
}
</style>
