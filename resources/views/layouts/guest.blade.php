<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MasakanKu') }}</title>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
==
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="guest-wrapper">

        <!-- Sisi kiri: branding -->
        <div class="guest-brand d-none d-md-flex">
            <div class="brand-inner">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="MasakanKu" class="brand-logo">
                </a>
                <h2 class="brand-tagline">Masak lebih enak,<br>hidup lebih bermakna.</h2>
                <p class="brand-sub">Simpan, bagikan, dan temukan resep terbaik bersama komunitas MasakanKu.</p>
            </div>
        </div>

        <!-- Sisi kanan: form -->
        <div class="guest-form-side">

            <!-- Logo mobile -->
            <div class="d-flex d-md-none justify-content-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="MasakanKu" style="height: 40px;">
                </a>
            </div>

            <div class="guest-card">
                {{ $slot }}
            </div>

        </div>
    </div>

</body>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background-color: #FFFAF0;
        font-family: 'Figtree', sans-serif;
    }

    .guest-wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* ── Kiri: Branding ── */
    .guest-brand {
        width: 45%;
        background: linear-gradient(145deg, #FBB917 0%, #f59e0b 60%, #d97706 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .guest-brand::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .guest-brand::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .brand-inner {
        position: relative;
        z-index: 1;
        color: #fff;
    }

    .brand-logo {
        height: 50px;
        margin-bottom: 2rem;
        filter: brightness(0) invert(1);
    }

    .brand-tagline {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 1rem;
    }

    .brand-sub {
        font-size: 1rem;
        opacity: 0.85;
        line-height: 1.6;
    }

    /* ── Kanan: Form ── */
    .guest-form-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .guest-card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 32px rgba(0,0,0,0.08);
    }

    /* ── Sesuaikan komponen Breeze dengan Bootstrap ── */
    .guest-card label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 0.3rem;
    }

    .guest-card input[type="email"],
    .guest-card input[type="password"],
    .guest-card input[type="text"] {
        width: 100%;
        padding: 0.6rem 0.85rem;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
        outline: none;
        background: #FAFAFA;
    }

    .guest-card input:focus {
        border-color: #FBB917;
        box-shadow: 0 0 0 3px rgba(251,185,23,0.15);
        background: #fff;
    }

    .guest-card .mt-4 { margin-top: 1.25rem !important; }
    .guest-card .block { display: block; }
    .guest-card .mt-1 { margin-top: 0.25rem !important; }
    .guest-card .w-full { width: 100%; }

    /* Remember me & link */
    .guest-card .inline-flex {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .guest-card .text-sm { font-size: 0.875rem; }
    .guest-card .text-gray-600 { color: #4B5563; }

    .guest-card .underline {
        text-decoration: underline;
        color: #4B5563;
        font-size: 0.875rem;
    }

    .guest-card .underline:hover { color: #111827; }

    /* Flex row bawah */
    .guest-card .flex { display: flex; }
    .guest-card .items-center { align-items: center; }
    .guest-card .justify-end { justify-content: flex-end; }
    .guest-card .ms-3 { margin-left: 0.75rem; }
    .guest-card .ms-4 { margin-left: 1rem; }

    /* Primary button */
    .guest-card button[type="submit"],
    .guest-card .inline-flex[type="submit"] {
        background-color: #FBB917;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 0.55rem 1.4rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: background-color 0.2s, transform 0.1s;
    }

    .guest-card button[type="submit"]:hover {
        background-color: #e6a80e;
        transform: translateY(-1px);
    }

    /* Error messages */
    .guest-card .text-red-600,
    .guest-card .text-sm.text-red-600 {
        color: #DC2626;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    /* Session status */
    .guest-card .mb-4 { margin-bottom: 1rem !important; }
    .guest-card .font-medium { font-weight: 500; }
    .guest-card .text-green-600 { color: #16A34A; }

    @media (max-width: 767px) {
        .guest-card {
            padding: 1.75rem 1.25rem;
            box-shadow: none;
            border-radius: 12px;
        }
    }
</style>

</html>
