<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import model User untuk mengambil data pengguna
use App\Models\Recipe;

class UserDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk pengguna.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Mengambil semua pengguna dari model User
        $users = User::all();

        // Mengambil semua resep dari model Recipe
        $recipes = Recipe::all();

        $popularRecipes = Recipe::orderBy('views', 'desc')->limit(3)->get();

        // Mengirim data pengguna dan resep ke tampilan Blade 'user.dashboard'
        return view('user.dashboard', compact('users', 'recipes', 'popularRecipes'));
    }
}
