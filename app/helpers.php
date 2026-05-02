<?php
/**
 * Helper untuk mendapatkan URL gambar
 * Support Cloudinary (full URL) dan local storage
 *
 * Cara pakai di Blade:
 *   <img src="{{ recipe_image($recipe->image) }}">
 *   <img src="{{ recipe_image($recipe->image, asset('images/default-recipe.png')) }}">
 */

if (!function_exists('recipe_image')) {
    function recipe_image(?string $path, string $default = ''): string
    {
        if (!$path) {
            return $default;
        }

        // Cloudinary atau URL eksternal lain
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Local storage
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (!function_exists('user_avatar')) {
    function user_avatar(?string $url, string $default = ''): string
    {
        if (!$url) {
            return $default ?: 'https://ui-avatars.com/api/?name=User&background=FBB917&color=fff';
        }

        // Cloudinary atau URL eksternal
        if (str_starts_with($url, 'http')) {
            return $url;
        }

        return \Illuminate\Support\Facades\Storage::url($url);
    }
}
