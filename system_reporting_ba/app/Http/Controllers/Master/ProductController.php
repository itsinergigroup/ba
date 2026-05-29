<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Product::with('brand');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $brands = \App\Models\Brand::all();

        return view('admin.master.products.index', compact('products', 'brands'));
    }

    public function create()
    {
        $brands = \App\Models\Brand::all();
        return view('admin.master.products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'het' => str_replace('.', '', $request->het),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'het' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:50|unique:products,barcode',
        ]);
        \App\Models\Product::create($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $brands = \App\Models\Brand::all();
        return view('admin.master.products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $request->merge([
            'het' => str_replace('.', '', $request->het),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'het' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $product->id,
        ]);
        $product->update($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.products.index')->with('error', 'Produk tidak dapat dihapus karena masih digunakan oleh data lain.');
            }
            throw $e;
        }
    }
}
