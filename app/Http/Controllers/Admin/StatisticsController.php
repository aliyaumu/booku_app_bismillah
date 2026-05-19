<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $popularBooks = Borrowing::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->with('book')
            ->take(5)
            ->get();

        $activeMembers = Borrowing::select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->take(5)
            ->get();

        // Database-agnostic query compatible with SQLite (local/testing) and MySQL
        $borrowingsByMonth = Borrowing::select('created_at')
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function ($borrowing) {
                return $borrowing->created_at->format('n'); // Returns 1-12
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $borrowingsByMonth[$i] ?? 0;
        }

        return view('admin.statistics.index', compact('popularBooks', 'activeMembers', 'monthlyData'));
    }
}
