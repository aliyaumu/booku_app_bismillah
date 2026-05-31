<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'student_id', 'address', 'avatar', 'role', 'status', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{

    use HasFactory, Notifiable;

  
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    # Relasi ke borrowing (peminjaman)
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    # Relasi ke Fine (Denda)
    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    # Relasi ke Riview (ulasan)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    # Relasi ke wishlist
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
