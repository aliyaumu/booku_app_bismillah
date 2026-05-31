<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'title',
    'slug',
    'author',
    'publisher',
    'isbn',
    'published_year',
    'synopsis',
    'cover_image',
    'total_stock',
    'available_stock',
    'borrow_count'
])]
class Book extends Model
{
    use HasFactory, SoftDeletes;

    # Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    # Relasi ke Borrowing (Peminjaman)
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    # Relasi ke Review (Ulasan)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    # Relasi ke Wishlist
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
