<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Simpan review baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $recipeId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $recipeId)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Buat objek review baru
        $review = new Review();
        $review->recipe_id = $recipeId; // ID resep yang di-review
        $review->user_id = auth()->id(); // ID pengguna yang memberi review
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];

        // Simpan review ke basis data
        $review->save();

        // Redirect pengguna kembali ke halaman resep atau ke halaman lain
        return redirect()->back()->with('success', 'Review berhasil ditambahkan.');
    }
}
