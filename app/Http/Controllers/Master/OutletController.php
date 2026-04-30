<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Outlet;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Outlet::with(['area.region']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('area', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $outlets = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master.outlets.index', compact('outlets'));
    }

    public function create()
    {
        $areas = Area::orderBy('name')->get();
        return view('admin.master.outlets.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'area_id' => 'required|exists:areas,id',
        ]);
        Outlet::create($request->all());
        return redirect()->route('admin.outlets.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $outlet = Outlet::findOrFail($id);
        $areas = Area::orderBy('name')->get();
        return view('admin.master.outlets.edit', compact('outlet', 'areas'));
    }

    public function update(Request $request, string $id)
    {
        $outlet = Outlet::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'area_id' => 'required|exists:areas,id',
        ]);
        $outlet->update($request->all());
        return redirect()->route('admin.outlets.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $outlet = \App\Models\Outlet::findOrFail($id);
        $outlet->delete();
        return redirect()->route('admin.outlets.index')->with('success', 'Toko berhasil dihapus.');
    }
}
