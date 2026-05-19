<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        $categories = Category::orderBy('name')->get();

        $books = Book::with(['category', 'reviews'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->paginate(12)
            ->withQueryString();

        return view('member.books.index', compact('books', 'categories'));
    }

    public function show($slug)
    {
        $book = Book::with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        $user = Auth::user();

        // Check if there is an active borrowing for this book by this user
        $activeBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue', 'return_requested'])
            ->first();

        // Check if the book is in the user's wishlist
        $inWishlist = $user->wishlists()->where('book_id', $book->id)->exists();

        // Related books (same category, excluding current book)
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('member.books.show', compact('book', 'activeBorrowing', 'inWishlist', 'relatedBooks'));
    }
}
