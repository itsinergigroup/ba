<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Distributor::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $distributors = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master.distributors.index', compact('distributors'));
    }

    public function create()
    {
        return view('admin.master.distributors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:distributors']);
        \App\Models\Distributor::create($request->all());
        return redirect()->route('admin.distributors.index')->with('success', 'Distributor berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $distributor = \App\Models\Distributor::findOrFail($id);
        return view('admin.master.distributors.edit', compact('distributor'));
    }

    public function update(Request $request, string $id)
    {
        $distributor = \App\Models\Distributor::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:distributors,name,' . $distributor->id]);
        $distributor->update($request->all());
        return redirect()->route('admin.distributors.index')->with('success', 'Distributor berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $distributor = \App\Models\Distributor::findOrFail($id);
        $distributor->delete();
        return redirect()->route('admin.distributors.index')->with('success', 'Distributor berhasil dihapus.');
    }
}
