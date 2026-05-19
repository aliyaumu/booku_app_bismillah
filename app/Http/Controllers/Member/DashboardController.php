<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load(['borrowings.book', 'fines']);

        $activeBorrowings = $user->borrowings->whereIn('status', ['approved', 'borrowed', 'overdue', 'return_requested']);
        $unpaidFines = $user->fines->where('status', 'unpaid')->sum('total_amount');

        $latestBooks = Book::with('category')->latest()->take(6)->get();
        $notifications = $user->unreadNotifications()->take(5)->get();

        return view('member.dashboard', compact('activeBorrowings', 'unpaidFines', 'latestBooks', 'notifications'));
    }

    public function markNotificationsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }
}
