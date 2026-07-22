<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:30',
            'expertise' => 'nullable|string|max:150',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'mekanik',
            ]);

            Mechanic::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'expertise' => $validated['expertise'] ?? null,
            ]);
        });

        return redirect()->route('mechanics.index')->with('success', 'Mekanik dan Akun berhasil ditambahkan!');
    }

    public function edit(Mechanic $mechanic)
    {
        return view('mechanics.create', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($mechanic->user_id)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($mechanic->user_id)],
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:30',
            'expertise' => 'nullable|string|max:150',
        ]);

        DB::transaction(function () use ($validated, $mechanic) {
            $mechanic->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'expertise' => $validated['expertise'] ?? null,
            ]);

            if ($mechanic->user_id) {
                $userData = [
                    'name' => $validated['name'],
                ];
                if (!empty($validated['username'])) $userData['username'] = $validated['username'];
                if (!empty($validated['email'])) $userData['email'] = $validated['email'];
                if (!empty($validated['password'])) $userData['password'] = Hash::make($validated['password']);
                
                $mechanic->user->update($userData);
            }
        });

        return redirect()->route('mechanics.index')->with('success', 'Mekanik berhasil diperbarui!');
    }

    public function destroy(Mechanic $mechanic)
    {
        DB::transaction(function () use ($mechanic) {
            if ($mechanic->user) {
                $mechanic->user->delete();
            }
            $mechanic->delete();
        });
        
        return redirect()->route('mechanics.index')->with('success', 'Mekanik dan Akun berhasil dihapus!');
    }
}
