<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;

require __DIR__ . '/auth.php';

// Admin Controllers Import
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BookController as AdminBook;
use App\Http\Controllers\Admin\MemberController as AdminMember;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowing;
use App\Http\Controllers\Admin\ReturnController as AdminReturn;
use App\Http\Controllers\Admin\FineController as AdminFine;
use App\Http\Controllers\Admin\StatisticsController as AdminStatistics;

// User Controllers Import
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\CatalogController as MemberCatalog;
use App\Http\Controllers\Member\BorrowingController as MemberBorrowing;
use App\Http\Controllers\Member\WishlistController as MemberWishlist;
use App\Http\Controllers\Member\ReviewController as MemberReview;


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
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Books CRUD
    Route::resource('/books', AdminBook::class);
    Route::get('/books/{book}/qr', [AdminBook::class, 'qrCode'])->name('books.qr');

    // Members CRUD
    Route::resource('/members', AdminMember::class);

    // Borrowings & Returns Management
    Route::get('/borrowings/requests', [AdminBorrowing::class, 'requests'])->name('borrowings.requests');
    Route::patch('/borrowings/{borrowing}/approve', [AdminBorrowing::class, 'approve'])->name('borrowings.approve');
    Route::patch('/borrowings/{borrowing}/reject', [AdminBorrowing::class, 'reject'])->name('borrowings.reject');
    Route::resource('/borrowings', AdminBorrowing::class)->only(['index', 'show']);

    // Return Verification
    Route::get('/returns', [AdminReturn::class, 'index'])->name('returns.index');
    Route::patch('/returns/{borrowing}/verify', [AdminReturn::class, 'verify'])->name('returns.verify');

    // Fines Management
    Route::resource('/fines', AdminFine::class)->only(['index', 'show']);
    Route::patch('/fines/{fine}/pay', [AdminFine::class, 'markPaid'])->name('fines.pay');

    // Statistics Page
    Route::get('/statistics', [AdminStatistics::class, 'index'])->name('statistics');
});

// Member Routes (Auth & Member role required)
Route::prefix('member')->middleware(['auth', 'member'])->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
    Route::patch('/notifications/read', [MemberDashboard::class, 'markNotificationsRead'])->name('notifications.markRead');

    // Catalog browsing
    Route::get('/books', [MemberCatalog::class, 'index'])->name('books.index');
    Route::get('/books/{slug}', [MemberCatalog::class, 'show'])->name('books.show');

    // Borrowing Operations
    Route::post('/books/{book}/borrow', [MemberBorrowing::class, 'store'])->name('books.borrow');
    Route::patch('/borrowings/{borrowing}/return', [MemberBorrowing::class, 'requestReturn'])->name('borrowings.return');
    Route::get('/borrowings', [MemberBorrowing::class, 'index'])->name('borrowings.index');
    Route::get('/history', [MemberBorrowing::class, 'history'])->name('history');

    // Wishlist
    Route::get('/wishlist', [MemberWishlist::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{book}', [MemberWishlist::class, 'toggle'])->name('wishlist.toggle');

    // Book Reviews
    Route::post('/books/{book}/review', [MemberReview::class, 'store'])->name('books.review');
});

// Standard Breeze Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
