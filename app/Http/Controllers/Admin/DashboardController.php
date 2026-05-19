<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::sum('total_stock'),
            'total_members' => User::where('role', 'member')->count(),
            'active_borrowings' => Borrowing::whereIn('status', ['borrowed', 'overdue'])->count(),
            'pending_requests' => Borrowing::where('status', 'pending')->count(),
            'total_fines' => Fine::where('status', 'unpaid')->sum('total_amount'),
        ];

        $recentRequests = Borrowing::with(['user', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentReturns = Borrowing::with(['user', 'book'])
            ->where('status', 'return_requested')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentReturns'));
    }
}
