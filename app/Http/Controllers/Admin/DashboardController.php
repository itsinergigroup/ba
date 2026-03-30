<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        // Filters
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        if ($request->filled('distributor_id')) {
            $query->where('distributor_id', $request->distributor_id);
        }
        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $stats = [
            'total_reports' => (clone $query)->count(),
            'total_ba_active' => User::where('role', 'ba')->count(),
            'total_sell_out' => (clone $query)->sum('total_price'),
        ];

        $reports = (clone $query)->with(['user', 'distributor', 'outlet', 'brand', 'product'])
            ->latest()
            ->paginate(10, ['*'], 'reports_page');

        // Performance / Summary per BA
        $ba_summary = Report::query()
            ->when($request->filled('start_date'), fn($q) => $q->where('date', '>=', $request->start_date))
            ->when($request->filled('end_date'), fn($q) => $q->where('date', '<=', $request->end_date))
            ->when($request->filled('distributor_id'), fn($q) => $q->where('distributor_id', $request->distributor_id))
            ->when($request->filled('outlet_id'), fn($q) => $q->where('outlet_id', $request->outlet_id))
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
            ->selectRaw('user_id, count(*) as total_reports, sum(quantity) as total_qty, sum(total_price) as total_sales')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_sales')
            ->paginate(5, ['*'], 'summary_page');

        // Sales Trend (Last 12 Months or Current Year)
        $sales_trend = Report::selectRaw('MONTH(date) as month, SUM(total_price) as total')
            ->whereYear('date', date('Y'))
            ->when($request->filled('distributor_id'), fn($q) => $q->where('distributor_id', $request->distributor_id))
            ->when($request->filled('outlet_id'), fn($q) => $q->where('outlet_id', $request->outlet_id))
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
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

        $distributors = \App\Models\Distributor::orderBy('name')->get();
        $outlets = \App\Models\Outlet::orderBy('name')->get();
        $bas = User::where('role', 'ba')->orderBy('name')->get();

        return view('admin.dashboard', compact('stats', 'distributors', 'outlets', 'bas', 'reports', 'ba_summary', 'chart_data', 'chart_labels'));
    }
}
