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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update/picture', [ProfileController::class, 'updatePicture'])->name('profile.update.picture');

    Route::get('/recipes/category/{category}', [RecipeController::class, 'category'])->name('recipes.category');

    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');

    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('recipes.storeReview');
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('recipes.storeComment');
    Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');

    // Tambahkan rute untuk menambah atau menghapus favorit
    Route::post('profile/favorites/{recipe}', [FavoriteController::class, 'toggleFavorite']);
    Route::delete('profile/favorites/{recipe}', [FavoriteController::class, 'toggleFavorite']);
});

Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/populer', [RecipeController::class, 'popular'])->name('recipes.popular');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/recipes', [AdminController::class, 'userRecipes'])->name('admin.userRecipes');
})->middleware(['auth', 'verified', 'admin']);

Route::prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/all-recipes', [RecipeController::class, 'allRecipes'])->name('recipes.all'); // Tambahkan rute ini
})->middleware(['auth', 'verified', 'user']);

require __DIR__ . '/auth.php';
