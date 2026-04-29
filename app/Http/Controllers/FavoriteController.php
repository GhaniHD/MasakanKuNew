<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite($recipeId)
    {
        $user = Auth::user();

        // Check if the recipe is already in favorites
        if ($user->favorites()->where('recipe_id', $recipeId)->exists()) {
            // Remove from favorites
            $user->favorites()->detach($recipeId);
            return response()->json(['message' => 'Recipe removed from favorites'], 200);
        }

        // Add to favorites
        $user->favorites()->attach($recipeId);
        return response()->json(['message' => 'Recipe added to favorites'], 200);
    }

    // Other methods...
}

