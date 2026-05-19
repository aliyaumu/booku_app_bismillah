<?php

use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates overdue borrowings and calculates fines', function () {
    $user = User::factory()->create(['role' => 'member']);
    $category = Category::create([
        'name' => 'Fiction',
        'slug' => 'fiction',
        'color' => '#F59E0B',
    ]);
    $book = Book::create([
        'category_id' => $category->id,
        'title' => 'Test Book',
        'slug' => 'test-book',
        'author' => 'Test Author',
        'total_stock' => 5,
        'available_stock' => 5,
    ]);

    // Create a borrowing that is past its due date
    $borrowing = Borrowing::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'status' => 'borrowed',
        'borrowed_date' => now()->subDays(10)->toDateString(),
        'due_date' => now()->subDays(3)->toDateString(), // 3 days overdue
    ]);

    // Run the command
    $exitCode = Artisan::call('booku:update-overdue');
    expect($exitCode)->toBe(0);

    // Refresh model from DB
    $borrowing->refresh();

    // Assert status updated to overdue
    expect($borrowing->status)->toBe('overdue');

    // Assert fine record created
    $fine = Fine::where('borrowing_id', $borrowing->id)->first();
    expect($fine)->not->toBeNull();
    expect($fine->overdue_days)->toBe(3);
    expect($fine->total_amount)->toBe(3000);
    expect($fine->status)->toBe('unpaid');
});
