<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Instruction;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;

class RecipeController extends Controller
{
    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|max:255',
            'instructions' => 'required|array|min:1',
            'instructions.*' => 'required|string',
            'instruction_images_*.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|max:255',
            'servings' => 'required|integer|min:1', // Validate servings
            'cooking_time' => 'required|integer|min:0', // Validate cooking time
        ]);

        // Handle the cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('public/images');
        }

        // Store recipe
        $recipe = new Recipe();
        $recipe->image = $coverImagePath ?? null;
        $recipe->name = $validatedData['name'];
        $recipe->user_id = Auth::id();
        $recipe->description = $validatedData['description'];
        $recipe->ingredients = json_encode($validatedData['ingredients']);
        $recipe->instructions = json_encode($validatedData['instructions']);
        $recipe->category = $validatedData['category'];
        $recipe->servings = $validatedData['servings']; // Store servings
        $recipe->cooking_time = $validatedData['cooking_time']; // Store cooking time
        $recipe->save();

        // Handle instruction images upload and store in instructions table
        foreach ($validatedData['instructions'] as $key => $instruction) {
            if ($request->hasFile("instruction_images_" . ($key + 1))) {
                foreach ($request->file("instruction_images_" . ($key + 1)) as $file) {
                    $path = $file->store("public/instruction_images/{$recipe->id}");

                    $instructionModel = new Instruction();
                    $instructionModel->nama = $instruction;
                    $instructionModel->recipe_id = $recipe->id;
                    $instructionModel->image = $path;
                    $instructionModel->save();
                }
            }
        }

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil ditambahkan');
    }

    public function destroy($id)
    {
        // Hapus resep
        $recipe = Recipe::where('id', $id)->where('user_id', Auth::id())->first();

        if ($recipe) {
            if ($recipe->image) {
                Storage::delete('public/' . $recipe->image);
            }

            $recipe->delete();

            return redirect()->route('recipes.index')->with('success', 'Resep berhasil dihapus.');
        }

        return redirect()->route('recipes.index')->with('error', 'Resep tidak ditemukan.');
    }

    public function search(Request $request)
    {
        // Cari resep
        $query = $request->input('query');
        $recipes = Recipe::where('user_id', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->get();

        return view('recipes.search_results', ['recipes' => $recipes]);
    }

    public function index()
    {
        // Tampilkan semua resep milik pengguna yang terautentikasi
        $recipes = Recipe::where('user_id', Auth::id())->with('reviews')->get();
        return view('recipes.index', ['recipes' => $recipes]);
    }

    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);
        $instructions = Instruction::where('recipe_id', $id)->get();
        return view('recipes.show', compact('recipe', 'instructions'));
    }

    public function popular()
    {
        // Tampilkan resep berdasarkan popularitasnya
        $popularRecipes = Recipe::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(20)
            ->get();

        return view('recipes.popular', ['recipes' => $popularRecipes]);
    }

    public function storeReview(Request $request, $recipeId)
    {
        // Simpan review resep
        $review = new Review;
        $review->recipe_id = $recipeId;
        $review->user_id = Auth::id();
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->route('recipes.show', $recipeId);
    }

    public function storeComment(Request $request, $recipeId)
    {
        // Simpan komentar resep
        $comment = new Comment;
        $comment->recipe_id = $recipeId;
        $comment->user_id = Auth::id();
        $comment->comment = $request->input('comment');
        $comment->save();

        return redirect()->route('recipes.show', $recipeId);
    }

    // Metode untuk halaman "all recipes"
    public function allRecipes()
    {
        $recipes = Recipe::all(); // Ambil semua resep dari database
        return view('user.allRecipe', compact('recipes')); // Kembalikan tampilan dengan data resep
    }
    public function category($category)
    {
        $recipes = Recipe::where('category', $category)->get();
        return view('recipes.category', ['recipes' => $recipes, 'category' => $category]);
    }

    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($request->all());

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil diperbarui!');
    }
}
