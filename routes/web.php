<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Member;
use Illuminate\Support\Facades\Route;

// Public / Guest Routes
Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/books', [PublicController::class, 'catalog'])->name('books.catalog');
Route::get('/books/{slug}', [PublicController::class, 'show'])->name('books.show');

// Redirect Auth Dashboard based on Role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('member.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes (Auth & Admin role required)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Books CRUD
    Route::resource('/books', Admin\BookController::class);
    Route::get('/books/{book}/qr', [Admin\BookController::class, 'qrCode'])->name('books.qr');
    
    // Members CRUD
    Route::resource('/members', Admin\MemberController::class);
    
    // Borrowings & Returns Management
    Route::get('/borrowings/requests', [Admin\BorrowingController::class, 'requests'])->name('borrowings.requests');
    Route::patch('/borrowings/{borrowing}/approve', [Admin\BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::patch('/borrowings/{borrowing}/reject', [Admin\BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::resource('/borrowings', Admin\BorrowingController::class)->only(['index', 'show']);
    
    // Return Verification
    Route::get('/returns', [Admin\ReturnController::class, 'index'])->name('returns.index');
    Route::patch('/returns/{borrowing}/verify', [Admin\ReturnController::class, 'verify'])->name('returns.verify');
    
    // Fines Management
    Route::resource('/fines', Admin\FineController::class)->only(['index', 'show']);
    Route::patch('/fines/{fine}/pay', [Admin\FineController::class, 'markPaid'])->name('fines.pay');
    
    // Statistics Page
    Route::get('/statistics', [Admin\StatisticsController::class, 'index'])->name('statistics');
});

// Member Routes (Auth & Member role required)
Route::prefix('member')->middleware(['auth', 'member'])->name('member.')->group(function () {
    Route::get('/dashboard', [Member\DashboardController::class, 'index'])->name('dashboard');
    
    // Catalog browsing
    Route::get('/books', [Member\CatalogController::class, 'index'])->name('books.index');
    Route::get('/books/{slug}', [Member\CatalogController::class, 'show'])->name('books.show');
    
    // Borrowing Operations
    Route::post('/books/{book}/borrow', [Member\BorrowingController::class, 'store'])->name('books.borrow');
    Route::patch('/borrowings/{borrowing}/return', [Member\BorrowingController::class, 'requestReturn'])->name('borrowings.return');
    Route::get('/borrowings', [Member\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/history', [Member\BorrowingController::class, 'history'])->name('history');
    
    // Wishlist
    Route::get('/wishlist', [Member\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{book}', [Member\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    // Book Reviews
    Route::post('/books/{book}/review', [Member\ReviewController::class, 'store'])->name('books.review');
});

// Standard Breeze Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
