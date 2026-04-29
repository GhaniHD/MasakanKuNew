<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Assuming you have a Recipe model
use App\Models\Rating; // Assuming you have a Rating model

class RatingController extends Controller
{

    public function store(Request $request, $recipeId)
    {
        // Validate the incoming request data
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Find the recipe by ID
        $recipe = Recipe::findOrFail($recipeId);

        // Create a new rating
        $rating = new Rating();
        $rating->rating = $request->input('rating');
        $rating->recipe_id = $recipe->id;
        $rating->user_id = $request->user()->id; // Assuming the user is authenticated

        // Save the rating
        $rating->save();

        // Return a response
        return response()->json(['message' => 'Rating submitted successfully'], 200);
    }
}
