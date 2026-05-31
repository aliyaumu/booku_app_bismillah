<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'book_id'
])]
class Wishlist extends Model
{
    use HasFactory;

    # Relasi ke user (Anggota)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    # Relasi ke book (buku)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
