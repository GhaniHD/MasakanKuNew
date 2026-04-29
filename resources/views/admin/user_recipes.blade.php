@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All User Recipes</h1>
    <ul>
        @foreach ($users as $user)
            <h2>{{ $user->name }}</h2>
            <ul>
                @foreach ($user->recipes as $recipe)
                    <li>{{ $recipe->name }}</li>
                @endforeach
            </ul>
        @endforeach
    </ul>
</div>
@endsection
