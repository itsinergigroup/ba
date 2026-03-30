<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Outlet::with(['city.province']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('city', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhereHas('province', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $outlets = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master.outlets.index', compact('outlets'));
    }

    public function create()
    {
        $provinces = \App\Models\Province::all();
        return view('admin.master.outlets.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);
        \App\Models\Outlet::create($request->all());
        return redirect()->route('admin.outlets.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $outlet = \App\Models\Outlet::findOrFail($id);
        $provinces = \App\Models\Province::all();
        $cities = \App\Models\City::where('province_id', $outlet->city->province_id)->get();
        return view('admin.master.outlets.edit', compact('outlet', 'provinces', 'cities'));
    }

    public function update(Request $request, string $id)
    {
        $outlet = \App\Models\Outlet::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
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
