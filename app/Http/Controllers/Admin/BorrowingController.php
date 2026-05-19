<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $borrowings = Borrowing::with(['user', 'book'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.borrowings.index', compact('borrowings', 'status'));
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['user', 'book', 'fine'])->findOrFail($id);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function requests()
    {
        $requests = Borrowing::with(['user', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.borrowings.requests', compact('requests'));
    }

    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk disetujui.');
        }

        if ($borrowing->book->available_stock < 1) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $borrowing->update([
            'status' => 'borrowed',
            'borrowed_date' => now(),
            'due_date' => now()->addDays(7),
        ]);

        $borrowing->book->decrement('available_stock');

        return back()->with('success', 'Permintaan pinjam berhasil disetujui. Buku dapat diambil oleh anggota.');
    }

    public function reject(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
        }

        $borrowing->update([
            'status' => 'rejected',
            'returned_date' => now()
        ]);

        // Notify member

        return back()->with('success', 'Permintaan pinjam berhasil ditolak.');
    }
}
