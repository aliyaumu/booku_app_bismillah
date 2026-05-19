<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('member.books.index', compact('books', 'categories', 'search', 'categoryId'));
    }

    public function show($slug)
    {
        $book = Book::with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();
            
        // Check if book is in wishlist
        $inWishlist = Auth::user()->wishlists()->where('book_id', $book->id)->exists();
        
        // Check active borrowing
        $activeBorrowing = Auth::user()->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue', 'return_requested'])
            ->first();

        return view('member.books.show', compact('book', 'relatedBooks', 'inWishlist', 'activeBorrowing'));
    }
}
