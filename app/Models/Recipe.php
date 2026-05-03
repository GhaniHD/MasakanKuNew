<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'user_id',
        'description',
        'ingredients',
        'steps',
        'category',
        'servings',
        'cooking_time',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
    ];

    /**
     * Accessor: kembalikan URL gambar yang benar.
     * Support Cloudinary (full URL) dan local storage.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Cloudinary atau URL eksternal
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return Storage::url($this->image);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instructions(): HasMany
    {
        return $this->hasMany(Instruction::class);
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'recipe_id', 'user_id');
    }
}
