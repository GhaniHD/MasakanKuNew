<?php

namespace App\Http\Controllers;

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
        $recipes = Recipe::with('reviews')->latest()->get();

        $popularRecipes = Recipe::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(5)
            ->get();

        $categories = Recipe::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->take(8);

        // Mengirim data pengguna dan resep ke tampilan Blade 'user.dashboard'
        return view('user.dashboard', compact('users', 'recipes', 'popularRecipes', 'categories'));
    }
}
