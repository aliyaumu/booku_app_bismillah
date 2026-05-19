<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('book.category')->latest()->paginate(12);
        return view('member.wishlist.index', compact('wishlists'));
    }

    public function toggle($bookId)
    {
        $user = Auth::user();
        $wishlist = $user->wishlists()->where('book_id', $bookId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Buku dihapus dari wishlist.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
            ]);
            return back()->with('success', 'Buku ditambahkan ke wishlist.');
        }
    }
}
