<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:200',
            'publisher' => 'nullable|string|max:200',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'total_stock' => 'required|integer|min:1',
            'synopsis' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['available_stock'] = $validated['total_stock'];

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load('category');
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:200',
            'publisher' => 'nullable|string|max:200',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'total_stock' => 'required|integer|min:0',
            'synopsis' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Adjust available stock if total stock changes
        $stockDiff = $validated['total_stock'] - $book->total_stock;
        $validated['available_stock'] = $book->available_stock + $stockDiff;
        if ($validated['available_stock'] < 0) {
            return back()->withInput()->withErrors(['total_stock' => 'Stok total tidak bisa kurang dari buku yang sedang dipinjam.']);
        }

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $validated['cover_image'] = $path;
        }

        if ($validated['title'] !== $book->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function qrCode(Book $book)
    {
        return view('admin.books.qr', compact('book'));
    }
}
