@extends('layouts.app')

@section('content')

<style>
    .profile-card {
        display: flex;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-card .avatar {
        flex: 0 0 150px;
        padding: 20px;
    }

    .profile-card .avatar img {
        width: 100%;
        border-radius: 50%;
    }

    .profile-card .user-details {
        flex: 1;
        padding: 20px;
    }

    .profile-card .user-details h2 {
        margin-top: 0;
    }

    .profile-card form {
        margin-top: 20px;
    }

    .profile-card form .form-group {
        margin-bottom: 10px;
    }

    .profile-card form label {
        display: block;
        font-weight: bold;
    }

    .profile-card form input[type="text"],
    .profile-card form input[type="email"],
    .profile-card form input[type="password"] {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .profile-card form button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .profile-card form button:hover {
        background-color: #0056b3;
    }
</style>

<div class="container">
    <div class="profile-card">
        <div class="avatar">
            <img src="{{ $user->profile_picture_url }}" alt="Profile Picture">
        </div>
        <div class="user-details">
            <h2>User Profile</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}">
                </div>
                <button type="submit">Update Profile</button>
            </form>

            <!-- Form untuk mengunggah gambar profil -->
            <h2>Change Profile Picture</h2>
            <form id="profilePictureForm" action="{{ route('profile.update.picture') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" id="profile_picture">
                </div>
                <button type="submit">Upload Picture</button>
            </form>
        </div>
    </div>

    <div class="delete-account">
        <h2>Delete Account</h2>
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit">Delete Account</button>
        </form>
    </div>

    <!-- Tombol untuk menuju halaman favorit -->
    <div class="text-center mt-4">
        <a href="{{ route('profile.favorites') }}">Go to Favorites</a>
    </div>

    @endsection