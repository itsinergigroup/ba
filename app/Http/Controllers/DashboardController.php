<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $stats = [
            'total_reports_month' => Report::where('user_id', $userId)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count(),
            'total_sell_out_month' => Report::where('user_id', $userId)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('total_price'),
            'recent_reports' => Report::where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get(),
        ];

        $hasCheckedInToday = auth()->user()->hasCheckedInToday();

        return view('dashboard', compact('stats', 'hasCheckedInToday'));
    }
}
