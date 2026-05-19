<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Province::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $provinces = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master.provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.master.provinces.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:provinces']);
        \App\Models\Province::create($request->all());
        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $province = \App\Models\Province::findOrFail($id);
        return view('admin.master.provinces.edit', compact('province'));
    }

    public function update(Request $request, string $id)
    {
        $province = \App\Models\Province::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:provinces,name,' . $province->id]);
        $province->update($request->all());
        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $province = \App\Models\Province::findOrFail($id);
        $province->delete();
        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil dihapus.');
    }
}
