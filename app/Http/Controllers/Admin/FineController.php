<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $fines = Fine::with(['user', 'borrowing.book'])
            ->when($status === 'paid', function ($q) {
                $q->where('status', 'paid');
            })
            ->when($status === 'unpaid', function ($q) {
                $q->where('status', 'unpaid');
            })
            ->latest()
            ->paginate(15);

        return view('admin.fines.index', compact('fines', 'status'));
    }

    public function show($id)
    {
        $fine = Fine::with(['user', 'borrowing.book'])->findOrFail($id);
        return view('admin.fines.show', compact('fine'));
    }

    public function markPaid(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Denda berhasil ditandai sebagai lunas.');
    }
}
