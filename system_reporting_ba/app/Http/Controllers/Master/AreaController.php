<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = \App\Models\Area::with('region')->orderBy('name')->paginate(10);
        return view('admin.master.areas.index', compact('areas'));
    }

    public function create()
    {
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.master.areas.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id'
        ]);
        \App\Models\Area::create($request->all());
        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $area = \App\Models\Area::findOrFail($id);
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.master.areas.edit', compact('area', 'regions'));
    }

    public function update(Request $request, string $id)
    {
        $area = \App\Models\Area::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id'
        ]);
        $area->update($request->all());
        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $area = \App\Models\Area::findOrFail($id);
        $area->delete();
        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil dihapus.');
    }
}
