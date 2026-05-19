<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Auth::user()->borrowings()
            ->with('book')
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue', 'return_requested'])
            ->latest()
            ->get();

        $history = Auth::user()->borrowings()
            ->with('book')
            ->whereIn('status', ['returned', 'rejected'])
            ->latest()
            ->paginate(10);

        return view('member.borrowings.index', compact('borrowings', 'history'));
    }

    public function store(Request $request, Book $book)
    {
        if ($book->available_stock < 1) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        $activeBorrowingsCount = Auth::user()->borrowings()
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])
            ->count();

        if ($activeBorrowingsCount >= 3) {
            return back()->with('error', 'Anda telah mencapai batas maksimal peminjaman (3 buku).');
        }

        $alreadyBorrowed = Auth::user()->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue', 'return_requested'])
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        // Unpaid fines limit
        $unpaidFines = Auth::user()->fines()->where('status', 'unpaid')->sum('total_amount');
        if ($unpaidFines > 0) {
            return back()->with('error', 'Anda memiliki denda yang belum dibayar sebesar Rp ' . number_format($unpaidFines, 0, ',', '.') . '. Harap lunasi denda sebelum meminjam buku baru.');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        return redirect()->route('member.borrowings.index')->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function requestReturn(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($borrowing->status, ['borrowed', 'overdue'])) {
            return back()->with('error', 'Buku ini tidak dalam status dipinjam.');
        }

        $borrowing->update(['status' => 'return_requested']);

        return back()->with('success', 'Permintaan pengembalian buku berhasil dikirim. Harap serahkan buku fisik ke petugas.');
    }
}
