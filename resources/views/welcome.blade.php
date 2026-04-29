@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-image: url('images/bg1.png');
            background-size: cover;
            background-position: center 35px;
            margin: 0;
            padding: 0;
        }
        .overlay {
            height: calc(100vh - 150px); /* Kurangi tinggi overlay untuk margin negatif */
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            flex-direction: column;
            padding: 20px;
            margin-top: -20px; /* Naikkan overlay ke atas */
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        p {
            font-size: 1.25rem;
            margin-bottom: 40px;
        }
        .search-bar {
            display: flex;
            width: 100%;
            max-width: 600px;
        }
        .search-bar input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px 0 0 4px;
        }
        .search-bar button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 0 4px 4px 0;
            background-color: #ff6347;
            color: white;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #ff4500;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <h1>Welcome to Sunny Resep</h1>
        <p>Find the best recipes from around the world.</p>
        <form action="{{ route('search') }}" method="GET" class="search-bar">
            <input type="text" name="query" placeholder="Search for a recipe..." required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>

@endsection
