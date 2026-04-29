<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Recipe extends Model
{
    protected $fillable = [
        'cover_image',
        'name',
        'description',
        'servings',
        'cooking_time',
        'ingredients',
        'category', // Tambahkan ini
    ];

    // If ingredients and instructions are stored as JSON
    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    // Define the relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }
    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false; // Atau return null atau nilai yang sesuai dengan kebutuhan Anda
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    // Define the favorites relationship
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'recipe_id', 'user_id');
    }

}
