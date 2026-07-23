<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spareparts = SparePart::orderBy('category')->paginate(15);
        return view('admin.spareparts.index', compact('spareparts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.spareparts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('spareparts', 'public');
        }

        SparePart::create($data);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SparePart $sparepart)
    {
        return view('admin.spareparts.edit', compact('sparepart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SparePart $sparepart)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            if ($sparepart->image_path) {
                Storage::disk('public')->delete($sparepart->image_path);
            }
            $data['image_path'] = $request->file('image')->store('spareparts', 'public');
        }

        $sparepart->update($data);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SparePart $sparepart)
    {
        if ($sparepart->image_path) {
            Storage::disk('public')->delete($sparepart->image_path);
        }
        $sparepart->delete();
        
        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil dihapus.');
    }
}
