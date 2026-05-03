<nav class="navbar navbar-expand-lg shadow border-bottom">
    <div class="container-fluid px-3">

        <!-- LOGO -->
        <a class="navbar-brand m-0" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="SunnyResep">
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- SEARCH DESKTOP -->
            <form action="{{ route('search') }}" method="GET"
                  class="search-form-desktop mx-auto d-none d-lg-flex">
                <input class="form-control search-input me-2"
                       type="text" name="query"
                       placeholder="Cari Resep..." required>
                <button class="btn search-button" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i> Search
                </button>
            </form>

            <!-- KANAN: MENU + PROFILE -->
            <div class="d-flex align-items-center ms-auto right-section">

                @auth

                {{-- ===== DESKTOP MENU ===== --}}
                <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center me-3 menu-right">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/user/dashboard') }}">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/populer') }}">
                            <i class="fa-solid fa-fire"></i> Populer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/recipes') }}">
                            <i class="fa-solid fa-plus"></i> Tambah Resep
                        </a>
                    </li>
                </ul>

                <!-- PROFILE DROPDOWN — DESKTOP ONLY -->
                <div class="dropdown d-none d-lg-block">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                       href="#" data-bs-toggle="dropdown">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}"
                                 class="nav-avatar" alt="Avatar">
                        @else
                            <i class="fa-solid fa-circle-user fs-5"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="fa-solid fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.favorites') }}">
                                <i class="fa-solid fa-heart me-2"></i> Favorit Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- ===== MOBILE MENU ===== --}}
                <div class="mobile-menu d-lg-none w-100">

                    {{-- Profil di paling atas --}}
                    <div class="mobile-profile-header">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}"
                                 class="mobile-avatar" alt="Avatar">
                        @else
                            <div class="mobile-avatar-icon">
                                <i class="fa-solid fa-circle-user"></i>
                            </div>
                        @endif
                        <div class="mobile-profile-info">
                            <span class="mobile-profile-name">{{ Auth::user()->name }}</span>
                            <span class="mobile-profile-email">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    {{-- Grid menu 2 kolom --}}
                    <div class="mobile-nav-grid">
                        <a href="{{ url('/user/dashboard') }}" class="mobile-nav-item">
                            <i class="fa-solid fa-house"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ url('/populer') }}" class="mobile-nav-item">
                            <i class="fa-solid fa-fire"></i>
                            <span>Populer</span>
                        </a>
                        <a href="{{ url('/recipes') }}" class="mobile-nav-item">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tambah Resep</span>
                        </a>
                        <a href="{{ url('/profile') }}" class="mobile-nav-item">
                            <i class="fa-solid fa-user"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('profile.favorites') }}" class="mobile-nav-item">
                            <i class="fa-solid fa-heart"></i>
                            <span>Favorit</span>
                        </a>
                        <a href="#" class="mobile-nav-item mobile-nav-logout"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>

                @endauth

                @guest
                <ul class="navbar-nav d-flex flex-row align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm px-3" href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                </ul>
                @endguest

            </div>

            <!-- SEARCH MOBILE -->
            <form action="{{ route('search') }}" method="GET" class="search-form-mobile">
                <div class="search-mobile-wrap">
                    <input class="form-control search-input"
                           type="text" name="query"
                           placeholder="Cari Resep..." required>
                    <button class="btn search-button" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</nav>

<style>
/* ===== NAVBAR BASE ===== */
.navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    padding: 10px 15px;
}

.navbar-brand img { height: 35px; }

.menu-right { gap: 15px; }

.nav-link {
    color: #363636 !important;
    font-weight: 500;
    white-space: nowrap;
}

.nav-link:hover { color: #FBB917 !important; }

/* Desktop avatar */
.nav-avatar {
    width: 28px; height: 28px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #FBB917;
}

/* Search */
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
    white-space: nowrap;
}

.search-button:hover { background-color: #e0a800; color: #fff; }

/* Dropdown desktop */
.dropdown-menu {
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.dropdown-item.text-danger:hover { background: #fff5f5; }

/* ===== MOBILE SEARCH ===== */
.search-form-mobile {
    display: none;
    margin-top: 12px;
}

.search-mobile-wrap {
    display: flex;
    gap: 8px;
    width: 100%;
}

.search-mobile-wrap .search-input { flex: 1; min-width: 0; }

/* ===== MOBILE MENU ===== */
.mobile-menu {
    padding: 4px 0 8px;
}

/* Profil header mobile */
.mobile-profile-header {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #FBB917 0%, #e5a805 100%);
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 12px;
}

.mobile-avatar {
    width: 48px; height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.6);
    flex-shrink: 0;
}

.mobile-avatar-icon {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.mobile-avatar-icon i {
    font-size: 1.6rem;
    color: #fff;
}

.mobile-profile-info {
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.mobile-profile-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.mobile-profile-email {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.8);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Grid menu 2 kolom */
.mobile-nav-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}

.mobile-nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    background: #f9f9f9;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    text-decoration: none;
    color: #363636;
    font-size: 0.85rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
}

.mobile-nav-item i {
    font-size: 1rem;
    color: #FBB917;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
}

.mobile-nav-item:hover {
    background: #fff8e6;
    border-color: #FBB917;
    color: #363636;
}

/* Logout item */
.mobile-nav-logout {
    color: #e74c3c;
}

.mobile-nav-logout i {
    color: #e74c3c;
}

.mobile-nav-logout:hover {
    background: #fff5f5;
    border-color: #e74c3c;
    color: #e74c3c;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991px) {
    .search-form-desktop { display: none !important; }
    .search-form-mobile { display: block; }
    .right-section { width: 100%; }
}

body { background-color: #FFFAF0; }
</style>
