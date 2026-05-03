<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [RecipeController::class, 'search'])->name('search');
Route::get('/populer', [RecipeController::class, 'popular'])->name('recipes.popular');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update/picture', [ProfileController::class, 'updatePicture'])->name('profile.update.picture');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');

    // Favorites toggle
    Route::post('/profile/favorites/{recipe}', [FavoriteController::class, 'toggleFavorite']);
    Route::delete('/profile/favorites/{recipe}', [FavoriteController::class, 'toggleFavorite']);

    // ✅ Static routes HARUS di atas dynamic /{id}
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::get('/recipes/category/{category}', [RecipeController::class, 'category'])->name('recipes.category');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('recipes.storeReview');
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('recipes.storeComment');
});

// ✅ Route publik show — pakai whereNumber agar 'create' tidak tertangkap
Route::get('/recipes/{id}', [RecipeController::class, 'show'])
    ->name('recipes.show')
    ->whereNumber('id');

Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/recipes', [AdminController::class, 'userRecipes'])->name('admin.userRecipes');
});

Route::prefix('user')->middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/all-recipes', [RecipeController::class, 'allRecipes'])->name('recipes.all');
});

Route::get('/debug-storage', function () {
    return [
        'env' => app()->environment(),
        'storage_path' => storage_path('app/public'),
        'files' => scandir(storage_path('app/public')),
        'profile_pictures' => file_exists(storage_path('app/public/profile_pictures'))
            ? scandir(storage_path('app/public/profile_pictures'))
            : 'folder not found'
    ];
});

require __DIR__ . '/auth.php';
