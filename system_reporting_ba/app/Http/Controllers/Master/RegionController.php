<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = \App\Models\Region::withCount('areas')->paginate(10);
        return view('admin.master.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.master.regions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:regions']);
        \App\Models\Region::create($request->all());
        return redirect()->route('admin.regions.index')->with('success', 'Region berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $region = \App\Models\Region::findOrFail($id);
        return view('admin.master.regions.edit', compact('region'));
    }

    public function update(Request $request, string $id)
    {
        $region = \App\Models\Region::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:regions,name,' . $region->id]);
        $region->update($request->all());
        return redirect()->route('admin.regions.index')->with('success', 'Region berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $region = \App\Models\Region::findOrFail($id);
        $region->delete();
        return redirect()->route('admin.regions.index')->with('success', 'Region berhasil dihapus.');
    }
}
