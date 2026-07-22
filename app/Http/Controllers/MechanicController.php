<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $mechanics = Mechanic::when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('expertise', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12);

        return view('mechanics.index', compact('mechanics', 'search'));
    }

    public function create()
    {
        return view('mechanics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'expertise' => 'nullable|string|max:150',
        ]);

        Mechanic::create($validated);
        return redirect()->route('mechanics.index')->with('success', 'Mekanik berhasil ditambahkan!');
    }

    public function edit(Mechanic $mechanic)
    {
        return view('mechanics.create', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'expertise' => 'nullable|string|max:150',
        ]);

        $mechanic->update($validated);
        return redirect()->route('mechanics.index')->with('success', 'Mekanik berhasil diperbarui!');
    }

    public function destroy(Mechanic $mechanic)
    {
        $mechanic->delete();
        return redirect()->route('mechanics.index')->with('success', 'Mekanik berhasil dihapus!');
    }
}
