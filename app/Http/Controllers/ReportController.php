<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Distributor;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Province;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['distributor', 'outlet', 'brand', 'product'])
            ->where('user_id', auth()->id());

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        // Ambil semua data dan kelompokkan berdasarkan group_id
        $allGrouped = $query->latest()->get()->groupBy('group_id');

        // Manual Pagination untuk Collection yang sudah di-group
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $currentItems = $allGrouped->slice(($currentPage - 1) * $perPage, $perPage);

        $reports = new LengthAwarePaginator(
            $currentItems,
            $allGrouped->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $user = auth()->user();
        if ($user->role === 'ba') {
            $outlets = $user->outlets()->orderBy('name')->get();
        } else {
            $outlets = Outlet::orderBy('name')->get();
        }

        return view('reports.index', compact('reports', 'outlets'));
    }

    public function create()
    {
        $user = auth()->user();
        $brands = Brand::all();

        // If BA, only show their assigned distributor and outlets
        if ($user->role === 'ba') {
            $distributors = Distributor::where('id', $user->distributor_id)->get();
            $provinces = $user->outlets()
                ->join('cities', 'outlets.city_id', '=', 'cities.id')
                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                ->select('provinces.*')
                ->distinct()
                ->orderBy('provinces.name')
                ->get();
        } else {
            $distributors = Distributor::all();
            $provinces = Province::orderBy('name')->get();
        }

        return view('reports.create', compact('distributors', 'provinces', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'distributor_id' => 'required|exists:distributors,id',
            'account_type' => 'required|in:GT,MT',
            'channel' => 'required|in:Direct,Indirect',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'outlet_id' => 'required|exists:outlets,id',
            'items' => 'required|array|min:1',
            'items.*.brand_id' => 'required|exists:brands,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|string', // Validated as string first because of formatting
        ]);

        // Generate a unique ID for this transaction group
        $groupId = 'TRX-' . strtoupper(uniqid());

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            // Sanitize unit_price (remove dots)
            $unitPrice = str_replace('.', '', $item['unit_price']);
            $unitPrice = (float) $unitPrice;

            $het = $product->het;
            $discount = (($het - $unitPrice) / $het) * 100;
            $totalPrice = $unitPrice * $item['quantity'];

            Report::create([
                'user_id' => auth()->id(),
                'group_id' => $groupId,
                'date' => $request->date,
                'distributor_id' => $request->distributor_id,
                'account_type' => $request->account_type,
                'channel' => $request->channel,
                'outlet_id' => $request->outlet_id,
                'brand_id' => $item['brand_id'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'het' => $het,
                'unit_price' => $unitPrice,
                'discount' => $discount,
                'total_price' => $totalPrice,
            ]);
        }

        return redirect()->route('reports.index')->with('success', count($request->items) . ' Item produk berhasil dikirimkan.');
    }

    public function edit(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        // Fetch all related items in the group if applicable
        if ($report->group_id) {
            $reports = Report::where('group_id', $report->group_id)->get();
        } else {
            $reports = collect([$report]);
        }

        $user = auth()->user();
        if ($user->role === 'ba') {
            $distributors = Distributor::where('id', $user->distributor_id)->get();
            $provinces = $user->outlets()
                ->join('cities', 'outlets.city_id', '=', 'cities.id')
                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                ->select('provinces.*')
                ->distinct()
                ->orderBy('provinces.name')
                ->get();
        } else {
            $distributors = Distributor::all();
            $provinces = Province::orderBy('name')->get();
        }
        $brands = Brand::all();

        return view('reports.edit', compact('report', 'reports', 'distributors', 'provinces', 'brands'));
    }

    public function show(Report $report)
    {
        // If the report has a group_id, fetch all items in that group
        if ($report->group_id) {
            $reports = Report::where('group_id', $report->group_id)
                ->with(['distributor', 'outlet.city.province', 'brand', 'product', 'user'])
                ->get();
            $mainReport = $reports->first();
        } else {
            // Fallback for old reports without group_id
            $reports = collect([$report->load(['distributor', 'outlet.city.province', 'brand', 'product', 'user'])]);
            $mainReport = $report;
        }

        return view('reports.show', compact('reports', 'mainReport'));
    }

    public function update(Request $request, Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'distributor_id' => 'required|exists:distributors,id',
            'account_type' => 'required|in:GT,MT',
            'channel' => 'required|in:Direct,Indirect',
            'outlet_id' => 'required|exists:outlets,id',
            'items' => 'required|array|min:1',
            'items.*.brand_id' => 'required|exists:brands,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|string',
        ]);

        $groupId = $report->group_id ?: 'TRX-' . strtoupper(uniqid());

        // Delete existing items in this group before re-creating
        if ($report->group_id) {
            Report::where('group_id', $groupId)->delete();
        } else {
            $report->delete(); // Old single report
        }

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $unitPrice = (float) str_replace('.', '', $item['unit_price']);
            $het = $product->het;
            $discount = (($het - $unitPrice) / $het) * 100;
            $totalPrice = $unitPrice * $item['quantity'];

            Report::create([
                'user_id' => auth()->id(),
                'group_id' => $groupId,
                'date' => $request->date,
                'distributor_id' => $request->distributor_id,
                'account_type' => $request->account_type,
                'channel' => $request->channel,
                'outlet_id' => $request->outlet_id,
                'brand_id' => $item['brand_id'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'het' => $het,
                'unit_price' => $unitPrice,
                'discount' => $discount,
                'total_price' => $totalPrice,
            ]);
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        if ($report->group_id) {
            Report::where('group_id', $report->group_id)->delete();
            $message = "Laporan transaksi berhasil dihapus.";
        } else {
            $report->delete();
            $message = "Laporan berhasil dihapus.";
        }

        return redirect()->route('reports.index')->with('success', $message);
    }
}
