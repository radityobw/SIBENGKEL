<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display a listing of the admins.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admins.index')->with('success', 'Akun Admin berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(User $admin)
    {
        // Pastikan hanya bisa edit role admin
        if ($admin->role !== 'admin') {
            abort(404);
        }
        
        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class.',username,'.$admin->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        
        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Akun Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        if ($admin->id === $request->user()->id) {
            return redirect()->route('admins.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        $admin->delete();
        
        return redirect()->route('admins.index')->with('success', 'Akun Admin berhasil dihapus!');
    }
}
