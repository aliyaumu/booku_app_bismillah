<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = Borrowing::with(['user', 'book'])
            ->where('status', 'return_requested')
            ->latest()
            ->paginate(15);

        return view('admin.returns.index', compact('returns'));
    }

    public function verify(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'return_requested') {
            return back()->with('error', 'Peminjaman tidak dalam status pengajuan pengembalian.');
        }

        $now = now();
        $borrowing->update([
            'status' => 'returned',
            'returned_date' => $now,
        ]);

        $borrowing->book->increment('available_stock');

        // Calculate fine if overdue
        $dueDate = Carbon::parse($borrowing->due_date)->endOfDay();
        if ($now->gt($dueDate)) {
            $daysLate = $now->startOfDay()->diffInDays($dueDate->copy()->startOfDay());
            if ($daysLate > 0) {
                // Fine: Rp 1000 per day (as per PRD)
                $fineAmount = $daysLate * 1000;
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'user_id' => $borrowing->user_id,
                    'overdue_days' => $daysLate,
                    'amount_per_day' => 1000,
                    'total_amount' => $fineAmount,
                    'status' => 'unpaid',
                ]);
            }
        }

        return back()->with('success', 'Pengembalian buku berhasil diverifikasi. Stok telah diperbarui.');
    }
}
