<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MaintenanceSchedule;
use App\Models\Agent;
use App\Http\Requests\PriorityUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $queryUsers = User::where('role', 'user');

        if ($search = $request->input('q')) {
            $queryUsers->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $queryUsers->orderBy('name')->paginate(10)->withQueryString();

        $schedules = MaintenanceSchedule::with(['user','agent'])
            ->when($request->filled('agent_id'), fn ($q) => $q->where('agent_id', $request->agent_id))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('scheduled_date', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('scheduled_date', '<=', $request->date_to))
            ->orderBy('scheduled_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $agents = Agent::orderBy('name')->get();

        return view('users.index', compact('users', 'schedules', 'agents'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(PriorityUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'       => trim($validated['name']),
            'role'       => 'user',
            'department' => trim($validated['department']),
            'position'   => trim($validated['position']),
            'phone'      => trim($validated['phone']),
            // User prioritas tidak untuk login; tidak membuat kredensial
            'email'      => null,
            'password'   => null,
        ]);

        return redirect()->route('users.index')->with('success', 'User Prioritas berhasil ditambahkan.');
    }
}
