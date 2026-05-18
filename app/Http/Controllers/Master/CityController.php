<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\City::with('province');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('province', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $cities = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master.cities.index', compact('cities'));
    }

    public function create()
    {
        $provinces = \App\Models\Province::all();
        return view('admin.master.cities.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ]);
        \App\Models\City::create($request->all());
        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $city = \App\Models\City::findOrFail($id);
        $provinces = \App\Models\Province::all();
        return view('admin.master.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, string $id)
    {
        $city = \App\Models\City::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ]);
        $city->update($request->all());
        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $city = \App\Models\City::findOrFail($id);
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil dihapus.');
    }
}
