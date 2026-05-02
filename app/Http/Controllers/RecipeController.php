<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Recipe;
use App\Models\Instruction;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function create(): View
    {
        return view('recipes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|max:255',
            'instructions' => 'required|array|min:1',
            'instructions.*' => 'required|string',
            'category' => 'required|string|max:255',
            'servings' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:0',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $disk = config('filesystems.default');
            $coverImagePath = $disk === 'cloudinary'
                ? $request->file('cover_image')->store('masakanku/recipes', 'cloudinary')
                : $request->file('cover_image')->store('images', 'public');
        }

        /** @var Recipe $recipe */
        $recipe = Recipe::create([
            'image' => $coverImagePath,
            'name' => $validatedData['name'],
            'user_id' => Auth::id(),
            'description' => $validatedData['description'],
            'ingredients' => json_encode($validatedData['ingredients']),
            'instructions' => json_encode($validatedData['instructions']),
            'category' => $validatedData['category'],
            'servings' => $validatedData['servings'],
            'cooking_time' => $validatedData['cooking_time'],
        ]);

        foreach ($validatedData['instructions'] as $key => $instructionText) {
            $fileKey = 'instruction_images_' . ($key + 1);
            if ($request->hasFile($fileKey)) {
                foreach ($request->file($fileKey) as $file) {
                    $disk = config('filesystems.default');
                    $path = $disk === 'cloudinary'
                        ? $file->store("masakanku/instruction_images/{$recipe->id}", 'cloudinary')
                        : $file->store("instruction_images/{$recipe->id}", 'public');

                    Instruction::create([
                        'nama' => $instructionText,
                        'recipe_id' => $recipe->id,
                        'image' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil ditambahkan');
    }

    public function destroy(int $id): RedirectResponse
    {
        $recipe = Recipe::where('id', $id)->where('user_id', Auth::id())->first();

        if ($recipe) {
            $disk = config('filesystems.default');

            if ($recipe->image && $disk !== 'cloudinary') {
                Storage::disk('public')->delete($recipe->image);
            }

            foreach ($recipe->instructions as $instruction) {
                if ($instruction->image && $disk !== 'cloudinary') {
                    Storage::disk('public')->delete($instruction->image);
                }
            }

            $recipe->delete();
            return redirect()->route('recipes.index')->with('success', 'Resep berhasil dihapus.');
        }

        return redirect()->route('recipes.index')->with('error', 'Resep tidak ditemukan.');
    }

    public function search(Request $request): View
    {
        $query = $request->input('query');
        $recipes = Recipe::where('user_id', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->get();

        return view('recipes.search_results', ['recipes' => $recipes]);
    }

    public function index(): View
    {
        $recipes = Recipe::where('user_id', Auth::id())->with('reviews')->get();
        return view('recipes.index', ['recipes' => $recipes]);
    }

    public function show(int $id): View
    {
        $recipe = Recipe::findOrFail($id);
        $instructions = Instruction::where('recipe_id', $id)->get();
        return view('recipes.show', compact('recipe', 'instructions'));
    }

    public function popular(): View
    {
        $popularRecipes = Recipe::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(20)
            ->get();

        return view('recipes.popular', ['recipes' => $popularRecipes]);
    }

    public function storeReview(Request $request, int $recipeId): RedirectResponse
    {
        Review::create([
            'recipe_id' => $recipeId,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('recipes.show', $recipeId);
    }

    public function storeComment(Request $request, int $recipeId): RedirectResponse
    {
        Comment::create([
            'recipe_id' => $recipeId,
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('recipes.show', $recipeId);
    }

    public function allRecipes(): View
    {
        $recipes = Recipe::all();
        return view('user.allRecipe', compact('recipes'));
    }

    public function category(string $category): View
    {
        $recipes = Recipe::where('category', $category)->get();
        return view('recipes.category', ['recipes' => $recipes, 'category' => $category]);
    }

    public function edit(int $id): View
    {
        $recipe = Recipe::findOrFail($id);
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $recipe = Recipe::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'servings' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:0',
            'ingredients' => 'required|array|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $disk = config('filesystems.default');

            if ($recipe->image && $disk !== 'cloudinary') {
                Storage::disk('public')->delete($recipe->image);
            }

            $validated['image'] = $disk === 'cloudinary'
                ? $request->file('cover_image')->store('masakanku/recipes', 'cloudinary')
                : $request->file('cover_image')->store('images', 'public');
        }

        $recipe->update($validated);

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil diperbarui!');
    }
}
