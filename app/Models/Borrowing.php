<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'book_id',
    'borrowed_date',
    'due_date',
    'returned_date',
    'duration_days',
    'status',
    'admin_note',
    'return_note'
])]
class Borrowing extends Model
{
    use HasFactory;

    # Get the attributes that should be cast
    protected function casts(): array
    {
        return [
            'borrowed_date' => 'date',
            'due_date' => 'date',
            'returned_date' => 'date',
        ];
    }

    # Relasi ke user (Anggota)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    # relasi ke book (buku)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    # Relasi ke fine (denda)
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }
}
