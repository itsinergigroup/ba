<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = \App\Models\Brand::all();
        return view('admin.master.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.master.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:brands']);
        \App\Models\Brand::create($request->all());
        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $brand = \App\Models\Brand::findOrFail($id);
        return view('admin.master.brands.edit', compact('brand'));
    }

    public function update(Request $request, string $id)
    {
        $brand = \App\Models\Brand::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:brands,name,' . $brand->id]);
        $brand->update($request->all());
        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            $brand = \App\Models\Brand::findOrFail($id);
            $brand->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.brands.index')->with('error', 'Brand tidak dapat dihapus karena masih digunakan oleh data lain.');
            }
            throw $e;
        }
    }
}
