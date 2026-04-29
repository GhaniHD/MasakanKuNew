@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Manage User Recipes</h5>
            <p class="card-text">View and manage all user recipes.</p>
            <a href="{{ route('admin.userRecipes') }}" class="btn btn-primary">View User Recipes</a>
        </div>
    </div>
</div>
@endsection
