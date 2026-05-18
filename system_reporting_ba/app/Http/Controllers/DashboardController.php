<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAnyViewer() && !$user->isAdmin()) {
            return redirect()->route('reports.index');
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $query = Report::query()->whereBetween('date', [$startOfMonth, $endOfMonth]);
        $recentQuery = Report::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
            $recentQuery->where('user_id', $user->id);
        }

        $stats = [
            'total_reports_month' => (clone $query)->count(),
            'total_sell_out_month' => (clone $query)->sum('total_price'),
            'recent_reports' => $recentQuery->with(['product', 'user'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        $hasCheckedInToday = auth()->user()->hasCheckedInToday();
        $isDayOffToday = auth()->user()->hasApprovedDayOffToday();

        $rbsName = $user->isBa() ? optional($user->rbs)->name : null;

        return view('dashboard', compact('stats', 'hasCheckedInToday', 'isDayOffToday', 'rbsName'));
    }
}
