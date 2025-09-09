<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = \App\Models\Agent::all();
        if (request()->has('export') && request('export') === 'excel') {
            $path = \App\Helpers\ExcelExportHelper::exportAgents($agents);
            return response()->download($path)->deleteFileAfterSend(true);
        }
        if (request()->has('export') && request('export') === 'pdf') {
            $pdf = \PDF::loadView('agents.export_pdf', compact('agents'));
            return $pdf->download('agents.pdf');
        }
        return view('agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('agents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'nullable|string|max:20',
        ]);
        $agent = \App\Models\Agent::create($request->all());
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Menambah agent ID: ' . $agent->id,
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('agents.index')->with('success', 'Agent berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $agent = \App\Models\Agent::findOrFail($id);
    return view('agents.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $agent = \App\Models\Agent::findOrFail($id);
    return view('agents.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);
        $agent = \App\Models\Agent::findOrFail($id);
        $agent->update($request->all());
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'Update agent ID: ' . $agent->id,
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('agents.index')->with('success', 'Agent berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $agent = \App\Models\Agent::findOrFail($id);
    $agent->delete();
    \App\Models\AuditLog::create([
        'user_id' => auth()->id(),
        'action' => 'delete',
        'description' => 'Hapus agent ID: ' . $id,
        'ip_address' => request()->ip(),
    ]);
    return redirect()->route('agents.index')->with('success', 'Agent berhasil dihapus');
    }
}
