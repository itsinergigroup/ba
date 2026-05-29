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
            'total_reports_month' => (clone $query)->count(), // if needed elsewhere
            'total_sell_out_month' => (clone $query)->sum('total_price'), // if needed elsewhere
            'total_reports' => (clone $query)->count(),
            'total_ba_active' => \App\Models\User::where('role', 'ba')->count(),
            'total_sell_out' => (clone $query)->sum('total_price'),
            'recent_reports' => $recentQuery->with(['product', 'user'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        // Sales Trend (Current Year)
        $sales_trend = Report::selectRaw('MONTH(date) as month, SUM(total_price) as total')
            ->whereYear('date', date('Y'))
            ->when(!$user->isAdmin(), fn($q) => $q->where('user_id', $user->id))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();

        $chart_data = [];
        $chart_labels = [];
        for ($m = 1; $m <= 12; $m++) {
            $chart_labels[] = date('M', mktime(0, 0, 0, $m, 1));
            $chart_data[] = $sales_trend[$m] ?? 0;
        }

        $hasCheckedInToday = auth()->user()->hasCheckedInToday();
        $hasCheckedOutToday = auth()->user()->hasCheckedOutToday();
        $isDayOffToday = auth()->user()->hasApprovedDayOffToday();
        $todayCheckIn = $hasCheckedInToday ? auth()->user()->getTodayCheckIn() : null;

        $rbsName = $user->isBa() ? optional($user->rbs)->name : null;
        $rbsRole = $user->isBa() ? strtoupper(optional($user->rbs)->role) : null;

        return view('dashboard', compact('stats', 'hasCheckedInToday', 'hasCheckedOutToday', 'isDayOffToday', 'rbsName', 'rbsRole', 'todayCheckIn', 'chart_data', 'chart_labels'));
    }
}
