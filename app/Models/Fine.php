<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'borrowing_id',
    'user_id',
    'overdue_days',
    'amount_per_day',
    'total_amount',
    'status',
    'paid_at',
    'note'
])]
class Fine extends Model
{
    use HasFactory;

    # Get the attributes that should be cast
    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    # Relasi ke Borrowing
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    # Relasi ke user (anggota)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
