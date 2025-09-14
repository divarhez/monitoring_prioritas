<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\PriorityUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $queryUsers = User::query();

        if ($search = $request->input('q')) {
            $queryUsers->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $queryUsers->orderBy('name')->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|string|in:admin,agent,user,helpdesk',
            'department' => 'nullable|string|max:255',
            'position'   => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => $validated['role'],
            'department' => $validated['department'] ?? null,
            'position'   => $validated['position'] ?? null,
            'phone'      => $validated['phone'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'   => 'nullable|string|min:8|confirmed',
            'role'       => 'required|string|in:admin,agent,user,helpdesk',
            'department' => 'nullable|string|max:255',
            'position'   => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
        ]);

        $data = [
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'role'       => $validated['role'],
            'department' => $validated['department'] ?? null,
            'position'   => $validated['position'] ?? null,
            'phone'      => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
