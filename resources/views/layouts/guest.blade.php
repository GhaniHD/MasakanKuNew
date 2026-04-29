<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-right: 80px;
            background-image: url('images/sunny.png'); /* Ganti dengan path gambar Anda */
            background-size: cover; /* Atur agar gambar menutupi seluruh area */
            background-position: center; /* Posisikan gambar di tengah */
            background-repeat: no-repeat; /* Hindari pengulangan gambar */
        }

        .container {
            max-width: 400px; /* Sesuaikan lebar kontainer sesuai kebutuhan */
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Sesuaikan warna latar kontainer dengan transparansi */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            border-radius: 10px; /* Rounding corners */
        }

        /* Styling untuk link */
        a {
            text-decoration: none;
            color: #333333; /* Warna teks untuk link */
            text-align: center; /* Menengahkan teks horizontal */
            display: block; /* Membuat link menjadi blok sehingga dapat menerapkan margin secara horizontal */
        }

        a:hover {
            color: #555555; /* Warna teks saat link dihover */
        }

        /* Menengahkan gambar */
        .logo {
            margin: 0 auto; /* Menengahkan gambar secara horizontal */
        }

        /* Menengahkan teks */
        text {
            font-size: 50px;
            text-align: center; /* Menengahkan teks horizontal */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Menengahkan teks vertikal */
        }
    </style>
</head>
<body class="">
<div class="container">
    <div>
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500 logo" />
        </a>
    </div>

    <div class="mt-6">
        {{ $slot }}
    </div>
</div>
</body>
</html>
